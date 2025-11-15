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
