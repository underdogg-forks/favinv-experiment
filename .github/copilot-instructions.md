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


## Frontend: Tailwind CSS v4 Guidelines

### Tailwind CSS Framework

This project uses **Tailwind CSS v4** - the latest version of the utility-first framework for the admin interface.

#### What's New in v4

- **CSS-First Configuration**: Use `@theme` in CSS instead of `tailwind.config.js`
- **Built-in Plugins**: Forms and typography support built-in
- **Faster Performance**: Significantly improved build times
- **Native CSS**: Uses modern CSS features like custom properties

#### 1. Use Tailwind Utility Classes

**✅ Correct - Tailwind CSS:**
```html
<div class="bg-white rounded-lg shadow">
  <div class="px-6 py-4 border-b border-gray-200 font-semibold">Title</div>
  <div class="p-6">Content</div>
</div>
```

**❌ Avoid - Bootstrap/CoreUI:**
```html
<div class="card">
  <div class="card-header">Title</div>
  <div class="card-body">Content</div>
</div>
```

#### 2. Tailwind Layout Structure

```html
<body class="bg-gray-100">
  <!-- Sidebar -->
  <aside class="sidebar">
    <nav class="sidebar-nav">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        Home
      </a>
    </nav>
  </aside>
  
  <!-- Main Content -->
  <div class="app-body">
    <header class="app-header">
      <!-- Header -->
    </header>
    <main class="main">
      <!-- Content -->
    </main>
  </div>
</body>
```

#### 3. Common Patterns

**Cards:**
```html
<div class="card">
  <div class="card-header">Title</div>
  <div class="card-body">Content</div>
</div>
```

**Buttons:**
```html
<button class="btn btn-primary">
  Save
</button>
```

**Alerts:**
```html
<div class="alert alert-success">
  Success message
</div>
```

#### 4. Bootstrap/CoreUI to Tailwind Migration

| Bootstrap/CoreUI | Tailwind CSS |
|------------------|--------------|
| `.card` | `.bg-white .rounded-lg .shadow` |
| `.card-header` | `.px-6 .py-4 .border-b` |
| `.btn-primary` | `.bg-blue-600 .text-white .px-4 .py-2 .rounded` |
| `.alert-success` | `.bg-green-50 .border .border-green-200 .text-green-800 .p-4 .rounded` |
| `.d-flex` | `.flex` |
| `.justify-content-between` | `.justify-between` |

#### 5. Best Practices

- **Utility-first**: Compose with utility classes
- **Custom components**: Use `@layer components` for reusable patterns
- **Responsive**: Use `sm:`, `md:`, `lg:` prefixes
- **Consistency**: Follow Tailwind conventions

#### 6. Documentation

- `TAILWIND-QUICKSTART.md` - Getting started
- `BOOTSTRAP-TO-TAILWIND-MIGRATION.md` - Migration guide
- `TAILWIND-AI-AGENT-GUIDE.md` - AI agent instructions


## Build System: Vite

This project uses **Vite 6.0** as the build system for compiling CSS and JavaScript assets.

### Development

Start the Vite development server with Hot Module Replacement:

```bash
npm run dev
```

This starts the Vite dev server on `http://localhost:5173` with instant HMR.

### Production Build

Build optimized assets for production:

```bash
npm run build
```

Output: `public/build/` directory with versioned, optimized assets.

### Asset Loading

Use the `@vite` directive in blade templates:

```blade
@vite(['resources/assets/css/app.css', 'resources/assets/js/app.js'])
```

This automatically:
- Loads from dev server in development (with HMR)
- Loads versioned assets in production
- Handles cache busting

### Benefits

- ⚡ **10-100x faster** builds than webpack
- 🔥 **Instant HMR** - See changes in milliseconds
- 📦 **Smaller bundles** - Better tree-shaking
- 🎯 **Better DX** - Clear errors, fast feedback

See `VITE-MIGRATION-GUIDE.md` for complete documentation.

