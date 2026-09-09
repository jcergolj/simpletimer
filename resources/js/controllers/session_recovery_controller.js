import { Controller } from "@hotwired/stimulus";

/**
 * Session Recovery Controller
 *
 * Handles expired sessions (419 errors) by attempting to refresh the CSRF token.
 * If the user is still authenticated (via Remember Me cookie), the request is retried.
 * If not authenticated, redirects to login page with session expired message.
 *
 * Also proactively refreshes tokens before form submissions if token is close to expiration.
 *
 * Usage: Add data-controller="session-recovery" to <body> or root element
 */
export default class extends Controller {
    static values = {
        sessionLifetime: { type: Number, default: 120 },
    };
    // Refresh token if within this many minutes of expiration
    static EXPIRATION_BUFFER = 5;

    isRefreshing = false;
    pendingRequests = [];

    connect() {
        this.handleBeforeFetchResponse = this.handleBeforeFetchResponse.bind(this);
        this.handleBeforeFetchRequest = this.handleBeforeFetchRequest.bind(this);
        this.handleFrameMissing = this.handleFrameMissing.bind(this);

        document.addEventListener("turbo:before-fetch-response", this.handleBeforeFetchResponse);
        document.addEventListener("turbo:before-fetch-request", this.handleBeforeFetchRequest);
        document.addEventListener("turbo:frame-missing", this.handleFrameMissing);

        // Initialize token expiration timestamp on first page load
        if (!this.getTokenExpiration()) {
            this.updateTokenExpiration();
        }

    }

    disconnect() {
        document.removeEventListener("turbo:before-fetch-response", this.handleBeforeFetchResponse);
        document.removeEventListener("turbo:before-fetch-request", this.handleBeforeFetchRequest);
        document.removeEventListener("turbo:frame-missing", this.handleFrameMissing);
    }

    async handleBeforeFetchResponse(event) {
        const response = event.detail.fetchResponse.response;

        if (response.status === 419) {
            event.preventDefault();
            await this.handle419Error(event);
        }
    }

    handleFrameMissing(event) {
        console.warn("Turbo frame missing:", event.detail);

        // Check if this was caused by a 419 error
        const response = event.detail.response;
        if (response?.status === 419) {
            event.preventDefault();
            this.redirectToLogin();
        }
    }

    async handleBeforeFetchRequest(event) {
        const expiresAt = this.getTokenExpiration();
        if (!expiresAt) {
            return;
        }

        const now = Date.now();
        const bufferMs = this.constructor.EXPIRATION_BUFFER * 60 * 1000;
        const timeUntilExpiration = expiresAt - now;

        if (timeUntilExpiration > bufferMs) {
            return;
        }

        event.preventDefault();

        if (this.isRefreshing) {
            await new Promise((resolve) => {
                this.pendingRequests.push(resolve);
            });

            const token = this.getCsrfToken();
            if (token) {
                this.setRequestCsrfToken(event.detail.fetchOptions, token);
                event.detail.resume();
            }

            return;
        }

        this.isRefreshing = true;
        try {
            const newToken = await this.fetchFreshToken();
            if (newToken) {
                this.updateCsrfToken(newToken);
                this.setRequestCsrfToken(event.detail.fetchOptions, newToken);
                this.pendingRequests.forEach((resolve) => resolve());
                this.pendingRequests = [];
                event.detail.resume();
            } else {
                this.redirectToLogin();
            }
        } catch (error) {
            console.error("Error refreshing token before request:", error);
            this.redirectToLogin();
        } finally {
            this.isRefreshing = false;
        }
    }


    updateTokenExpiration() {
        const now = Date.now();
        const expiresAt = now + this.sessionLifetimeValue * 60 * 1000;
        try {
            localStorage.setItem("csrf_token_expires_at", expiresAt.toString());
        } catch (error) {
            console.warn("Could not store token expiration in localStorage:", error);
        }
    }

    getTokenExpiration() {
        try {
            const expiresAt = localStorage.getItem("csrf_token_expires_at");
            return expiresAt ? parseInt(expiresAt, 10) : null;
        } catch (error) {
            console.warn("Could not read token expiration from localStorage:", error);
            return null;
        }
    }

    isTokenExpiringSoon() {
        const expiresAt = this.getTokenExpiration();
        if (!expiresAt) {
            // No expiration stored - assume token is fresh
            return false;
        }

        const now = Date.now();
        const bufferMs = this.constructor.EXPIRATION_BUFFER * 60 * 1000;
        const timeUntilExpiration = expiresAt - now;

        // Return true if within buffer period or already expired
        return timeUntilExpiration <= bufferMs;
    }

    async handle419Error(event) {
        try {
            const newToken = await this.fetchFreshToken();

            if (newToken) {
                this.updateCsrfToken(newToken);
                window.location.reload();
            } else {
                this.redirectToLogin();
            }
        } finally {
            this.isRefreshing = false;
        }
    }

    async fetchFreshToken() {
        try {
            const response = await fetch("/api/csrf-token", {
                method: "GET",
                credentials: "same-origin",
                headers: {
                    Accept: "application/json",
                },
            });

            if (response.ok) {
                const data = await response.json();
                // Check if user is still authenticated
                if (data.authenticated === false) {
                    return null;
                }
                return data.token;
            }

            // 401 means not authenticated - Remember Me cookie expired/invalid
            if (response.status === 401) {
                return null;
            }

            console.error("Failed to fetch CSRF token:", response.status);
            return null;
        } catch (error) {
            console.error("Error fetching CSRF token:", error);
            return null;
        }
    }

    updateCsrfToken(token) {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            metaTag.setAttribute("content", token);
        }
        // Update expiration timestamp when token is refreshed
        this.updateTokenExpiration();
    }

    redirectToLogin() {
        const currentUrl = window.location.href;
        sessionStorage.setItem("intended_url", currentUrl);
        sessionStorage.setItem("session_expired", "1");
        window.location.href = "/login";
    }

    setRequestCsrfToken(fetchOptions, token) {
        const headers = new Headers(fetchOptions.headers || {});
        headers.set("X-CSRF-TOKEN", token);
        fetchOptions.headers = headers;
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || null;
    }
}
