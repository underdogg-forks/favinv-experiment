# Bootstrap/CoreUI to Tailwind CSS Migration Guide

## Overview

This guide provides a comprehensive reference for migrating from Bootstrap/CoreUI/AdminLTE to Tailwind CSS.

## Philosophy Difference

### Bootstrap/CoreUI (Component-Based)
```html
<div class="card">
  <div class="card-header">Title</div>
  <div class="card-body">Content</div>
</div>
```

### Tailwind (Utility-First)
```html
<div class="bg-white rounded-lg shadow">
  <div class="px-6 py-4 border-b border-gray-200 font-semibold">Title</div>
  <div class="p-6">Content</div>
</div>
```

**Key Difference**: Tailwind uses small, single-purpose utility classes instead of pre-built components.

## Complete Class Mapping

### Layout & Grid

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.container` | `.container .mx-auto .px-4` |
| `.container-fluid` | `.w-full .px-4` |
| `.row` | `.flex .flex-wrap .-mx-2` |
| `.col` | `.flex-1 .px-2` |
| `.col-6` | `.w-1/2 .px-2` |
| `.col-md-6` | `.w-full .md:w-1/2 .px-2` |
| `.col-lg-4` | `.w-full .lg:w-1/3 .px-2` |
| `.offset-md-3` | `.md:ml-[25%]` |

### Display

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.d-none` | `.hidden` |
| `.d-block` | `.block` |
| `.d-inline` | `.inline` |
| `.d-inline-block` | `.inline-block` |
| `.d-flex` | `.flex` |
| `.d-inline-flex` | `.inline-flex` |
| `.d-grid` | `.grid` |
| `.d-md-none` | `.md:hidden` |
| `.d-lg-block` | `.lg:block` |

### Flexbox

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.flex-row` | `.flex-row` |
| `.flex-column` | `.flex-col` |
| `.flex-wrap` | `.flex-wrap` |
| `.flex-nowrap` | `.flex-nowrap` |
| `.justify-content-start` | `.justify-start` |
| `.justify-content-end` | `.justify-end` |
| `.justify-content-center` | `.justify-center` |
| `.justify-content-between` | `.justify-between` |
| `.justify-content-around` | `.justify-around` |
| `.align-items-start` | `.items-start` |
| `.align-items-end` | `.items-end` |
| `.align-items-center` | `.items-center` |
| `.align-items-baseline` | `.items-baseline` |
| `.align-items-stretch` | `.items-stretch` |

### Spacing

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.m-0` | `.m-0` |
| `.m-1` | `.m-1` (0.25rem) |
| `.m-2` | `.m-2` (0.5rem) |
| `.m-3` | `.m-3` (0.75rem) / `.m-4` (1rem) |
| `.m-4` | `.m-6` (1.5rem) |
| `.m-5` | `.m-8` (2rem) |
| `.mt-3` | `.mt-4` |
| `.mb-4` | `.mb-6` |
| `.mx-auto` | `.mx-auto` |
| `.p-3` | `.p-4` |
| `.px-4` | `.px-6` |
| `.py-2` | `.py-2` |

### Typography

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.h1` | `.text-5xl .font-bold` |
| `.h2` | `.text-4xl .font-bold` |
| `.h3` | `.text-3xl .font-bold` |
| `.h4` | `.text-2xl .font-bold` |
| `.h5` | `.text-xl .font-bold` |
| `.h6` | `.text-lg .font-bold` |
| `.text-left` | `.text-left` |
| `.text-center` | `.text-center` |
| `.text-right` | `.text-right` |
| `.text-uppercase` | `.uppercase` |
| `.text-lowercase` | `.lowercase` |
| `.text-capitalize` | `.capitalize` |
| `.font-weight-bold` | `.font-bold` |
| `.font-weight-normal` | `.font-normal` |
| `.font-italic` | `.italic` |
| `.text-decoration-none` | `.no-underline` |

### Text Colors

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.text-primary` | `.text-blue-600` |
| `.text-secondary` | `.text-gray-600` |
| `.text-success` | `.text-green-600` |
| `.text-danger` | `.text-red-600` |
| `.text-warning` | `.text-yellow-600` |
| `.text-info` | `.text-cyan-600` |
| `.text-muted` | `.text-gray-500` |
| `.text-white` | `.text-white` |
| `.text-dark` | `.text-gray-900` |

