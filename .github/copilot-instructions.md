# GitHub Copilot Instructions

## Code Quality Standards

When generating or refactoring code, always follow these principles:

### SOLID Principles
1. **Single Responsibility**: Each class/method should have one clear purpose
2. **Open/Closed**: Design for extension without modification
3. **Liskov Substitution**: Subtypes must be substitutable for base types
4. **Interface Segregation**: Use focused, specific interfaces
5. **Dependency Inversion**: Depend on abstractions, not implementations

### DRY (Don't Repeat Yourself)
- Extract duplicate code into reusable functions/classes
- Use constants for repeated values
- Leverage Laravel's helper functions and utilities
- Create service classes for shared business logic

### Early Returns
- Always validate inputs at the start of methods
- Return early on error conditions or edge cases
- Avoid deep nesting by handling special cases first
- Improve readability with guard clauses

Example:
```php
// Prefer this
public function handle($request)
{
    if (!$request->isValid()) {
        return response()->json(['error' => 'Invalid request'], 400);
    }
    
    if (!$request->user()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    // Main logic here
}

// Over this
public function handle($request)
{
    if ($request->isValid()) {
        if ($request->user()) {
            // Main logic nested deeply
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    } else {
        return response()->json(['error' => 'Invalid request'], 400);
    }
}
```

## Laravel-Specific Guidelines

### Service Providers
- Register bindings in `register()` method
- Bootstrap application services in `boot()` method
- Use deferred providers for services not always needed
- Keep providers focused on a single responsibility

### Middleware
- Each middleware should handle one concern
- Use early returns for failed checks
- Leverage Laravel's built-in middleware when available
- Keep middleware stateless

### Controllers
- Keep controllers thin - delegate to services/actions
- Use form requests for validation
- Return consistent response types
- Use resource controllers for RESTful operations

### Models
- Define clear, explicit relationships
- Use query scopes for reusable queries
- Implement accessors/mutators for data transformation
- Keep models focused on data representation

### Routes
- Group related routes
- Use route model binding
- Name routes for easier reference
- Apply middleware at the route level

### Database
- Use migrations for all schema changes
- Write reversible migrations
- Use database transactions for multi-step operations
- Index columns used in WHERE, ORDER BY, and JOIN clauses

## Code Style

### Naming
- Classes: `PascalCase`
- Methods/Variables: `camelCase`
- Constants: `UPPER_SNAKE_CASE`
- Use descriptive, meaningful names
- Avoid abbreviations unless universally understood

### Documentation
- Add PHPDoc blocks to all public methods
- Document complex logic with inline comments
- Include `@param`, `@return`, and `@throws` tags
- Keep comments up-to-date with code

### Type Hints
- Always use type hints for parameters
- Declare return types for all methods
- Use nullable types when appropriate: `?Type`
- Leverage union types in PHP 8+: `Type1|Type2`

### Error Handling
- Use exceptions for exceptional conditions
- Validate inputs early with early returns
- Log errors appropriately
- Return meaningful error messages

## Security

- Validate and sanitize all inputs
- Use Laravel's built-in protection (CSRF, XSS, SQL injection)
- Never expose sensitive data in responses or logs
- Use authorization gates and policies
- Keep dependencies updated

## Testing

- Write tests for business logic
- Use descriptive test method names
- Follow Arrange-Act-Assert pattern
- Test edge cases and error conditions
- Aim for high but practical code coverage

## Performance

- Use eager loading to avoid N+1 queries
- Cache expensive operations
- Use database indexing appropriately
- Profile before optimizing
- Avoid premature optimization

## Git Commit Messages

Format:
```
<type>: <subject>

<body>

<footer>
```

Types:
- `feat`: New feature
- `fix`: Bug fix
- `refactor`: Code refactoring
- `docs`: Documentation changes
- `style`: Code style changes
- `test`: Test additions/changes
- `chore`: Maintenance tasks

Example:
```
feat: Add user authentication with 2FA

Implement two-factor authentication using Google Authenticator.
Includes QR code generation and recovery codes.

Closes #123
```

## Pull Request Guidelines

- Keep PRs focused and small
- Write clear descriptions
- Include screenshots for UI changes
- Ensure all tests pass
- Address review feedback promptly
- Update documentation as needed

## Refactoring Checklist

