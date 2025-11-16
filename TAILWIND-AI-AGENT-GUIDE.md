# Tailwind CSS Migration Guide for AI Agents

## Overview

This document provides systematic instructions for AI agents (like GitHub Copilot, ChatGPT, Claude, etc.) to migrate Bootstrap, CoreUI, or AdminLTE code to Tailwind CSS.

## Core Principles

1. **Utility-First**: Replace component classes with utility classes
2. **Mobile-First**: Design for mobile, then add responsive variants
3. **Composition**: Combine single-purpose utilities instead of pre-built components
4. **Consistency**: Use Tailwind's spacing scale and color palette

## Automated Migration Rules

### Rule 1: Layout & Grid System

```
FIND: class="container"
REPLACE: class="container mx-auto px-4"

FIND: class="container-fluid"
REPLACE: class="w-full px-4"

FIND: class="row"
REPLACE: class="flex flex-wrap -mx-2"

FIND: class="col-{number}"
REPLACE: class="w-{fraction} px-2"
Examples:
- col-6 → w-1/2 px-2
- col-4 → w-1/3 px-2
- col-3 → w-1/4 px-2

FIND: class="col-{breakpoint}-{number}"
REPLACE: class="w-full {breakpoint}:w-{fraction} px-2"
Examples:
- col-md-6 → w-full md:w-1/2 px-2
- col-lg-4 → w-full lg:w-1/3 px-2
```

### Rule 2: Display Properties

```
FIND: class="d-none"
REPLACE: class="hidden"

FIND: class="d-block"
REPLACE: class="block"

FIND: class="d-inline-block"
REPLACE: class="inline-block"

FIND: class="d-flex"
REPLACE: class="flex"

FIND: class="d-{breakpoint}-{value}"
REPLACE: class="{breakpoint}:{value}"
Example: d-md-none → md:hidden
```

### Rule 3: Flexbox Utilities

```
FIND: class="flex-column"
REPLACE: class="flex-col"

FIND: class="justify-content-start"
REPLACE: class="justify-start"

FIND: class="justify-content-end"
REPLACE: class="justify-end"

FIND: class="justify-content-center"
REPLACE: class="justify-center"

FIND: class="justify-content-between"
REPLACE: class="justify-between"

FIND: class="justify-content-around"
REPLACE: class="justify-around"

FIND: class="align-items-start"
REPLACE: class="items-start"

FIND: class="align-items-end"
REPLACE: class="items-end"

FIND: class="align-items-center"
REPLACE: class="items-center"

FIND: class="align-items-baseline"
REPLACE: class="items-baseline"

FIND: class="align-items-stretch"
REPLACE: class="items-stretch"
```

### Rule 4: Spacing (Margin & Padding)

Bootstrap uses a scale of 0-5. Tailwind uses a more granular scale.

```
Mapping Guide:
Bootstrap 0 → Tailwind 0 (0rem)
Bootstrap 1 → Tailwind 1 (0.25rem)
Bootstrap 2 → Tailwind 2 (0.5rem)
Bootstrap 3 → Tailwind 4 (1rem)
Bootstrap 4 → Tailwind 6 (1.5rem)
Bootstrap 5 → Tailwind 8 (2rem)

Examples:
FIND: class="m-3"
REPLACE: class="m-4"

FIND: class="mt-4"
REPLACE: class="mt-6"

FIND: class="px-3"
REPLACE: class="px-4"

FIND: class="py-2"
REPLACE: class="py-2"

FIND: class="mx-auto"
REPLACE: class="mx-auto"
```

### Rule 5: Colors

