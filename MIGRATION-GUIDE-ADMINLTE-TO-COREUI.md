# Migration Guide: AdminLTE to CoreUI 2.16

This guide helps developers migrate from the previous AdminLTE template to the new CoreUI 2.16 template system.

## Overview

The application has been refactored to use CoreUI 2.16, a modern Bootstrap 4-based admin template with extensive CSS custom properties support. This provides better theming capabilities, cleaner code structure, and improved performance.

## Key Changes

### 1. CSS Framework

**Before (AdminLTE):**
- AdminLTE 3.x CSS framework
- Limited customization without SCSS recompilation
- Bootstrap 4 base with AdminLTE extensions

**After (CoreUI 2.16):**
- CoreUI 2.16 CSS framework
- Extensive CSS custom properties (CSS variables)
- Native Bootstrap 4 with CoreUI components
- Easy runtime theming without recompilation

### 2. Class Name Changes

#### Wrapper/Container Classes

| AdminLTE | CoreUI | Purpose |
|----------|--------|---------|
| `.wrapper` | `.c-app` | Main application wrapper |
| `.main-header` | `.c-header` | Top navigation bar |
| `.main-sidebar` | `.c-sidebar` | Side navigation |
| `.content-wrapper` | `.c-body > .c-main` | Main content area |
| `.main-footer` | `.c-footer` | Footer |

#### Sidebar Classes

| AdminLTE | CoreUI | Purpose |
|----------|--------|---------|
| `.sidebar-mini` | `.c-sidebar-minimized` | Minimized sidebar state |
| `.sidebar-collapse` | `.c-sidebar-lg-show` | Sidebar collapse state |
| `.nav-sidebar` | `.c-sidebar-nav` | Sidebar navigation |
| `.nav-item.has-treeview` | `.c-sidebar-nav-dropdown` | Dropdown menu item |
| `.nav-treeview` | `.c-sidebar-nav-dropdown-items` | Dropdown submenu |
| `.nav-link` | `.c-sidebar-nav-link` | Navigation link |
| `.nav-icon` | `.c-sidebar-nav-icon` | Navigation icon |

#### Header/Navbar Classes

| AdminLTE | CoreUI | Purpose |
|----------|--------|---------|
| `.navbar-nav` | `.c-header-nav` | Header navigation list |
| `.nav-item` | `.c-header-nav-item` | Header navigation item |
| `.nav-link` | `.c-header-nav-link` | Header navigation link |

#### Body Classes

| AdminLTE | CoreUI | Purpose |
|----------|--------|---------|
| `hold-transition sidebar-mini layout-fixed` | `c-app` | Main body classes |
| `.content` | `.c-main` | Main content container |

### 3. JavaScript Changes

#### AdminLTE Plugins

**Before:**
```html
<script src="{{asset('admin/js-1/adminlte.js')}}"></script>
```

**After:**
```html
<script src="{{asset('js/coreui/coreui.min.js')}}"></script>
<script src="{{asset('js/coreui/coreui-utilities.min.js')}}"></script>
<script src="{{asset('js/coreui/perfect-scrollbar.min.js')}}"></script>
```

#### Widget Attributes

| AdminLTE | CoreUI | Purpose |
|----------|--------|---------|
| `data-widget="pushmenu"` | `data-target="#sidebar" data-class="c-sidebar-show"` | Toggle sidebar |
| `data-widget="treeview"` | `data-widget="treeview"` (still supported) | Dropdown menus |

### 4. Layout Structure

#### Before (AdminLTE):

```html
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Header content -->
        </nav>
        
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Sidebar content -->
        </aside>
        
        <div class="content-wrapper">
            <!-- Main content -->
        </div>
        
        <footer class="main-footer">
            <!-- Footer -->
        </footer>
    </div>
</body>
```

#### After (CoreUI):

```html
<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show">
        <!-- Sidebar content -->
    </div>
    
    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed">
            <!-- Header content -->
        </header>
        
        <div class="c-body">
            <main class="c-main">
                <!-- Main content -->
            </main>
        </div>
        
        <footer class="c-footer">
            <!-- Footer -->
        </footer>
    </div>
</body>
```

### 5. Sidebar Navigation Structure

#### Before (AdminLTE):

```html
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Users <i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/users" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Users</p>
                </a>
            </li>
        </ul>
    </li>
</ul>
```

#### After (CoreUI):

```html
<ul class="c-sidebar-nav ps" data-widget="treeview">
    <li class="c-sidebar-nav-dropdown">
        <a href="#" class="c-sidebar-nav-dropdown-toggle">
            <i class="c-sidebar-nav-icon fas fa-users"></i>
            Users
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a href="/users" class="c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon far fa-circle"></i>
                    <span>All Users</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
```

### 6. Theming with CSS Variables

The biggest improvement is the ability to customize the theme using CSS variables without recompiling SCSS.

#### Customizing Colors

Add this to your layout or a custom CSS file:

```html
<style>
    :root {
        --primary: #your-color;
        --sidebar-bg: #your-sidebar-color;
        --navbar-bg: #your-navbar-color;
    }
</style>
```

See `COREUI-CSS-VARIABLES-GUIDE.md` for a complete list of available variables.

### 7. RTL Support

RTL support is still automatic and works the same way:

```html
<html dir="{{ in_array(app()->getLocale(), ['ar', 'he']) ? 'rtl' : 'ltr' }}">
```

CoreUI includes built-in RTL support with proper CSS variable handling.

### 8. Responsive Behavior

#### Sidebar Toggle

**Before (AdminLTE):**
```html
<a class="nav-link" data-widget="pushmenu" href="#" role="button">
    <i class="fas fa-bars"></i>
</a>
```