### Background Colors

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.bg-primary` | `.bg-blue-600` |
| `.bg-secondary` | `.bg-gray-600` |
| `.bg-success` | `.bg-green-600` |
| `.bg-danger` | `.bg-red-600` |
| `.bg-warning` | `.bg-yellow-600` |
| `.bg-info` | `.bg-cyan-600` |
| `.bg-light` | `.bg-gray-100` |
| `.bg-dark` | `.bg-gray-800` |
| `.bg-white` | `.bg-white` |
| `.bg-transparent` | `.bg-transparent` |

### Borders

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.border` | `.border` |
| `.border-0` | `.border-0` |
| `.border-top` | `.border-t` |
| `.border-right` | `.border-r` |
| `.border-bottom` | `.border-b` |
| `.border-left` | `.border-l` |
| `.border-primary` | `.border-blue-600` |
| `.rounded` | `.rounded` |
| `.rounded-0` | `.rounded-none` |
| `.rounded-circle` | `.rounded-full` |
| `.rounded-top` | `.rounded-t` |
| `.rounded-lg` | `.rounded-lg` |

### Sizing

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.w-25` | `.w-1/4` |
| `.w-50` | `.w-1/2` |
| `.w-75` | `.w-3/4` |
| `.w-100` | `.w-full` |
| `.w-auto` | `.w-auto` |
| `.h-25` | `.h-1/4` |
| `.h-50` | `.h-1/2` |
| `.h-75` | `.h-3/4` |
| `.h-100` | `.h-full` |
| `.mw-100` | `.max-w-full` |
| `.mh-100` | `.max-h-full` |

### Position

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.position-static` | `.static` |
| `.position-relative` | `.relative` |
| `.position-absolute` | `.absolute` |
| `.position-fixed` | `.fixed` |
| `.position-sticky` | `.sticky` |
| `.top-0` | `.top-0` |
| `.bottom-0` | `.bottom-0` |
| `.start-0` | `.left-0` or `rtl:.right-0` |
| `.end-0` | `.right-0` or `rtl:.left-0` |

### Shadows & Effects

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.shadow-none` | `.shadow-none` |
| `.shadow-sm` | `.shadow-sm` |
| `.shadow` | `.shadow` |
| `.shadow-lg` | `.shadow-lg` |
| `.opacity-25` | `.opacity-25` |
| `.opacity-50` | `.opacity-50` |
| `.opacity-75` | `.opacity-75` |
| `.opacity-100` | `.opacity-100` |

## Component Migration

### Cards

**Bootstrap/CoreUI:**
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

**Tailwind:**
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

Or use the component class:
```html
<div class="card">
  <div class="card-header">Title</div>
  <div class="card-body">Content</div>
  <div class="card-footer">Footer</div>
</div>
```

### Buttons

**Bootstrap/CoreUI:**
```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-success btn-lg">Large Success</button>
<button class="btn btn-danger btn-sm">Small Danger</button>
```

**Tailwind:**
```html
<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium">Primary</button>
<button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded font-medium">Secondary</button>
<button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded text-lg font-medium">Large Success</button>
<button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm font-medium">Small Danger</button>
```

Or use component classes:
```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
```

### Alerts

**Bootstrap/CoreUI:**
```html
<div class="alert alert-success" role="alert">
  Success message
</div>
<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Error!</h4>
  <p>Error message</p>
</div>
```

**Tailwind:**
```html
<div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-md" role="alert">
  Success message
</div>
<div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-md" role="alert">
  <h4 class="font-semibold mb-1">Error!</h4>
  <p>Error message</p>
</div>
```

Or use component classes:
```html
<div class="alert alert-success">Success message</div>
<div class="alert alert-danger">Error message</div>
```

### Forms

**Bootstrap/CoreUI:**
```html
<div class="form-group">
  <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" id="email" placeholder="Email">
  <small class="form-text text-muted">We'll never share your email.</small>
</div>
```

**Tailwind:**
```html
<div class="mb-4">
  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
  <input 
    type="email" 
    id="email" 
    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
    placeholder="Email"
  >
  <small class="text-sm text-gray-500">We'll never share your email.</small>
