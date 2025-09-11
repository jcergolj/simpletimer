<meta charset="utf-8" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0{{ $scalable ?? false ? ', maximum-scale=1.0, user-scalable=0' : '' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="project-filter-route" content="{{ route('project-filter') }}">

@if ($transitions ?? false)
    <meta name="view-transition" content="same-origin">
@endif

<title>{{ $title ?? config('app.name') }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Sans+3:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<link href="{{ tailwindcss('css/app.css') }}" rel="stylesheet" data-turbo-track="reload" />

<style>
    :root {
        /* Warm Earth Base Colors */
        --color-bg: #F5F1EB;
        --color-surface: #FFFFFF;
        --color-text: #2D2A26;
        --color-text-secondary: #8B775B;
        --color-text-muted: #A8A097;

        /* Visible Tan Borders */
        --color-border: #D4C8B8;
        --color-border-light: #E8E0D5;

        /* Primary - Warm Teal */
        --color-primary: #0D9488;
        --color-primary-hover: #0F766E;
        --color-primary-light: #CCFBF1;

        /* Accent (same as primary) */
        --color-accent: #0D9488;
        --color-accent-hover: #0F766E;
        --color-accent-light: #CCFBF1;

        /* Edit - Warm Brown */
        --color-edit: #8B775B;
        --color-edit-hover: #6B5B45;

        /* Filter - Dark Brown */
        --color-filter: #2D2A26;
        --color-filter-hover: #1F1D1A;

        /* Generate - Indigo */
        --color-generate: #6366F1;
        --color-generate-hover: #4F46E5;

        /* Success/Export - Green */
        --color-success: #059669;
        --color-success-hover: #047857;
        --color-success-light: #D1FAE5;

        /* Danger - Red */
        --color-danger: #DC2626;
        --color-danger-hover: #B91C1C;
        --color-danger-light: #FEE2E2;

        /* Dark Brown Navigation */
        --color-nav-bg: #2D2A26;
        --color-nav-text: #F5F1EB;
        --color-nav-text-muted: #A8A097;
        --color-nav-active: #4A4640;
        --color-nav-hover: #3D3A36;

        /* Typography */
        --font-display: 'Inter', sans-serif;
        --font-body: 'Source Sans 3', sans-serif;
        --font-mono: 'DM Mono', monospace;

        /* Easing */
        --ease-smooth: cubic-bezier(0.4, 0.0, 0.2, 1);
        --ease-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);

        /* Legacy variable support */
        --bg: var(--color-bg);
        --card: var(--color-surface);
        --text: var(--color-text);
        --text-secondary: var(--color-text-secondary);
        --text-muted: var(--color-text-muted);
        --border: var(--color-border);
        --accent: var(--color-primary);
        --accent-light: var(--color-primary-light);
    }

    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    body {
        font-family: var(--font-body);
        background: var(--color-bg);
        color: var(--color-text);
    }

    .font-display {
        font-family: var(--font-display);
        letter-spacing: -0.02em;
        font-weight: 700;
    }

    /* Card styles - Warm Earth with visible tan borders */
    .card {
        background: var(--color-surface);
        border-radius: 12px;
        border: 2px solid var(--color-border);
        box-shadow: 0 2px 8px rgba(139, 119, 91, 0.08);
        transition: all 0.3s var(--ease-smooth);
    }

    .card:hover {
        border-color: var(--color-border);
        box-shadow: 0 4px 16px rgba(139, 119, 91, 0.12);
    }

    /* Button styles */
    .btn-primary {
        background: var(--accent);
        color: white;
        transition: background-color 0.3s var(--ease-smooth);
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 14px 24px;
        font-family: var(--font-body);
        font-size: 15px;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: var(--color-primary-hover);
    }

    .btn-primary:active {
        transform: translateY(0) scale(1);
    }

    .btn-secondary {
        border: 2px solid var(--color-border);
        color: var(--color-text);
        background: var(--color-surface);
        transition: all 0.3s var(--ease-smooth);
        font-weight: 600;
        border-radius: 12px;
        padding: 14px 24px;
        font-family: var(--font-body);
        font-size: 15px;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .btn-secondary:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(13, 148, 136, 0.15);
    }

    .btn-secondary:active {
        transform: translateY(0);
    }

    /* Input styles */
    .input-field {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--color-border);
        border-radius: 8px;
        background: var(--color-surface);
        font-family: var(--font-body);
        font-size: 15px;
        font-weight: 500;
        color: var(--color-text);
        transition: all 0.2s var(--ease-smooth);
    }

    .input-field:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px var(--color-primary-light);
    }

    .input-field:hover {
        border-color: var(--color-text-muted);
    }

    textarea.input-field {
        resize: vertical;
        min-height: 100px;
    }

    /* Label styles */
    .label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-secondary);
        margin-bottom: 8px;
    }

    /* Stat styles - Warm Earth */
    .stat-label {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-secondary);
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 42px;
        font-weight: 700;
        color: var(--color-text);
        letter-spacing: -1px;
        font-family: var(--font-display);
    }

    .stat-value-accent {
        color: var(--color-primary);
    }

    /* Entry info */
    .entry-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-muted);
        margin-bottom: 6px;
    }

    .entry-value {
        font-size: 16px;
        font-weight: 600;
        color: var(--color-text);
    }

    .entry-amount {
        font-family: var(--font-mono);
        font-size: 24px;
        font-weight: 500;
        color: var(--color-text);
    }

    /* Navigation Enhancement */
    nav {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.95) !important;
        border-bottom: 1px solid var(--color-border-light);
    }

    /* Link Styles */
    a.link-hover {
        position: relative;
        transition: color 0.3s var(--ease-smooth);
    }

    a.link-hover::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: currentColor;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s var(--ease-smooth);
    }

    a.link-hover:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }
</style>

<x-importmap::tags />
