import { Controller } from "@hotwired/stimulus";

// Connects to data-controller="subdomain-preview"
export default class extends Controller {
    static targets = ["input", "preview"];

    updatePreview() {
        const value = this.inputTarget.value.trim();
        this.previewTarget.textContent = value || "username";
    }
}
