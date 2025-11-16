# CoreUI 2.16 CSS Variables Configuration Guide

This document describes how to customize the CoreUI 2.16 theme using CSS custom properties (CSS variables) for maximum flexibility.

## Overview

The CoreUI 2.16 implementation uses extensive CSS custom properties that allow you to customize the entire theme without recompiling SCSS. This provides:

- **Runtime Theming**: Change colors and styles instantly without rebuilding assets
- **Easy Maintenance**: All theme values in one central location
- **Dynamic Themes**: Support for dark mode and user preferences
- **Performance**: No need to recompile SCSS for simple color changes

## Core CSS Variables

### Primary Brand Colors

Change your brand colors by updating these variables:

```css
:root {
  --primary: #321fdb;      /* Primary brand color */
  --secondary: #ced2d8;    /* Secondary color */
  --success: #2eb85c;      /* Success state color */
  --info: #39f;            /* Info state color */
  --warning: #f9b115;      /* Warning state color */
  --danger: #e55353;       /* Danger/error state color */
  --light: #ebedef;        /* Light background */
  --dark: #2c384a;         /* Dark text/background */
}
```

### Sidebar Configuration

Customize the sidebar appearance:

```css
:root {
  --sidebar-bg: #2c384a;                           /* Sidebar background color */
  --sidebar-color: #fff;                           /* Sidebar text color */
  --sidebar-nav-link-color: #fff;                  /* Navigation link color */
  --sidebar-nav-link-hover-bg: var(--primary);     /* Hover background */
  --sidebar-nav-link-hover-color: #fff;            /* Hover text color */
  --sidebar-nav-link-active-bg: rgba(255, 255, 255, 0.1);  /* Active item background */
  --sidebar-nav-link-active-color: #fff;           /* Active item color */
  --sidebar-nav-link-icon-color: rgba(255, 255, 255, 0.6); /* Icon color */
  --sidebar-width: 256px;                          /* Sidebar width (expanded) */
  --sidebar-minimized-width: 56px;                 /* Sidebar width (minimized) */
}
```

### Navbar/Header Configuration

Customize the top navigation bar:

```css
:root {
  --navbar-bg: #fff;               /* Navbar background */
  --navbar-color: #768192;         /* Navbar text color */
  --navbar-hover-color: #2c384a;   /* Hover state color */
  --navbar-active-color: #2c384a;  /* Active state color */
  --navbar-height: 56px;           /* Navbar height */
  --navbar-brand-width: 200px;     /* Brand logo area width */
}
```

### Body & Layout

Control the overall page layout:

```css
:root {
  --body-bg: #e4e5e6;        /* Main background color */
  --body-color: #2c384a;     /* Main text color */
}
```

### Borders & Shadows

Customize borders and shadows across the application:

```css
:root {
  --border-color: #d8dbe0;                              /* Default border color */
  --border-radius: 0.25rem;                             /* Border radius */
  --box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); /* Box shadow */
}
```

### Typography

Control font settings:

```css
:root {
  --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  --font-size-base: 0.875rem;  /* Base font size */
  --line-height-base: 1.5;     /* Line height */
}
```

### Spacing

Control spacing throughout the application:

```css
:root {
  --spacer: 1rem;  /* Base spacing unit (used for margins, padding, etc.) */
}
```

### Card Components

Customize card appearance:

```css
:root {
  --card-border-color: var(--border-color);  /* Card border color */
  --card-cap-bg: #fff;                       /* Card header background */
  --card-bg: #fff;                           /* Card body background */
}
```

### Form Controls

Customize form elements:

```css
:root {
  --input-bg: #fff;                         /* Input background */
  --input-border-color: var(--border-color);  /* Input border */
  --input-focus-border-color: #8ad4ee;      /* Input focus border */
  --input-color: var(--body-color);         /* Input text color */
}
```

### Buttons

Customize button appearance:

```css
:root {
  --btn-padding-y: 0.375rem;              /* Button vertical padding */
  --btn-padding-x: 0.75rem;               /* Button horizontal padding */
  --btn-border-radius: var(--border-radius);  /* Button border radius */
}
```

### Tables

Customize table styles:

```css
:root {
  --table-border-color: var(--border-color);  /* Table border color */
  --table-striped-bg: rgba(0, 0, 0, 0.02);    /* Striped row background */
  --table-hover-bg: rgba(0, 0, 0, 0.04);      /* Row hover background */
}
```

### Dropdowns

Customize dropdown menus:

```css
:root {
  --dropdown-bg: #fff;                      /* Dropdown background */
  --dropdown-border-color: var(--border-color);  /* Dropdown border */
  --dropdown-link-color: #2c384a;           /* Link color */
  --dropdown-link-hover-bg: #e4e5e6;        /* Link hover background */
}
```

### Modals

Customize modal dialogs:

```css
:root {
  --modal-content-bg: #fff;                    /* Modal background */
  --modal-content-border-color: var(--border-color);  /* Modal border */
  --modal-backdrop-bg: #000;                   /* Backdrop background */
  --modal-backdrop-opacity: 0.5;               /* Backdrop opacity */
}
```

### Footer

Customize the footer:

```css
:root {
  --footer-bg: #ebedef;      /* Footer background */
  --footer-color: #768192;   /* Footer text color */
}
```

### Breadcrumb

Customize breadcrumb navigation:

```css
:root {
  --breadcrumb-bg: transparent;           /* Breadcrumb background */
  --breadcrumb-divider-color: #768192;    /* Divider color */
  --breadcrumb-active-color: var(--body-color);  /* Active item color */
}
```

### Progress Bars

Customize progress bars:

```css
:root {
  --progress-bg: #e4e5e6;                    /* Progress background */
  --progress-border-radius: var(--border-radius);  /* Progress border radius */
}
```

### Transitions & Animations

Control animation speeds:

```css
:root {
  --transition-speed: 0.3s;  /* Default transition duration */
  --sidebar-transition: margin-left var(--transition-speed) ease-in-out, 
                        margin-right var(--transition-speed) ease-in-out;
}
```

## Dark Mode Support

The implementation includes dark mode support. To enable dark mode, add the `data-theme="dark"` attribute to the HTML element:

```html
<html data-theme="dark">
```

Dark mode variables:

```css
[data-theme="dark"] {
  --body-bg: #181924;
  --body-color: #c8ced3;
  --sidebar-bg: #0f1116;
  --navbar-bg: #0f1116;
  --card-bg: #252836;
  --border-color: #2f3346;
  --input-bg: #252836;
}
```

## How to Customize

### Method 1: Inline in the Layout File

Add a `<style>` block in your layout file (recommended for quick changes):

```html
<head>
    <!-- Other head content -->
    <style>
        :root {
            --primary: #ff6b6b;           /* Change to your brand color */
            --sidebar-bg: #1a1a2e;        /* Dark sidebar */
            --navbar-bg: #16213e;         /* Dark navbar */
        }
    </style>
</head>
```

### Method 2: Create a Custom CSS File

Create a file `public/css/custom-theme.css`:

```css
:root {
    /* Your custom theme */
    --primary: #your-color;
    --sidebar-bg: #your-sidebar-color;
    /* ... more variables */
}
```

Then include it in your layout after CoreUI CSS:

```html
<link rel="stylesheet" href="{{asset('css/coreui/coreui-custom.css')}}">
<link rel="stylesheet" href="{{asset('css/custom-theme.css')}}">
```

### Method 3: Dynamic Theming with JavaScript

You can change themes dynamically using JavaScript:

```javascript
// Change primary color
document.documentElement.style.setProperty('--primary', '#ff6b6b');

// Change sidebar background
document.documentElement.style.setProperty('--sidebar-bg', '#1a1a2e');

// Toggle dark mode
document.documentElement.setAttribute('data-theme', 'dark');
```

## Example: Creating a Custom Theme

Here's a complete example of a custom purple theme:

```css
:root {
    /* Brand Colors */
    --primary: #7c3aed;
    --secondary: #a78bfa;
    --success: #10b981;
    --info: #3b82f6;
    --warning: #f59e0b;
    --danger: #ef4444;
    
    /* Layout */
    --sidebar-bg: #5b21b6;
    --navbar-bg: #f3f4f6;
    --body-bg: #f9fafb;
    
    /* Sidebar Navigation */
    --sidebar-nav-link-hover-bg: #6d28d9;
    --sidebar-nav-link-active-bg: rgba(255, 255, 255, 0.15);
}
```

## RTL (Right-to-Left) Support

The implementation includes full RTL support for Arabic and Hebrew. RTL is automatically applied when the locale is set to 'ar' or 'he'. No additional CSS variables are needed.

## Browser Support

CSS custom properties are supported in:
- Chrome/Edge 49+
- Firefox 31+
- Safari 9.1+
- iOS Safari 9.3+

For older browsers, the compiled SCSS provides fallback values.

## Performance Tips

1. **Avoid excessive variable changes**: Changing CSS variables triggers repaints
2. **Batch updates**: If changing multiple variables, update them together
3. **Use CSS classes**: For theme switching, use data attributes or classes rather than changing individual variables

## Troubleshooting

### Variables not applying

1. Check browser support for CSS custom properties
2. Ensure the variable is defined in `:root` or appropriate scope
3. Check for `!important` declarations overriding your variables
4. Clear browser cache after changes

### Dark mode not working

1. Verify `data-theme="dark"` attribute is on `<html>` element
2. Ensure dark mode variables are defined
3. Check for conflicts with other stylesheets

## Additional Resources

- [CoreUI Documentation](https://coreui.io/docs/)
- [MDN CSS Custom Properties](https://developer.mozilla.org/en-US/docs/Web/CSS/--*)
- [Bootstrap 4 Documentation](https://getbootstrap.com/docs/4.6/)
