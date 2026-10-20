# SimpleTimer

> Simple time tracking for freelance developers and consultants who bill by the hour. Know exactly what to invoice, without another complicated app.

## What It Is

SimpleTimer is a time tracking web application available as a hosted service or a self-hosted installation. Track client work, review hours and billable totals, and export reports for your existing invoicing workflow.

Built for independent developers and consultants who manage their own clients. It is not a team-management, employee-monitoring, or accounting platform. SimpleTimer produces reports, not invoices.

## Core Features

- **One-Click Timer** — Start and stop with a single click. Keyboard shortcuts: Ctrl+Shift+S (start/stop), Ctrl+Shift+T (stop). Timer survives page refreshes.
- **Manual Time Entries** — Add time manually when you forget to start the timer.
- **Client & Project Management** — Organise work by client and project. Set hourly rates per client or project.
- **Multi-Currency Support** — 56 currencies supported. Track international earnings with per-client and per-project rates.
- **Reports & CSV Export** — Filter by date, client, or project. Review hours and billable totals, then export CSV reports. Use the totals to create invoices in your existing invoicing tool.
- **Privacy & Control** — No screenshots, activity scores, or mouse tracking. Export your time reports as CSV files. Self-hosting is optional and free. In that mode, you manage the server and data yourself.

## Hosted Service

Use SimpleTimer in your browser without setting up a server. Hosting is included.

Hosted for you: {{ config('app.yearly_price') }}/year with a {{ config('app.trial_period_days') }}-day free trial.
All features and unlimited clients and projects are included. Try it on real client work before deciding whether to subscribe.

Register: https://simpletimerapp.com/register

## Self-Hosted Deployment Modes

- **Single-User Mode (Default)** — One user, one domain, one SQLite database. Simplest setup. Toggle with `SINGLE_USER_MODE=true` in `.env`.
- **Multi-Tenant Mode** — Multiple users with isolated subdomain + database per tenant (e.g., `alice.yourdomain.com`). Toggle with `SINGLE_USER_MODE=false`. Requires wildcard DNS.

## Tech Stack

- **Backend:** Laravel 13, PHP, SQLite by default
- **Frontend:** Hotwire (Turbo + Stimulus), Tailwind CSS + DaisyUI, Importmap (no build step)
- **Testing:** PHPUnit, Pint, Larastan, Rector

## Pricing & Licensing

- **Hosted:** {{ config('app.yearly_price') }}/year after a {{ config('app.trial_period_days') }}-day free trial. All features and hosting included.
- **Self-Hosted:** Free. Full source code. Manage your own server, updates, and data. Community support via GitHub.
- **License:** O'Saasy License — free to self-host forever, SaaS rights reserved. See https://osaasy.dev/

## Quick Start

1. **Hosted:** Start a free trial at https://simpletimerapp.com/register
2. **Self-host:** Follow the installation instructions at https://github.com/jcergolj/simpletimer#readme

For current self-hosting requirements and setup steps, see the repository README.

## Resources

- **Website:** https://simpletimerapp.com
- **GitHub:** https://github.com/jcergolj/simpletimer
- **Register:** https://simpletimerapp.com/register
- **License:** https://osaasy.dev/
- **Issues:** https://github.com/jcergolj/simpletimer/issues

## Philosophy

Track your work. Check your totals. Get on with your day. Keep time tracking separate from accounting and use the invoicing workflow you already know. Choose hosted convenience or manage your own free self-hosted installation.