When refactoring code:
- [ ] Apply SOLID principles
- [ ] Remove code duplication (DRY)
- [ ] Use early returns to reduce nesting
- [ ] Add/update type hints
- [ ] Add/update documentation
- [ ] Ensure tests still pass
- [ ] Check for security issues
- [ ] Verify performance isn't degraded
- [ ] Update related documentation

## Common Patterns

### Service Pattern
```php
class UserService
{
    public function createUser(array $data): User
    {
        // Validation happens in FormRequest
        
        DB::beginTransaction();
        try {
            $user = User::create($data);
            $this->assignDefaultRole($user);
            DB::commit();
            
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
```

### Repository Pattern
```php
interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function create(array $data): User;
}

class UserRepository implements UserRepositoryInterface
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }
    
    public function create(array $data): User
    {
        return User::create($data);
    }
}
```

### Action Pattern
```php
class CreateUserAction
{
    public function execute(CreateUserData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }
}
```

## Remember

- **Readability over cleverness**: Write code that others can understand
- **Simplicity over complexity**: Choose the simplest solution that works
- **Consistency**: Follow established patterns in the codebase
- **Test**: Ensure your changes work as expected
- **Document**: Help future developers (including yourself) understand your code

## Frontend: CoreUI 2.16 Guidelines

### CoreUI Framework

This project uses **CoreUI 2.16** for the admin interface. When working with Blade templates:

#### 1. Use CoreUI Components

**✅ Correct - CoreUI:**
```html
<div class="card">
  <div class="card-header">Title</div>
  <div class="card-body">Content</div>
</div>
```

**❌ Avoid - AdminLTE (compatibility exists but use CoreUI for new code):**
```html
<div class="box box-primary">
  <div class="box-header">Title</div>
  <div class="box-body">Content</div>
</div>
```

#### 2. CoreUI Layout Structure

```html
<body class="c-app">
  <!-- Sidebar -->
  <div class="c-sidebar c-sidebar-dark c-sidebar-fixed">
    <ul class="c-sidebar-nav">
      <li class="c-sidebar-nav-item">
        <a href="#" class="c-sidebar-nav-link">
          <i class="c-sidebar-nav-icon fas fa-home"></i>
          Home
        </a>
      </li>
    </ul>
  </div>
  
  <!-- Main Content -->
  <div class="c-wrapper">
    <header class="c-header c-header-fixed"></header>
    <div class="c-body">
      <main class="c-main">
        <!-- Your content -->
      </main>
    </div>
  </div>
</body>
```

#### 3. Common CoreUI Components

**Cards:**
```html
<!-- Widget card -->
<div class="card text-white bg-primary">
  <div class="card-body">
    <div class="text-value-xl">150</div>
    <div>New Users</div>
  </div>
</div>

<!-- Standard card -->
<div class="card">
  <div class="card-header">
    <strong>Title</strong>
  </div>
  <div class="card-body">
    Content here
  </div>
</div>
```

**Alerts:**
```html
<div class="alert alert-success" role="alert">
  Success message
</div>
```

#### 4. CSS Variables for Theming

Leverage CSS custom properties for easy customization:

```css
:root {
  --primary: #321fdb;
  --sidebar-bg: #2c384a;
  --navbar-bg: #fff;
  --card-bg: #fff;
}
```

#### 5. Migration Reference

When refactoring existing views:

| AdminLTE | CoreUI |
|----------|--------|
| `.box` | `.card` |
| `.box-header` | `.card-header` |
| `.box-body` | `.card-body` |
| `.small-box` | `.card.text-white.bg-*` |
| `.callout` | `.alert` |
| `.main-sidebar` | `.c-sidebar` |
| `.content-wrapper` | `.c-body .c-main` |

#### 6. Best Practices

- **Consistency**: Use CoreUI classes throughout
- **Responsive**: Use Bootstrap 4 grid (`col-lg-*`, `col-md-*`)
- **Semantic HTML**: Use proper HTML5 elements
- **Accessibility**: Add `aria-*` attributes
- **RTL Support**: CoreUI handles RTL automatically

#### 7. Documentation

Reference these files in the repository:
- `COREUI-QUICKSTART.md` - Getting started
- `COREUI-CSS-VARIABLES-GUIDE.md` - Theming guide
- `MIGRATION-GUIDE-ADMINLTE-TO-COREUI.md` - Migration details
- `ADMINLTE-TO-COREUI-COMPONENT-MAPPING.md` - Component reference
