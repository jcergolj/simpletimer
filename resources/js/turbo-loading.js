// Enhanced Turbo Frame Loading States
document.addEventListener('turbo:frame-missing', function (event) {
    console.warn('Turbo frame missing:', event.detail);
});

document.addEventListener('turbo:before-fetch-request', function (event) {
    const frame = event.target.closest('turbo-frame');

    if (!frame || !frame.id.includes('project-filter')) {
        return;
    }

    frame.setAttribute('aria-busy', 'true');

    const select = frame.querySelector('select');

    if (select) {
        select.style.opacity = '0.7';
        select.style.backgroundColor = '#f9fafb';
    }
});

document.addEventListener('turbo:frame-load', function (event) {
    const frame = event.target;

    if (!frame || !frame.id.includes('project-filter')) {
        return;
    }

    frame.removeAttribute('aria-busy');

    const select = frame.querySelector('select');

    if (select) {
        select.style.opacity = '';
        select.style.backgroundColor = '';
    }
});

document.addEventListener('turbo:frame-render', function (event) {
    const frame = event.target;

    if (frame?.id.includes('project-filter')) {
        frame.removeAttribute('aria-busy');
    }
});