```
Text Colors:
FIND: class="text-primary"
REPLACE: class="text-blue-600"

FIND: class="text-secondary"
REPLACE: class="text-gray-600"

FIND: class="text-success"
REPLACE: class="text-green-600"

FIND: class="text-danger"
REPLACE: class="text-red-600"

FIND: class="text-warning"
REPLACE: class="text-yellow-600"

FIND: class="text-info"
REPLACE: class="text-cyan-600"

FIND: class="text-muted"
REPLACE: class="text-gray-500"

Background Colors:
FIND: class="bg-primary"
REPLACE: class="bg-blue-600"

FIND: class="bg-success"
REPLACE: class="bg-green-600"

FIND: class="bg-danger"
REPLACE: class="bg-red-600"

FIND: class="bg-warning"
REPLACE: class="bg-yellow-600"

FIND: class="bg-light"
REPLACE: class="bg-gray-100"

FIND: class="bg-dark"
REPLACE: class="bg-gray-800"
```

### Rule 6: Typography

```
FIND: class="h1"
REPLACE: class="text-5xl font-bold"

FIND: class="h2"
REPLACE: class="text-4xl font-bold"

FIND: class="h3"
REPLACE: class="text-3xl font-bold"

FIND: class="h4"
REPLACE: class="text-2xl font-bold"

FIND: class="h5"
REPLACE: class="text-xl font-bold"

FIND: class="h6"
REPLACE: class="text-lg font-bold"

FIND: class="text-uppercase"
REPLACE: class="uppercase"

FIND: class="text-lowercase"
REPLACE: class="lowercase"

FIND: class="text-capitalize"
REPLACE: class="capitalize"

FIND: class="font-weight-bold"
REPLACE: class="font-bold"

FIND: class="font-weight-normal"
REPLACE: class="font-normal"

FIND: class="font-italic"
REPLACE: class="italic"

FIND: class="text-decoration-none"
REPLACE: class="no-underline"
```

### Rule 7: Borders

```
FIND: class="border"
REPLACE: class="border"

FIND: class="border-top"
REPLACE: class="border-t"

FIND: class="border-right"
REPLACE: class="border-r"

FIND: class="border-bottom"
REPLACE: class="border-b"

FIND: class="border-left"
REPLACE: class="border-l"

FIND: class="border-0"
REPLACE: class="border-0"

FIND: class="border-primary"
REPLACE: class="border-blue-600"

FIND: class="rounded"
REPLACE: class="rounded"

FIND: class="rounded-0"
REPLACE: class="rounded-none"

FIND: class="rounded-circle"
REPLACE: class="rounded-full"

FIND: class="rounded-lg"
REPLACE: class="rounded-lg"
```

### Rule 8: Sizing

```
FIND: class="w-25"
REPLACE: class="w-1/4"

FIND: class="w-50"
REPLACE: class="w-1/2"

FIND: class="w-75"
REPLACE: class="w-3/4"

FIND: class="w-100"
REPLACE: class="w-full"

FIND: class="w-auto"
REPLACE: class="w-auto"

FIND: class="h-25"
REPLACE: class="h-1/4"

FIND: class="h-50"
REPLACE: class="h-1/2"

FIND: class="h-75"
REPLACE: class="h-3/4"

FIND: class="h-100"
REPLACE: class="h-full"
```

### Rule 9: Position

```
FIND: class="position-static"
REPLACE: class="static"

FIND: class="position-relative"
REPLACE: class="relative"

FIND: class="position-absolute"
REPLACE: class="absolute"

FIND: class="position-fixed"
REPLACE: class="fixed"

FIND: class="position-sticky"
REPLACE: class="sticky"

FIND: class="top-0"
REPLACE: class="top-0"

FIND: class="bottom-0"
REPLACE: class="bottom-0"

FIND: class="start-0"
REPLACE: class="left-0"

FIND: class="end-0"
REPLACE: class="right-0"
```

## Component Migration Patterns

### Pattern 1: Cards

**Input (Bootstrap/CoreUI):**
```html
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Title</h3>
  </div>
  <div class="card-body">
    Content
  </div>
  <div class="card-footer">
    Footer
  </div>
</div>
```

**Output (Tailwind - Using Component Class):**
```html
<div class="card">
  <div class="card-header">
    <h3 class="text-lg font-semibold">Title</h3>
  </div>
  <div class="card-body">
    Content
  </div>
  <div class="card-footer">
    Footer
  </div>
</div>
```

