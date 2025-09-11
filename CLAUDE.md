# SimpleTimer - Development Guidelines

## Load Order (Global → Project)

Claude reads docs in this order. Later sources override earlier:

### 1. Global Framework (base conventions)
- `~/work/claude-framework/agent_docs/_index.md` - core docs
- `~/work/claude-framework/skills/` - reusable skills

### 2. Project Overrides (project-specific)
- `.claude/agent_docs/` - override/extend framework docs
- `.claude/skills/` - project-specific skills

**Override rule:** If file exists in both locations, project version wins.

---

## Quick Context

**SimpleTimer** is a self-hosted, single-user time tracking application for freelancers and consultants.

### Tech Stack
- **Backend:** PHP 8.4 + Laravel 12
- **Frontend:** Hotwire (Turbo + Stimulus)
- **Templates:** Server-rendered Blade
- **Testing:** PHPUnit 12
- **Database:** SQLite (default)
- **Styling:** Tailwind CSS + DaisyUI

### Key Features
- One-click timer with keyboard shortcuts
- Client and project management
- Multi-currency support (56 currencies)
- Reports with CSV export
- User preferences for date/time formatting

### Architecture
- Server-rendered HTML over HTTP (no JSON APIs)
- Stimulus controllers for interactivity
- Service layer for business logic
- Action classes for discrete operations
- Value Objects (Money) for domain concepts
