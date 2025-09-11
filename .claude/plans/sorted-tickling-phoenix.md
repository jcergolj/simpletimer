# Plan: Improve CLAUDE.md and claude-framework Structure

## Goal
Establish clear hierarchy: global framework → project overrides, with explicit load order.

## Decisions Made
- Project docs: `.claude/agent_docs/`
- Project skills: `.claude/skills/`
- Framework path: `~/work/claude-framework/` (tilde, not relative)

---

## Changes

### 1. Update simpletimer/CLAUDE.md

**Current issues:**
- Uses fragile relative path `../../claude-framework/`
- No clear override instructions
- References non-standard paths

**New structure:**
```markdown
# SimpleTimer - Development Guidelines

## Load Order (Global → Project)

Claude reads docs in this order, later sources override earlier:

1. **Global Framework** (base conventions)
   - `~/work/claude-framework/agent_docs/_index.md`
   - `~/work/claude-framework/skills/`

2. **Project Overrides** (project-specific)
   - `.claude/agent_docs/` - override/extend framework docs
   - `.claude/skills/` - project-specific skills

If file exists in both, **project version wins**.

## Quick Context
[...existing project info...]
```

### 2. Restructure Project Folders

**Move:**
- `.ai/agent_docs/*` → `.claude/agent_docs/`
- Delete empty `.ai/` folder after move

**Create:**
- `.claude/skills/` (empty initially)

### 3. Update claude-framework/CLAUDE.md

**New content:**
```markdown
# Claude Framework - Global Conventions

Shared framework for all Laravel projects.

## Structure
- `agent_docs/` - Core docs (foundation, Laravel, testing, etc.)
- `skills/` - Reusable skill definitions
- `plugins/` - Plugin configurations

## Usage in Projects

Reference in project CLAUDE.md:
1. Global: `~/work/claude-framework/agent_docs/_index.md`
2. Project: `.claude/agent_docs/` (overrides)

## Override Rules
- Project `.claude/agent_docs/foundation.md` overrides framework `agent_docs/foundation.md`
- Project `.claude/skills/test-unit-job/` overrides framework `skills/test-unit-job/`
- Files only in framework = used as-is
- Files only in project = added to context
```

### 4. Update ~/.claude/CLAUDE.md

Add section:
```markdown
## Framework Integration
All projects use ~/work/claude-framework/ as base.
Check project `.claude/` folder for overrides.
```

---

## File Changes Summary

| File | Action |
|------|--------|
| `simpletimer/CLAUDE.md` | Rewrite with load order, tilde paths |
| `simpletimer/.ai/agent_docs/*` | Move to `.claude/agent_docs/` |
| `simpletimer/.ai/` | Delete after move |
| `simpletimer/.claude/skills/` | Create empty dir |
| `claude-framework/CLAUDE.md` | Rewrite with framework docs |
| `~/.claude/CLAUDE.md` | Add framework integration section |

---

## Verification

1. Confirm files moved: `ls .claude/agent_docs/`
2. Test override works with sample file
3. Verify no broken references in CLAUDE.md
