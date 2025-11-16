# Development Guidelines

## SOLID Principles

### Single Responsibility Principle (SRP)
- Each class should have one, and only one, reason to change
- Extract separate concerns into dedicated classes
- Keep methods focused on a single task

### Open/Closed Principle (OCP)
- Classes should be open for extension but closed for modification
- Use interfaces and abstract classes for extensibility
- Prefer composition over inheritance

### Liskov Substitution Principle (LSP)
- Derived classes must be substitutable for their base classes
- Maintain consistent behavior across inheritance hierarchies
- Avoid breaking parent class contracts

### Interface Segregation Principle (ISP)
- Clients should not be forced to depend on interfaces they don't use
- Create specific, focused interfaces rather than large, general ones
- Split large interfaces into smaller, cohesive ones

### Dependency Inversion Principle (DIP)
- Depend on abstractions, not concretions
- Use dependency injection
- Program to interfaces, not implementations

## DRY (Don't Repeat Yourself)

- Eliminate code duplication through abstraction
- Extract repeated logic into reusable methods/classes
- Use constants for repeated values
- Create helper functions for common operations
- Leverage Laravel's built-in helpers and utilities

## Early Returns

- Validate inputs at the start of methods
- Return early on error conditions
- Reduce nesting by handling edge cases first
- Improve code readability by avoiding deep nesting

### Example:
```php
// Bad
public function process($data)
{
    if ($data !== null) {
        if (count($data) > 0) {
            // ... complex logic
        }
    }
}

// Good
public function process($data)
{
    if ($data === null) {
        return;
    }
    
    if (count($data) === 0) {
        return;
    }
    
    // ... complex logic with less nesting
}
```

## Code Quality Standards

### Naming Conventions
- Use descriptive, meaningful names
- Follow PSR-12 coding standards
- Use camelCase for variables and methods
- Use PascalCase for classes
- Use UPPER_CASE for constants

### Documentation
- Add PHPDoc blocks for classes and methods
- Document complex logic with inline comments
- Keep comments up-to-date with code changes
- Explain "why" rather than "what" in comments

### Testing
- Write unit tests for business logic
- Aim for high code coverage
- Test edge cases and error conditions
- Use meaningful test names

### Performance
- Avoid N+1 queries
- Use eager loading for relationships
- Cache expensive operations
- Profile and optimize bottlenecks

### Security
- Validate and sanitize all inputs
- Use parameterized queries
- Implement proper authentication and authorization
- Follow OWASP security guidelines
- Never expose sensitive data in logs or responses

## Laravel Best Practices

### Service Providers
- Keep service providers focused and single-purpose
- Use deferred providers when possible
- Register bindings in the register method
- Bootstrap in the boot method

### Middleware
- Keep middleware lightweight
- Handle one concern per middleware
- Use middleware groups for common stacks
- Leverage Laravel's built-in middleware

### Controllers
- Keep controllers thin
- Delegate business logic to services/actions
- Use form requests for validation
- Return consistent response formats

### Models
- Use accessors and mutators for data transformation
- Define relationships clearly
- Scope queries with query scopes
- Keep models focused on data representation

### Database
- Use migrations for schema changes
- Write reversible migrations
- Use seeders for test data
- Index frequently queried columns

## Git Practices

### Commits
- Write clear, descriptive commit messages
- Make atomic commits (one logical change per commit)
- Use conventional commit format when applicable
- Reference issue numbers in commits

### Branches
- Use feature branches for development
- Keep branches short-lived
- Rebase on main regularly
- Delete merged branches

### Pull Requests
- Write clear PR descriptions
- Keep PRs focused and reviewable
- Address review feedback promptly
- Ensure CI passes before requesting review

## Service Layer Pattern

### Overview
The Service Layer pattern separates business logic from controllers, making code more maintainable, testable, and reusable.

### Structure
```
app/
├── Services/
│   ├── UserService.php
│   ├── ProductService.php
│   └── OrderService.php
└── Http/Controllers/
    ├── UserController.php
    ├── ProductController.php
    └── OrderController.php
```

