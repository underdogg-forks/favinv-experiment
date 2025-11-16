# Tailwind CSS v4 Quick Start Guide

## Introduction

This project now uses **Tailwind CSS v4** - the latest version of the utility-first CSS framework that enables rapid UI development with pre-designed utility classes.

## What's New in Tailwind v4

- **CSS-First Configuration**: No more `tailwind.config.js` - configure themes directly in CSS
- **Built-in Features**: Forms and typography plugins are now built-in
- **Faster Builds**: Significantly improved build performance
- **Modern CSS**: Uses native CSS features like `@theme` and CSS variables
- **Autoprefixer Built-in**: No separate autoprefixer needed

## Setup

### 1. Install Dependencies

```bash
npm install
```

### 2. Build CSS

```bash
# Development
npm run dev

# Watch for changes
npm run watch

# Production (optimized)
npm run production
```

## Configuration

### Theme Configuration (Tailwind v4 Style)

Configuration is now done directly in CSS using `@theme`:

```css
/* resources/assets/css/app.css */
@import "tailwindcss";

@theme {
  /* Custom colors */
  --color-primary: #321fdb;
  --color-sidebar-bg: #2c384a;
  
  /* Custom spacing */
  --spacing-custom: 2.5rem;
}
```

## Basic Usage

### Utility-First Approach

Instead of writing custom CSS, compose designs with utility classes:

```html
<!-- Traditional CSS approach -->
<style>
.my-button {
  background-color: #3490dc;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
}
</style>
<button class="my-button">Click me</button>

<!-- Tailwind v4 approach -->
<button class="bg-blue-500 text-white px-4 py-2 rounded">
  Click me
</button>
```

## Common Patterns

### Cards

```html
<div class="bg-white rounded-lg shadow p-6">
  <h3 class="text-lg font-semibold mb-2">Card Title</h3>
  <p class="text-gray-600">Card content goes here.</p>
</div>
```

### Buttons

```html
<!-- Primary Button -->
<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium">
  Primary
</button>

<!-- Secondary Button -->
<button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded font-medium">
  Secondary
</button>
```

### Forms

```html
<div class="space-y-4">
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Email
    </label>
    <input 
      type="email" 
      class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
      placeholder="you@example.com"
    >
  </div>
  
  <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium">
    Submit
  </button>
</div>
```

### Alerts

```html
<!-- Success Alert -->
<div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-md">
  <div class="flex">
    <i class="fas fa-check-circle mr-2"></i>
    <span>Success! Your changes have been saved.</span>
  </div>
</div>

<!-- Error Alert -->
<div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-md">
  <div class="flex">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <span>Error! Something went wrong.</span>
  </div>
</div>
```

### Tables

```html
<div class="overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
          Name
        </th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
          Email
        </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <tr>
        <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
        <td class="px-6 py-4 whitespace-nowrap">john@example.com</td>
      </tr>
    </tbody>
  </table>
</div>
```

## Responsive Design

Tailwind uses mobile-first breakpoints:

```html
<!-- Stack on mobile, side-by-side on desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div class="bg-white p-4 rounded">Column 1</div>
  <div class="bg-white p-4 rounded">Column 2</div>
</div>

<!-- Hide on mobile, show on desktop -->
<div class="hidden lg:block">
  Desktop only content
</div>

<!-- Full width on mobile, fixed width on desktop -->
<div class="w-full lg:w-1/2">
  Responsive width
</div>
```

### Breakpoints:
- `sm:` 640px+
- `md:` 768px+
- `lg:` 1024px+
- `xl:` 1280px+
- `2xl:` 1536px+

## Customization

Edit `tailwind.config.js` to customize colors, spacing, fonts, etc.:

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        'brand': '#your-color',
      },
    },
  },
}
```

## Using Component Classes

Pre-defined component classes are available in `resources/assets/css/app.css`:

```html
<!-- Card component -->
<div class="card">
  <div class="card-header">Title</div>
  <div class="card-body">Content</div>
</div>

<!-- Button components -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>

<!-- Alert components -->
<div class="alert alert-success">Success message</div>
```

## Common Utilities

### Spacing
- `p-4` = padding: 1rem
- `px-6` = padding-left & right: 1.5rem
- `mt-2` = margin-top: 0.5rem
- `space-y-4` = vertical spacing between children

### Colors
- `bg-blue-500` = background color
- `text-gray-700` = text color
- `border-red-300` = border color

### Typography
- `text-lg` = font size large
- `font-semibold` = font weight 600
- `text-center` = text align center

### Layout
- `flex` = display: flex
- `grid` = display: grid
- `items-center` = align items center
- `justify-between` = justify content space-between

### Effects
- `shadow` = box shadow
- `rounded` = border radius
- `hover:bg-blue-700` = hover state

## Next Steps

1. Review `BOOTSTRAP-TO-TAILWIND-MIGRATION.md` for detailed migration guide
2. Explore `tailwind.config.js` for customization options
3. Check official Tailwind docs: https://tailwindcss.com/docs

## Tips

- Use browser DevTools to inspect Tailwind classes
- Install Tailwind CSS IntelliSense extension for VSCode
- Start with utility classes, create components only when needed
- Use `@apply` directive for frequently used combinations
