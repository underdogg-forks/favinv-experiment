# Tailwind CSS v4 Upgrade Guide

## What's New

This project has been upgraded from **Tailwind CSS v3.4.0** to **Tailwind CSS v4.1.17**.

## Major Changes in Tailwind v4

### 1. CSS-First Configuration

**Before (v3):**
```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: '#321fdb',
      },
    },
  },
}
```

**After (v4):**
```css
/* resources/assets/css/app.css */
@import "tailwindcss";

@theme {
  --color-primary: #321fdb;
}
```

### 2. No More tailwind.config.js

Tailwind v4 uses **CSS-first configuration** via the `@theme` directive. The `tailwind.config.js` file has been removed.

### 3. Simplified Imports

**Before (v3):**
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

**After (v4):**
```css
@import "tailwindcss";
```

### 4. Built-in Plugins

**Before (v3):**
- Needed separate packages: `@tailwindcss/forms`, `@tailwindcss/typography`
- Required plugin configuration in `tailwind.config.js`

**After (v4):**
- Forms and typography support is **built-in**
- No separate packages needed
- No plugin configuration required

### 5. New PostCSS Plugin

**Before (v3):**
```json
{
  "devDependencies": {
    "tailwindcss": "^3.4.0",
    "postcss": "^8.4.32",
    "autoprefixer": "^10.4.16"
  }
}
```

**After (v4):**
```json
{
  "devDependencies": {
    "tailwindcss": "^4.1.17",
    "@tailwindcss/postcss": "^4.1.17"
  }
}
```

Note: PostCSS and Autoprefixer are no longer needed as separate dependencies.

## Changes Made to This Project

### 1. Updated package.json

- Upgraded `tailwindcss` from `^3.4.0` to `^4.1.17`
- Added `@tailwindcss/postcss` package
- Removed `@tailwindcss/forms`, `@tailwindcss/typography`, `postcss`, and `autoprefixer`

### 2. Removed tailwind.config.js

The JavaScript configuration file has been completely removed in favor of CSS-first configuration.

### 3. Updated resources/assets/css/app.css

Converted to v4 syntax:

```css
@import "tailwindcss";

@theme {
  /* Custom colors */
  --color-primary-50: #f5f3ff;
  --color-primary-100: #ede9fe;
  --color-primary-600: #321fdb;
  --color-primary: var(--color-primary-600);
  
  --color-sidebar-bg: #2c384a;
  --color-sidebar-text: #c8ced3;
  --color-sidebar-hover: #23282f;
  
  /* Custom font */
  --font-sans: 'Source Sans Pro', sans-serif;
}

@layer components {
  /* Custom component classes */
}
```

### 4. Updated postcss.config.js

Changed to use the new PostCSS plugin:

```javascript
module.exports = {
  plugins: {
    '@tailwindcss/postcss': {},
  },
}
```

### 5. Updated webpack.mix.js

Modified to use the new plugin:

```javascript
mix.postCss('resources/assets/css/app.css', 'public/css')
   .options({
     processCssUrls: false,
     postCss: [
       require('@tailwindcss/postcss'),
     ]
   });
```

### 6. Updated Documentation

- Updated `TAILWIND-QUICKSTART.md` with v4 information
- Updated `.junie/guidelines.md` to reflect v4 configuration
- Updated `.github/copilot-instructions.md` with v4 best practices

## Benefits of v4

1. **Faster Build Times**: Significantly improved performance
2. **Simpler Configuration**: CSS-first approach is more intuitive
3. **Built-in Features**: No need for separate plugin packages
4. **Modern CSS**: Uses native CSS features like custom properties
5. **Smaller Bundle**: More efficient code generation
6. **Autoprefixer Built-in**: One less dependency to manage

## Migration Checklist

If you're upgrading another project to Tailwind v4:

- [ ] Update `package.json` dependencies
- [ ] Install `@tailwindcss/postcss` package
- [ ] Remove `tailwind.config.js`
- [ ] Update CSS file with `@import "tailwindcss"` and `@theme`
- [ ] Update `postcss.config.js` to use new plugin
- [ ] Update build configuration (webpack.mix.js, vite.config.js, etc.)
- [ ] Test build process
- [ ] Update documentation

## Build Commands

Same as before:

```bash
npm install          # Install dependencies
npm run dev          # Development build
npm run production   # Production build (optimized)
npm run watch        # Watch mode
```

## Browser Support

Same as v3: Chrome/Edge 49+, Firefox 31+, Safari 9.1+

## Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Tailwind CSS v4 Release Notes](https://tailwindcss.com/blog/tailwindcss-v4)
- [Migration Guide](https://tailwindcss.com/docs/upgrade-guide)

## Questions?

See the updated documentation files:
- `TAILWIND-QUICKSTART.md` - Quick start guide
- `.junie/guidelines.md` - Frontend development guidelines
- `.github/copilot-instructions.md` - Copilot instructions