### Service Class Template
```php
<?php

namespace App\Services;

use App\Models\YourModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class YourModelService
{
    /**
     * Get all records with optional filtering.
     *
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = YourModel::query();

        // Apply filters with early returns
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $perPage > 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find a record by ID.
     *
     * @param int $id
     * @return YourModel|null
     */
    public function find(int $id): ?YourModel
    {
        return YourModel::find($id);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return YourModel
     * @throws \Exception
     */
    public function create(array $data): YourModel
    {
        DB::beginTransaction();

        try {
            $model = YourModel::create($data);
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $data
     * @return YourModel
     * @throws \Exception
     */
    public function update(int $id, array $data): YourModel
    {
        $model = $this->find($id);

        if (!$model) {
            throw new \Exception("Record not found with ID: {$id}");
        }

        DB::beginTransaction();

        try {
            $model->update($data);
            DB::commit();
            return $model->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $model = $this->find($id);

        if (!$model) {
            throw new \Exception("Record not found with ID: {$id}");
        }

        return $model->delete();
    }
}
```

### Controller Using Service
```php
<?php

namespace App\Http\Controllers;

use App\Services\YourModelService;
use Illuminate\Http\Request;

class YourModelController extends Controller
{
    protected YourModelService $service;

    public function __construct(YourModelService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'search']);
        $data = $this->service->getAll($filters);

        return view('your-view', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // ... other validation rules
        ]);

        try {
            $model = $this->service->create($validated);
            return redirect()->route('your.route')->with('success', 'Created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // ... other validation rules
        ]);

        try {
            $model = $this->service->update($id, $validated);
            return redirect()->route('your.route')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->service->delete($id);
            return redirect()->route('your.route')->with('success', 'Deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
```

### Benefits of Service Layer
- **Separation of Concerns**: Business logic separated from HTTP layer
- **Reusability**: Services can be used across multiple controllers, commands, jobs
- **Testability**: Easy to unit test business logic independently
- **Maintainability**: Changes to business logic don't affect controllers
- **SOLID Compliance**: Follows Single Responsibility and Dependency Inversion principles

### Testing Services
```php
<?php

namespace Tests\Unit\Services;

use App\Services\YourModelService;
use App\Models\YourModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YourModelServiceTest extends TestCase
{
    use RefreshDatabase;

    protected YourModelService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new YourModelService();
    }

    /** @test */
    public function it_can_create_a_record()
    {
        $data = ['name' => 'Test'];
        $model = $this->service->create($data);

        $this->assertInstanceOf(YourModel::class, $model);
        $this->assertEquals('Test', $model->name);
    }

    /** @test */
    public function it_throws_exception_when_updating_non_existent_record()
    {
        $this->expectException(\Exception::class);
        $this->service->update(99999, ['name' => 'Test']);
    }
}
```

### Best Practices
1. **Keep services focused**: One service per model or domain
2. **Use dependency injection**: Inject services into controllers
3. **Handle transactions**: Wrap database operations in transactions
4. **Throw meaningful exceptions**: Provide clear error messages
5. **Return appropriate types**: Use type hints for return values
6. **Validate early**: Check for null/invalid data at method start
7. **Document thoroughly**: Add PHPDoc blocks for all public methods

## Frontend Development Guidelines

### CoreUI 2.16 Framework

This project uses CoreUI 2.16 for the admin interface. Follow these guidelines when working with views:

#### CoreUI Component Usage

**Use CoreUI components instead of AdminLTE:**

```html
<!-- ✅ Correct - CoreUI -->
<div class="card">
  <div class="card-header">Header</div>
  <div class="card-body">Content</div>
</div>

<!-- ❌ Avoid - AdminLTE (compatibility layer exists but prefer CoreUI) -->
<div class="box box-primary">
  <div class="box-header">Header</div>
  <div class="box-body">Content</div>
</div>
```

#### CoreUI Layout Structure

