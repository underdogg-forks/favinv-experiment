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


## Frontend Development: Tailwind CSS

### Tailwind CSS Framework

This project uses **Tailwind CSS** - a utility-first CSS framework for rapid UI development.

#### Why Tailwind CSS?

1. **Utility-First**: Build designs directly in HTML with pre-defined utility classes
2. **No CSS Bloat**: Only includes styles you actually use (via PurgeCSS)
3. **Customizable**: Easy theme customization through `tailwind.config.js`
4. **Responsive**: Mobile-first with intuitive breakpoint prefixes
5. **Modern Workflow**: Integrates seamlessly with build tools

#### Core Concepts

**Utility Classes**: Single-purpose classes that do one thing well
```html
<div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
  <!-- flex: display flex -->
  <!-- items-center: align-items center -->
  <!-- justify-between: justify-content space-between -->
  <!-- p-4: padding 1rem -->
  <!-- bg-white: background white -->
  <!-- rounded-lg: border-radius 0.5rem -->
  <!-- shadow: box-shadow -->
</div>
```

#### Layout Structure

```html
<body class="bg-gray-100">
  <!-- Fixed Sidebar -->
  <aside class="sidebar">
    <div class="p-4">
      <h1 class="text-xl font-bold text-white">App Name</h1>
    </div>
    <nav class="sidebar-nav">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <span>Dashboard</span>
      </a>
    </nav>
  </aside>
  
  <!-- Main Content Area -->
  <div class="app-body">
    <!-- Header -->
    <header class="app-header">
      <div class="flex items-center justify-between px-6 py-4">
        <h2 class="text-lg font-semibold">Page Title</h2>
        <div class="flex items-center space-x-4">
          <!-- Header actions -->
        </div>
      </div>
    </header>
    
    <!-- Page Content -->
    <main class="main">
      <div class="space-y-6">
        <!-- Your content -->
      </div>
    </main>
  </div>
</body>
```

#### Component Patterns

**Card Component:**
```html
<div class="card">
  <div class="card-header">
    <h3 class="text-lg font-semibold text-gray-900">Card Title</h3>
    <div class="flex items-center space-x-2">
      <button class="text-gray-400 hover:text-gray-600">
        <i class="fas fa-ellipsis-v"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <p class="text-gray-600">Card content goes here</p>
  </div>
  <div class="card-footer">
    <button class="btn btn-primary">Action</button>
  </div>
</div>
```

**Alert Component:**
```html
<!-- Success Alert -->
<div class="alert alert-success">
  <div class="flex">
    <i class="fas fa-check-circle mr-3"></i>
    <div>
      <h4 class="font-semibold">Success!</h4>
      <p>Your changes have been saved successfully.</p>
    </div>
  </div>
</div>

<!-- Error Alert -->
<div class="alert alert-danger">
  <div class="flex">
    <i class="fas fa-exclamation-circle mr-3"></i>
    <div>
      <h4 class="font-semibold">Error!</h4>
      <p>Something went wrong. Please try again.</p>
    </div>
  </div>
</div>
```

**Button Components:**
```html
<!-- Primary Button -->
<button class="btn btn-primary">
  Primary Action
</button>

<!-- Secondary Button -->
<button class="btn btn-secondary">
  Secondary Action
</button>

<!-- With Icon -->
<button class="btn btn-primary">
  <i class="fas fa-plus mr-2"></i>
  Add New
</button>
```

**Form Components:**
```html
<div class="space-y-4">
  <div>
    <label class="form-label">Email Address</label>
    <input type="email" class="form-control" placeholder="you@example.com">
  </div>
  
  <div>
    <label class="form-label">Password</label>
    <input type="password" class="form-control">
  </div>
  
  <div>
    <button type="submit" class="btn btn-primary w-full">
      Sign In
    </button>
  </div>
</div>
```

**Table Component:**
```html
<div class="overflow-x-auto">
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-medium text-gray-900">John Doe</td>
        <td class="text-gray-600">john@example.com</td>
        <td>
          <span class="badge badge-primary">Admin</span>
        </td>
        <td>
          <button class="text-blue-600 hover:text-blue-800">Edit</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
```

#### Responsive Design

Tailwind uses mobile-first breakpoints:

```html
<!-- Stack on mobile, grid on desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <div class="card">Card 1</div>
  <div class="card">Card 2</div>
  <div class="card">Card 3</div>
</div>

<!-- Hidden on mobile, visible on desktop -->
<div class="hidden lg:block">
  Desktop only content
</div>

<!-- Full width on mobile, fixed width on desktop -->
<div class="w-full lg:w-64">
  Responsive width
</div>
```

