import assert from "node:assert/strict";
import { readFile } from "node:fs/promises";
import test from "node:test";
import vm from "node:vm";

const source = await readFile("resources/js/controllers/session_recovery_controller.js", "utf8");

function loadController() {
    const script = source
        .replace('import { Controller } from "@hotwired/stimulus";\n', "")
        .replace("export default class extends Controller", "class SessionRecoveryController extends Controller")
        .concat("\nglobalThis.SessionRecoveryController = SessionRecoveryController;");
    const context = {
        Controller: class {},
        Headers,
        FormData,
        URLSearchParams,
        console,
        Date,
        Promise,
        setTimeout,
        document: {
            addEventListener: () => {},
            removeEventListener: () => {},
        },
    };

    vm.runInNewContext(script, context);

    return context.SessionRecoveryController;
}

test("pauses an expiring Turbo request and resumes it with a fresh CSRF token", async () => {
    const SessionRecoveryController = loadController();
    const controller = new SessionRecoveryController();
    let resumed = false;
    let prevented = false;

    controller.getTokenExpiration = () => Date.now() - 1;
    controller.fetchFreshToken = async () => "fresh-token";
    controller.updateCsrfToken = () => {};

    const event = {
        detail: {
            fetchOptions: { headers: {} },
            resume: () => {
                resumed = true;
            },
        },
        preventDefault: () => {
            prevented = true;
        },
    };

    await controller.handleBeforeFetchRequest(event);

    assert.equal(prevented, true);
    assert.equal(resumed, true);
    assert.equal(new Headers(event.detail.fetchOptions.headers).get("X-CSRF-TOKEN"), "fresh-token");
});

test("connects without attempting to replay a failed request", () => {
    const SessionRecoveryController = loadController();
    const controller = new SessionRecoveryController();

    controller.getTokenExpiration = () => Date.now();
    controller.updateTokenExpiration = () => {};

    assert.doesNotThrow(() => controller.connect());
});
