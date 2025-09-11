import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["dateFrom", "dateTo", "dateRange"];

    clearDateInputs() {
        this.dateFromTargets.forEach((target) => (target.value = ""));
        this.dateToTargets.forEach((target) => (target.value = ""));
    }

    clearDateRange() {
        this.dateRangeTargets.forEach((target) => (target.value = ""));
    }
}