Breakpoints:
- `sm:` - 640px and up (tablet)
- `md:` - 768px and up (tablet landscape)
- `lg:` - 1024px and up (laptop)
- `xl:` - 1280px and up (desktop)
- `2xl:` - 1536px and up (large desktop)

#### State Variants

```html
<!-- Hover States -->
<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
  Hover Me
</button>

<!-- Focus States -->
<input class="border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">

<!-- Active/Disabled States -->
<button class="active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
  Interactive Button
</button>

<!-- Group Hover (hover parent affects child) -->
<div class="group">
  <div class="bg-white group-hover:bg-gray-50">
    Hover parent to change this
  </div>
</div>
```

#### Dark Mode Support

```html
<!-- Light background, dark in dark mode -->
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
  Adapts to dark mode
</div>
```

#### RTL Support

Tailwind automatically handles RTL with the `dir="rtl"` attribute:

```html
<html dir="rtl">
  <!-- Automatically adjusts: -->
  <!-- ml-4 becomes mr-4 -->
  <!-- pl-6 becomes pr-6 -->
  <!-- left-0 becomes right-0 -->
</html>
```

#### Custom Components with @layer

In `resources/assets/css/app.css`:

```css
@layer components {
  .card {
    @apply bg-white rounded-lg shadow;
  }
  
  .card-header {
    @apply px-6 py-4 border-b border-gray-200 font-semibold text-gray-900;
  }
  
  .card-body {
    @apply p-6;
  }
  
  .btn {
    @apply inline-flex items-center px-4 py-2 border font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors;
  }
  
  .btn-primary {
    @apply border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500;
  }
}
```

#### Configuration

Customize in `tailwind.config.js`:

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: '#321fdb',
        sidebar: {
          bg: '#2c384a',
          text: '#c8ced3',
        },
      },
      fontFamily: {
        sans: ['Source Sans Pro', 'sans-serif'],
      },
      spacing: {
        '128': '32rem',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

#### Bootstrap/CoreUI to Tailwind Migration

| Bootstrap/CoreUI Class | Tailwind Equivalent |
|------------------------|---------------------|
| `.container` | `.container .mx-auto .px-4` |
| `.row` | `.flex .flex-wrap` |
| `.col-md-6` | `.w-full .md:w-1/2` |
| `.card` | `.bg-white .rounded-lg .shadow` |
| `.card-header` | `.px-6 .py-4 .border-b .border-gray-200` |
| `.card-body` | `.p-6` |
| `.btn` | `.inline-flex .items-center .px-4 .py-2 .rounded` |
| `.btn-primary` | `.bg-blue-600 .hover:bg-blue-700 .text-white` |
| `.btn-lg` | `.px-6 .py-3 .text-lg` |
| `.alert-success` | `.bg-green-50 .border .border-green-200 .text-green-800 .p-4 .rounded` |
| `.d-flex` | `.flex` |
| `.justify-content-between` | `.justify-between` |
| `.align-items-center` | `.items-center` |
| `.text-center` | `.text-center` |
| `.mt-3` | `.mt-3` (or `.mt-4` for 1rem) |
| `.mb-4` | `.mb-4` (or `.mb-6` for 1.5rem) |
| `.p-4` | `.p-4` |
| `.bg-primary` | `.bg-blue-600` |
| `.text-white` | `.text-white` |
| `.rounded` | `.rounded` |
| `.shadow` | `.shadow` |

#### Best Practices

1. **Start with utility classes**: Don't create custom CSS unless necessary
2. **Use @layer components**: For reusable patterns
3. **Mobile-first**: Design for mobile, enhance for desktop
4. **Consistent spacing**: Use Tailwind's spacing scale (0, 1, 2, 3, 4, 6, 8, 12, 16...)
5. **Semantic colors**: Use gray-* for neutrals, blue/primary for actions
6. **Accessibility**: Always include focus states and ARIA attributes

#### Documentation

Comprehensive guides available:
- `TAILWIND-QUICKSTART.md` - Quick start guide
- `BOOTSTRAP-TO-TAILWIND-MIGRATION.md` - Complete migration guide
- `TAILWIND-AI-AGENT-GUIDE.md` - Instructions for AI agents to migrate Bootstrap/CoreUI to Tailwind