**Output (Tailwind - Pure Utilities):**
```html
<div class="bg-white rounded-lg shadow">
  <div class="px-6 py-4 border-b border-gray-200">
    <h3 class="text-lg font-semibold">Title</h3>
  </div>
  <div class="p-6">
    Content
  </div>
  <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
    Footer
  </div>
</div>
```

### Pattern 2: Buttons

**Input:**
```html
<button class="btn btn-primary">Save</button>
<button class="btn btn-secondary btn-lg">Large</button>
<button class="btn btn-success btn-sm">Small Success</button>
```

**Output (Component Classes):**
```html
<button class="btn btn-primary">Save</button>
<button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded font-medium text-lg">Large</button>
<button class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded font-medium text-sm">Small Success</button>
```

### Pattern 3: Alerts

**Input:**
```html
<div class="alert alert-success" role="alert">
  Success message
</div>
```

**Output (Component Class):**
```html
<div class="alert alert-success" role="alert">
  Success message
</div>
```

**Output (Pure Utilities):**
```html
<div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-md" role="alert">
  Success message
</div>
```

### Pattern 4: Forms

**Input:**
```html
<div class="form-group">
  <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" id="email" placeholder="Email">
</div>
```

**Output (Component Classes):**
```html
<div class="mb-4">
  <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" id="email" placeholder="Email">
</div>
```

**Output (Pure Utilities):**
```html
<div class="mb-4">
  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
  <input 
    type="email" 
    id="email" 
    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
    placeholder="Email"
  >
</div>
```

### Pattern 5: Tables

**Input:**
```html
<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>John</td>
      <td>john@example.com</td>
    </tr>
  </tbody>
</table>
```

**Output (Component Class):**
```html
<table class="table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>John</td>
      <td>john@example.com</td>
    </tr>
  </tbody>
</table>
```

## Migration Workflow for AI Agents

### Step 1: Identify Component Type
Analyze the HTML to determine if it's a:
- Layout (grid/flexbox)
- Component (card, button, alert, etc.)
- Typography
- Spacing/sizing

### Step 2: Choose Migration Strategy

**Strategy A: Use Component Classes (Recommended)**
- For complex, frequently used patterns
- Use pre-defined classes from `resources/assets/css/app.css`
- Examples: `.card`, `.btn`, `.alert`, `.form-control`

**Strategy B: Pure Utility Classes**
- For simple, one-off designs
- For maximum flexibility
- When the component class doesn't exist

### Step 3: Apply Rules
1. Replace layout classes (container, row, col)
2. Replace display and flexbox classes
3. Replace spacing classes (m-, p-)
4. Replace color classes (text-, bg-)
5. Replace typography classes
6. Replace border and sizing classes
7. Add responsive variants where needed
8. Add hover/focus states for interactive elements

### Step 4: Add Responsive Breakpoints
Convert Bootstrap breakpoints to Tailwind:
- `col-sm-*` → `sm:w-*`
- `col-md-*` → `md:w-*`
- `col-lg-*` → `lg:w-*`
- `col-xl-*` → `xl:w-*`

### Step 5: Add Interactive States
Add hover, focus, and active states:
- Buttons: Add `hover:bg-*` and `focus:ring-*`
- Links: Add `hover:text-*` and `hover:underline`
- Inputs: Add `focus:outline-none focus:ring-* focus:border-*`

## Component Class Reference

The following component classes are pre-defined in `resources/assets/css/app.css`:

### Layout
- `.sidebar` - Sidebar container
- `.sidebar-nav` - Sidebar navigation
- `.nav-item` - Navigation item
- `.nav-link` - Navigation link
- `.app-header` - Header/navbar
- `.app-body` - Main content area
- `.main` - Page content container

### Components
- `.card` - Card container
- `.card-header` - Card header
- `.card-body` - Card body
- `.card-footer` - Card footer

