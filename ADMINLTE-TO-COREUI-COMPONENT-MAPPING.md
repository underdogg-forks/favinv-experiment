# AdminLTE to CoreUI Component Mapping

This document provides the mapping for converting AdminLTE components to CoreUI equivalents.

## Layout Components

| AdminLTE | CoreUI | Notes |
|----------|--------|-------|
| `.wrapper` | `.c-app` | Main application wrapper |
| `.main-header` | `.c-header` | Top navigation bar |
| `.main-sidebar` | `.c-sidebar` | Side navigation |
| `.content-wrapper` | `.c-body > .c-main` | Main content area |
| `.main-footer` | `.c-footer` | Footer |

## Box/Card Components

| AdminLTE | CoreUI | Example |
|----------|--------|---------|
| `.box` | `.card` | Container |
| `.box-primary` | `.card.border-primary` | Primary colored box |
| `.box-success` | `.card.border-success` | Success colored box |
| `.box-info` | `.card.border-info` | Info colored box |
| `.box-warning` | `.card.border-warning` | Warning colored box |
| `.box-danger` | `.card.border-danger` | Danger colored box |
| `.box-header` | `.card-header` | Card header |
| `.box-body` | `.card-body` | Card body |
| `.box-footer` | `.card-footer` | Card footer |
| `.box-title` | `.card-title` | Card title |
| `.box-tools` | `.card-header-actions` | Header actions |

## Info Box / Small Box Components

AdminLTE's info boxes and small boxes need to be recreated using CoreUI cards with custom styling:

### Small Box
```html
<!-- AdminLTE -->
<div class="small-box bg-info">
  <div class="inner">
    <h3>150</h3>
    <p>New Orders</p>
  </div>
  <div class="icon">
    <i class="ion ion-bag"></i>
  </div>
  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>

<!-- CoreUI Equivalent -->
<div class="card text-white bg-info">
  <div class="card-body">
    <div class="text-value-xl">150</div>
    <div>New Orders</div>
  </div>
  <div class="card-footer px-3 py-2">
    <a href="#" class="font-weight-bold font-xs btn-block text-white">
      More info <i class="fas fa-arrow-circle-right ml-1"></i>
    </a>
  </div>
</div>
```

### Info Box
```html
<!-- AdminLTE -->
<div class="info-box">
  <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Messages</span>
    <span class="info-box-number">1,410</span>
  </div>
</div>

<!-- CoreUI Equivalent -->
<div class="card">
  <div class="card-body p-3 d-flex align-items-center">
    <div class="bg-info p-3 mr-3 rounded">
      <i class="far fa-envelope text-white fa-2x"></i>
    </div>
    <div>
      <div class="text-muted small">Messages</div>
      <div class="text-value">1,410</div>
    </div>
  </div>
</div>
```

## Callout Components

| AdminLTE | CoreUI | Notes |
|----------|--------|-------|
| `.callout` | `.alert` | Alert/callout box |
| `.callout-info` | `.alert.alert-info` | Info callout |
| `.callout-success` | `.alert.alert-success` | Success callout |
| `.callout-warning` | `.alert.alert-warning` | Warning callout |
| `.callout-danger` | `.alert.alert-danger` | Danger callout |

## Button Components

| AdminLTE | CoreUI | Notes |
|----------|--------|-------|
| `.btn-primary` | `.btn.btn-primary` | Both use same classes |
| `.btn-success` | `.btn.btn-success` | Both use same classes |
| `.btn-info` | `.btn.btn-info` | Both use same classes |
| `.btn-warning` | `.btn.btn-warning` | Both use same classes |
| `.btn-danger` | `.btn.btn-danger` | Both use same classes |
| `.btn-flat` | `.btn` | CoreUI buttons are flat by default |

## Form Components

Most form components are identical (Bootstrap 4):
- `.form-group` → `.form-group` (same)
- `.form-control` → `.form-control` (same)
- `.form-check` → `.form-check` (same)

## Table Components

| AdminLTE | CoreUI | Notes |
|----------|--------|-------|
| `.table` | `.table` | Same Bootstrap 4 table |
| `.table-bordered` | `.table-bordered` | Same |
| `.table-striped` | `.table-striped` | Same |
| `.table-hover` | `.table-hover` | Same |

## Navigation Components

| AdminLTE | CoreUI | Notes |
|----------|--------|-------|
| `.nav-pills` | `.nav-pills` | Same Bootstrap 4 nav |
| `.nav-tabs` | `.nav-tabs` | Same |
| `.breadcrumb` | `.breadcrumb` | Same |

## Direct Replacements (CSS Classes)

Many AdminLTE classes can be directly replaced:

```javascript
// Simple text replacements
'box' → 'card'
'box-header' → 'card-header'
'box-body' → 'card-body'
'box-footer' → 'card-footer'
'box-title' → 'card-title'
'box-primary' → 'card border-primary'
'box-success' → 'card border-success'
'box-info' → 'card border-info'
'box-warning' → 'card border-warning'
'box-danger' → 'card border-danger'
'callout' → 'alert'
'callout-info' → 'alert alert-info'
'callout-success' → 'alert alert-success'
'callout-warning' → 'alert alert-warning'
'callout-danger' → 'alert alert-danger'
```

## Color Classes

Both frameworks use similar color classes:
- `.bg-primary`, `.bg-success`, `.bg-info`, `.bg-warning`, `.bg-danger`
- `.text-primary`, `.text-success`, `.text-info`, `.text-warning`, `.text-danger`

## Utility Classes

CoreUI includes all Bootstrap 4 utility classes:
- `.m-*`, `.p-*`, `.mt-*`, `.mb-*`, `.ml-*`, `.mr-*` (margin/padding)
- `.d-*` (display)
- `.flex-*` (flexbox)
- `.text-*` (text alignment/transform)
- `.float-*` (float)

## Custom Components Needed

Some AdminLTE components need custom CSS/HTML in CoreUI:

### Progress Group (AdminLTE specific)
Replace with standard progress bars or create custom component.

### Timeline (AdminLTE specific)
Create custom timeline component using CoreUI cards.

### Direct Chat (AdminLTE specific)
Use CoreUI chat widget or create custom component.