**After (CoreUI):**
```html
<!-- Mobile toggle -->
<button class="c-header-toggler c-class-toggler d-lg-none" 
        data-target="#sidebar" data-class="c-sidebar-show">
    <i class="fas fa-bars"></i>
</button>

<!-- Desktop minimize -->
<button class="c-header-toggler c-class-toggler d-md-down-none" 
        data-target="#sidebar" data-class="c-sidebar-lg-show">
    <i class="fas fa-bars"></i>
</button>
```

### 9. Migration Checklist

When migrating custom views to use CoreUI:

- [ ] Update main container classes (`.wrapper` → `.c-app`)
- [ ] Update header classes (`.main-header` → `.c-header`)
- [ ] Update sidebar classes (`.main-sidebar` → `.c-sidebar`)
- [ ] Update content wrapper classes (`.content-wrapper` → `.c-body > .c-main`)
- [ ] Update footer classes (`.main-footer` → `.c-footer`)
- [ ] Update navigation classes (`.nav-link` → `.c-sidebar-nav-link`)
- [ ] Update dropdown classes (`.has-treeview` → `.c-sidebar-nav-dropdown`)
- [ ] Replace AdminLTE JS with CoreUI JS
- [ ] Test responsive behavior on mobile devices
- [ ] Test RTL support if applicable
- [ ] Verify all dropdowns and interactive elements work

### 10. Backward Compatibility

A compatibility layer is included in the SCSS to ease migration:

```scss
// These AdminLTE classes are mapped to CoreUI equivalents
.main-header { @extend .c-header; }
.main-sidebar { @extend .c-sidebar; }
.content-wrapper { @extend .c-body; }
```

This means some old classes will still work, but it's recommended to update them for better performance.

### 11. Build Process

#### Installing Dependencies

```bash
npm install
```

#### Building Assets

Development mode:
```bash
npm run dev
```

Production mode:
```bash
npm run production
```

Watch mode (auto-rebuild on changes):
```bash
npm run watch
```

#### Compiled Files Location

- CSS: `public/css/coreui/coreui-custom.css`
- JS: `public/js/coreui/coreui.min.js`
- Perfect Scrollbar: `public/js/coreui/perfect-scrollbar.min.js`

### 12. Common Issues and Solutions

#### Issue: Sidebar not collapsing

**Solution:** Ensure CoreUI JavaScript is loaded and the correct data attributes are used:
```html
<button class="c-class-toggler" data-target="#sidebar" data-class="c-sidebar-lg-show">
```

#### Issue: Dropdown menus not opening

**Solution:** Include the CoreUI JavaScript file:
```html
<script src="{{asset('js/coreui/coreui.min.js')}}"></script>
```

#### Issue: Styles not applying

**Solution:** 
1. Ensure CoreUI CSS is loaded before custom CSS
2. Clear browser cache
3. Rebuild assets with `npm run dev`

#### Issue: RTL not working

**Solution:** Verify the `dir` attribute is set on the HTML element:
```html
<html dir="rtl">
```

### 13. Resources

- [CoreUI 2.16 Documentation](https://coreui.io/docs/2.1/)
- [CSS Variables Guide](./COREUI-CSS-VARIABLES-GUIDE.md)
- [Bootstrap 4 Documentation](https://getbootstrap.com/docs/4.6/)
- [Original AdminLTE Backup](resources/views/themes/default1/layouts/master-adminlte-backup.blade.php)

### 14. Getting Help

If you encounter issues during migration:

1. Check the browser console for JavaScript errors
2. Verify all CoreUI assets are loaded correctly
3. Compare your code with the new master layout
4. Review the CSS Variables Guide for theming issues
5. Check the AdminLTE backup file for reference

### 15. Benefits of the New System

- **Easier Theming**: Change colors instantly with CSS variables
- **Better Performance**: Optimized CoreUI framework
- **Modern Code**: Clean, semantic HTML structure
- **Better Mobile Support**: Improved responsive behavior
- **Maintainability**: Cleaner separation of concerns
- **Future-Proof**: Based on modern web standards
- **Dark Mode Ready**: Built-in support for dark themes
- **Accessibility**: Better ARIA support and keyboard navigation

## Examples

### Example 1: Creating a Custom Color Scheme

```html
<style>
    :root {
        /* Purple theme */
        --primary: #7c3aed;
        --sidebar-bg: #5b21b6;
        --navbar-bg: #f3f4f6;
        --sidebar-nav-link-hover-bg: #6d28d9;
    }
</style>
```

### Example 2: Adding a New Sidebar Item

```html
<li class="c-sidebar-nav-item">
    <a href="{{url('/reports')}}" class="c-sidebar-nav-link">
        <i class="c-sidebar-nav-icon fas fa-chart-line"></i>
        Reports
    </a>
</li>
```

### Example 3: Adding a Dropdown Menu

```html
<li class="c-sidebar-nav-dropdown">
    <a href="#" class="c-sidebar-nav-dropdown-toggle">
        <i class="c-sidebar-nav-icon fas fa-cog"></i>
        Settings
    </a>
    <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item">
            <a href="{{url('/settings/general')}}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon far fa-circle"></i>
                <span>General</span>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{url('/settings/advanced')}}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon far fa-circle"></i>
                <span>Advanced</span>
            </a>
        </li>
    </ul>
</li>
```

## Conclusion

The migration to CoreUI 2.16 provides a more modern, flexible, and maintainable foundation for the application. While there are class name changes to adapt to, the improved theming capabilities and cleaner code structure make it worthwhile. The compatibility layer eases the transition, and the extensive CSS variables support provides unprecedented theming flexibility.
