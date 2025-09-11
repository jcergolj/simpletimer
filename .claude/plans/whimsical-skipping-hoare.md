# Fix Search/Filter Height Inconsistencies

## Problem
Input fields (40px via DaisyUI `--size`) don't match button heights on clients/projects index pages. Clear link also has inconsistent styling.

## Root Cause
- `.input` class: `height: var(--size)` = 40px (DaisyUI)
- `.btn-primary`: No height/padding defined
- `icon-button`: Uses inline-flex + line-height:1 only
- Clear link: Inline `padding: 14px 24px` (different sizing)

## Solution

### 1. Add `.btn-field` CSS class (app.css)
```css
.btn-field {
    @apply h-10 px-6 text-sm rounded-lg;
}
```
Matches DaisyUI input height (2.5rem = 40px = h-10)

### 2. Update `icon-button.blade.php`
Add `btn-field` class to default merge

### 3. Update `icon-link.blade.php`
Add `btn-field` class to default merge

### 4. Create `x-form.button.clear` component
New component for clear/reset links with consistent styling

### 5. Update index pages
- `clients/index.blade.php`: Use new clear button component
- `projects/index.blade.php`: Use new clear button component

## Files to Modify
1. `resources/css/app.css` - Add `.btn-field` class
2. `resources/views/components/icon-button.blade.php`
3. `resources/views/components/icon-link.blade.php`
4. `resources/views/components/form/button/clear.blade.php` (new)
5. `resources/views/clients/index.blade.php`
6. `resources/views/projects/index.blade.php`

## Verification
1. Run `npm run build`
2. Visual check: clients index page - input and buttons same height
3. Visual check: projects index page - input and buttons same height
4. Test clear link hover state
