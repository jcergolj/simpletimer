# SimpleTimer

> Simple time tracking for freelancers and consultants who bill by the hour. One click. No bloat. No onboarding.

## What It Is

SimpleTimer is a self-hosted time tracking web application. Create a client, add a project, start timing — under 30 seconds from your dashboard. No page hopping, no context switching, no setup ceremony.

Built for solo freelancers, senior developers, and consultants who just want the number to invoice.

## Core Features

- **One-Click Timer** — Start and stop with a single click. Keyboard shortcuts: Ctrl+Shift+S (start/stop), Ctrl+Shift+T (stop). Timer survives page refreshes.
- **Client & Project Management** — Create clients and projects inline from the same dropdown. No separate forms. Set hourly rates per client or project.
- **Multi-Currency Support** — 56 currencies supported. Track international earnings with per-client and per-project rates.
- **Reports & CSV Export** — Filter by date, client, or project. Export clean CSVs ready for any invoicing tool. Total hours + earnings per project.
- **Privacy & Control** — Self-host on your own server. Your data never leaves your infrastructure. No vendor lock-in.

## Deployment Modes

- **Single-User Mode (Default)** — One user, one domain, one SQLite database. Simplest setup. Toggle with `SINGLE_USER_MODE=true` in `.env`.
- **Multi-Tenant Mode** — Multiple users with isolated subdomain + database per tenant (e.g., `alice.yourdomain.com`). Toggle with `SINGLE_USER_MODE=false`. Requires wildcard DNS.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.4, SQLite/MySQL/PostgreSQL
- **Frontend:** Hotwire (Turbo + Stimulus), Tailwind CSS + DaisyUI, Importmap (no build step)
- **Testing:** PHPUnit, Pint, Larastan, Rector

## Pricing & Licensing

- **Self-Hosted:** Free forever. Full source code. Complete data control. Community support via GitHub.
- **Managed SaaS:** €59/year. 60-day free trial. Unlimited clients & projects. Cancel anytime. 60-day money-back guarantee.
- **License:** O'Saasy License — free to self-host forever, SaaS rights reserved. See https://osaasy.dev/

## Quick Start

1. **Self-host:** `git clone https://github.com/jcergolj/simpletimer.git && cd simpletimer && ./install.sh`
2. **Managed:** Register at https://simpletimerapp.com/register

Requirements: PHP 8.4+. Works on DigitalOcean, Vultr, Linode, or your laptop. Install time: ~15 minutes.

## Resources

- **Website:** https://simpletimerapp.com
- **GitHub:** https://github.com/jcergolj/simpletimer
- **Register:** https://simpletimerapp.com/register
- **License:** https://osaasy.dev/
- **Issues:** https://github.com/jcergolj/simpletimer/issues

## Philosophy

No onboarding. No tutorials. No dashboards full of features you'll never use. Just track time, see what to invoice, move on. Own your data. Pay nothing. Forever.