</div>
```

Or use component classes:
```html
<div class="mb-4">
  <label for="email" class="form-label">Email</label>
  <input type="email" id="email" class="form-control" placeholder="Email">
  <small class="text-sm text-gray-500">We'll never share your email.</small>
</div>
```

### Navbar/Header

**Bootstrap/CoreUI:**
```html
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Brand</a>
    <div class="navbar-nav">
      <a class="nav-link active" href="#">Home</a>
      <a class="nav-link" href="#">About</a>
    </div>
  </div>
</nav>
```

**Tailwind:**
```html
<nav class="bg-white border-b border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <a href="#" class="text-xl font-bold">Brand</a>
      <div class="flex space-x-4">
        <a href="#" class="text-blue-600 font-medium">Home</a>
        <a href="#" class="text-gray-600 hover:text-gray-900">About</a>
      </div>
    </div>
  </div>
</nav>
```

### Tables

**Bootstrap/CoreUI:**
```html
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>John Doe</td>
      <td>john@example.com</td>
    </tr>
  </tbody>
</table>
```

**Tailwind:**
```html
<table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-50">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <tr class="hover:bg-gray-50">
      <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
      <td class="px-6 py-4 whitespace-nowrap">john@example.com</td>
    </tr>
  </tbody>
</table>
```

Or use component class:
```html
<table class="table">
  <!-- Same structure as above -->
</table>
```

### Badges/Labels

**Bootstrap/CoreUI:**
```html
<span class="badge bg-primary">Primary</span>
<span class="badge bg-success">Success</span>
<span class="badge bg-danger">Danger</span>
```

**Tailwind:**
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Primary</span>
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Danger</span>
```

Or use component classes:
```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-danger">Danger</span>
```

### Breadcrumbs

**Bootstrap/CoreUI:**
```html
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active">Data</li>
  </ol>
</nav>
```

**Tailwind:**
```html
<nav class="flex" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-2">
    <li><a href="#" class="text-gray-500 hover:text-gray-700">Home</a></li>
    <li><span class="text-gray-400">/</span></li>
    <li><a href="#" class="text-gray-500 hover:text-gray-700">Library</a></li>
    <li><span class="text-gray-400">/</span></li>
    <li><span class="text-gray-900 font-medium">Data</span></li>
  </ol>
</nav>
```

## Migration Strategy

### Step 1: Install Tailwind CSS
```bash
npm install
npm run dev
```

### Step 2: Replace Layout
Update `master.blade.php` to use Tailwind classes for layout structure.

### Step 3: Migrate Components Gradually
1. Start with simple components (buttons, badges)
2. Move to complex components (cards, forms)
3. Update tables and lists
4. Finally, update modals and navigation

### Step 4: Use Component Classes
For frequently used patterns, use the pre-defined component classes in `resources/assets/css/app.css`.

### Step 5: Test Thoroughly
- Test all views
- Check responsive behavior
- Verify RTL support
- Test in different browsers

## Tips for Migration

1. **Start Fresh**: Don't try to support both Bootstrap and Tailwind simultaneously
2. **Use DevTools**: Inspect existing Bootstrap components to understand their structure
3. **Component Classes**: Use `@layer components` for reusable patterns
4. **Mobile First**: Tailwind is mobile-first, so design for mobile then add `md:` and `lg:` breakpoints
5. **Use Prefixes**: Leverage hover:, focus:, active: for interactive states
6. **Purge Unused**: Tailwind automatically removes unused classes in production

## Common Pitfalls

1. **Over-engineering**: Don't create components for everything - use utilities directly when possible
2. **Inconsistent Spacing**: Stick to Tailwind's spacing scale (0, 1, 2, 3, 4, 6, 8, 12, 16...)
3. **Ignoring Responsive Design**: Always consider mobile, tablet, and desktop viewports
4. **Not Using @apply**: For complex, repeated patterns, use `@apply` in component classes

## Resources

- **Tailwind CSS Docs**: https://tailwindcss.com/docs
- **Tailwind UI Components**: https://tailwindui.com
- **Headless UI**: https://headlessui.com (for JavaScript components)
- **Tailwind Play**: https://play.tailwindcss.com (online playground)

## Next Steps

1. Review `TAILWIND-AI-AGENT-GUIDE.md` for automated migration instructions
2. Check `tailwind.config.js` for customization options
3. Explore the component classes in `resources/assets/css/app.css`
