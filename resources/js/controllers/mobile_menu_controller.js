import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu", "openIcon", "closeIcon", "button", "label"]

    toggle() {
        const isCurrentlyHidden = this.menuTarget.classList.contains('hidden')

        if (isCurrentlyHidden) {
            this.menuTarget.classList.remove('hidden')
            this.openIconTarget.classList.add('hidden')
            this.closeIconTarget.classList.remove('hidden')
            this.buttonTarget.setAttribute('aria-expanded', 'true')
            this.buttonTarget.setAttribute('aria-label', 'Close main menu')
            this.labelTarget.textContent = 'Close main menu'
        } else {
            this.menuTarget.classList.add('hidden')
            this.openIconTarget.classList.remove('hidden')
            this.closeIconTarget.classList.add('hidden')
            this.buttonTarget.setAttribute('aria-expanded', 'false')
            this.buttonTarget.setAttribute('aria-label', 'Open main menu')
            this.labelTarget.textContent = 'Open main menu'
        }
    }

    close() {
        if (!this.menuTarget.classList.contains('hidden')) {
            this.toggle()
        }
    }
}