### Widgets
- `.widget-card-primary` - Primary widget card
- `.widget-card-success` - Success widget card
- `.widget-card-warning` - Warning widget card
- `.widget-card-danger` - Danger widget card
- `.widget-card-info` - Info widget card

### Alerts
- `.alert` - Alert container
- `.alert-success` - Success alert
- `.alert-info` - Info alert
- `.alert-warning` - Warning alert
- `.alert-danger` - Danger alert

### Buttons
- `.btn` - Button base
- `.btn-primary` - Primary button
- `.btn-secondary` - Secondary button
- `.btn-success` - Success button
- `.btn-danger` - Danger button

### Forms
- `.form-control` - Form input
- `.form-label` - Form label

### Tables
- `.table` - Table base

### Badges
- `.badge` - Badge base
- `.badge-primary` - Primary badge
- `.badge-success` - Success badge
- `.badge-warning` - Warning badge
- `.badge-danger` - Danger badge

### Breadcrumbs
- `.breadcrumb` - Breadcrumb container
- `.breadcrumb-item` - Breadcrumb item

## Automated Migration Script Example

```bash
#!/bin/bash
# This is a conceptual example for automated migration

# Find all blade files
FILES=$(find resources/views -name "*.blade.php")

for FILE in $FILES; do
  # Replace common Bootstrap classes with Tailwind
  sed -i 's/class="container"/class="container mx-auto px-4"/g' "$FILE"
  sed -i 's/class="row"/class="flex flex-wrap -mx-2"/g' "$FILE"
  sed -i 's/class="d-flex"/class="flex"/g' "$FILE"
  sed -i 's/class="justify-content-between"/class="justify-between"/g' "$FILE"
  sed -i 's/class="align-items-center"/class="items-center"/g' "$FILE"
  
  # Replace component classes with component class references
  # (assuming component classes are defined in CSS)
  sed -i 's/class="card"/class="card"/g' "$FILE"
  sed -i 's/class="btn btn-primary"/class="btn btn-primary"/g' "$FILE"
  
  echo "Migrated: $FILE"
done
```

## Best Practices for AI Agents

1. **Prefer Component Classes**: Use pre-defined component classes when available
2. **Mobile-First**: Always start with mobile styles, add breakpoints for larger screens
3. **Consistent Spacing**: Use Tailwind's spacing scale (0, 1, 2, 3, 4, 6, 8, 12, 16...)
4. **Semantic Colors**: Use blue for primary, green for success, red for danger, yellow for warning
5. **Add States**: Always include hover/focus states for interactive elements
6. **Accessibility**: Maintain ARIA attributes and semantic HTML
7. **RTL Support**: Tailwind handles RTL automatically with `dir="rtl"`

## Testing Checklist

After migration, verify:
- [ ] Layout structure is intact
- [ ] Responsive design works (mobile, tablet, desktop)
- [ ] Colors match the original design
- [ ] Spacing is consistent
- [ ] Interactive states work (hover, focus, active)
- [ ] Forms are functional
- [ ] Tables display correctly
- [ ] RTL support works
- [ ] Accessibility features are maintained

## Common Issues and Solutions

### Issue 1: Class Names Too Long
**Solution**: Create component classes using `@layer components`

### Issue 2: Inconsistent Colors
**Solution**: Use Tailwind's color palette consistently (blue-600, green-600, etc.)

### Issue 3: Spacing Doesn't Match
**Solution**: Remember Bootstrap 3 = Tailwind 4, Bootstrap 4 = Tailwind 6

### Issue 4: Grid Not Working
**Solution**: Ensure you're using flex with proper fractions (w-1/2, w-1/3, etc.)

## Resources

- **Tailwind CSS Docs**: https://tailwindcss.com/docs
- **Component Classes**: See `resources/assets/css/app.css`
- **Migration Guide**: See `BOOTSTRAP-TO-TAILWIND-MIGRATION.md`
- **Quick Start**: See `TAILWIND-QUICKSTART.md`