```html
<!-- Main Layout Structure -->
<body class="c-app">
    <!-- Sidebar -->
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show">
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fas fa-home"></i>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed">
            <!-- Header content -->
        </header>
        
        <div class="c-body">
            <main class="c-main">
                <!-- Page content -->
            </main>
        </div>
    </div>
</body>
```

#### CoreUI Components

**Cards (replacing AdminLTE boxes):**
```html
<!-- Info widget -->
<div class="card text-white bg-info">
  <div class="card-body">
    <div class="text-value-xl">150</div>
    <div>New Orders</div>
  </div>
</div>

<!-- Standard card -->
<div class="card">
  <div class="card-header">
    <strong>Card Title</strong>
    <div class="card-header-actions">
      <a href="#" class="card-header-action">Action</a>
    </div>
  </div>
  <div class="card-body">
    Card content
  </div>
  <div class="card-footer">
    Footer content
  </div>
</div>
```

**Alerts (replacing callouts):**
```html
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Info!</h4>
  <p>This is an informational message.</p>
</div>
```

**Widgets:**
```html
<!-- Info widget with icon -->
<div class="card">
  <div class="card-body p-3 d-flex align-items-center">
    <div class="bg-info p-3 mr-3 rounded">
      <i class="fas fa-users text-white fa-2x"></i>
    </div>
    <div>
      <div class="text-muted small">Users</div>
      <div class="text-value">1,234</div>
    </div>
  </div>
</div>
```

#### CSS Variables for Theming

CoreUI uses CSS custom properties for easy theming. Leverage these instead of hardcoded colors:

```html
<style>
  :root {
    /* Override theme colors */
    --primary: #321fdb;
    --sidebar-bg: #2c384a;
    --navbar-bg: #fff;
    
    /* Component customization */
    --card-bg: #fff;
    --border-color: #d8dbe0;
  }
</style>
```

#### Best Practices for Blade Templates

1. **Use CoreUI classes consistently**
   - Prefer `c-*` prefixed classes for layout
   - Use Bootstrap 4 utility classes for styling
   - Avoid mixing AdminLTE and CoreUI classes in new code

2. **Maintain responsive design**
   ```html
   <div class="row">
     <div class="col-lg-4 col-md-6 col-sm-12">
       <!-- Content -->
     </div>
   </div>
   ```

3. **Use semantic HTML**
   ```html
   <nav class="breadcrumb">
     <a class="breadcrumb-item" href="#">Home</a>
     <span class="breadcrumb-item active">Page</span>
   </nav>
   ```

4. **Accessibility**
   - Include `aria-*` attributes where appropriate
   - Use semantic HTML5 elements
   - Ensure proper heading hierarchy
   - Add `alt` text to images

5. **RTL Support**
   - Use `dir` attribute: `<html dir="{{ in_array(app()->getLocale(), ['ar', 'he']) ? 'rtl' : 'ltr' }}">`
   - CoreUI handles RTL automatically with proper setup

#### Component Migration Reference

| AdminLTE | CoreUI | Notes |
|----------|--------|-------|
| `.box` | `.card` | Main container |
| `.box-header` | `.card-header` | Header section |
| `.box-body` | `.card-body` | Body content |
| `.box-footer` | `.card-footer` | Footer section |
| `.small-box` | `.card.text-white.bg-*` | Dashboard widgets |
| `.info-box` | Custom card layout | Info widgets |
| `.callout` | `.alert` | Alert boxes |
| `.main-sidebar` | `.c-sidebar` | Sidebar navigation |
| `.content-wrapper` | `.c-body > .c-main` | Main content area |

#### Documentation

See comprehensive CoreUI documentation in repository:
- `COREUI-QUICKSTART.md` - Quick start guide
- `COREUI-CSS-VARIABLES-GUIDE.md` - CSS variables reference
- `MIGRATION-GUIDE-ADMINLTE-TO-COREUI.md` - Migration guide
- `ADMINLTE-TO-COREUI-COMPONENT-MAPPING.md` - Component mapping

