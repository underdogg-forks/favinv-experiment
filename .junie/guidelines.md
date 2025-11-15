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

