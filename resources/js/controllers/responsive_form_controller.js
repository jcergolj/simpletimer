import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.handleSubmit = this.handleSubmit.bind(this);
        this.element.addEventListener("submit", this.handleSubmit);
    }

    disconnect() {
        this.element.removeEventListener("submit", this.handleSubmit);
    }

    handleSubmit() {
        this.element.querySelectorAll("[data-responsive-form-layout]").forEach((layout) => {
            const isVisible = layout.offsetParent !== null;

            layout.querySelectorAll("input, select, textarea, button").forEach((control) => {
                control.disabled = !isVisible;
            });
        });
    }
}
