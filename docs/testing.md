# Testing Documentation - Luxe Hair Studio

## Overview
This document outlines the comprehensive testing strategy for the Luxe Hair Studio salon management system. Our testing approach ensures reliability, security, and functionality across all features of the application.

## Testing Strategy

### Test Philosophy
- **Quality Assurance**: Every feature is tested to ensure it works as expected
- **Security First**: Role-based access controls are thoroughly tested
- **User Experience**: Tests verify that users can complete their intended workflows
- **Data Integrity**: Database operations are validated for consistency

### Testing Pyramid
1. **Unit Tests (30%)**: Test individual model methods and business logic
2. **Feature Tests (60%)**: Test complete user workflows and HTTP endpoints
3. **Integration Tests (10%)**: Test external service integrations

## Test Environment Setup

### Configuration
- **Database**: SQLite in-memory database for fast, isolated tests
- **Environment**: Dedicated `.env.testing` configuration
- **Framework**: Laravel's built-in PHPUnit testing framework

### Prerequisites
```bash
# Ensure PHP 8.4+ is installed
php --version

# Install dependencies
composer install

# Run database migrations for testing
php artisan migrate --env=testing
```

## Running Tests

### All Tests
```bash
# Run the complete test suite
php artisan test

# Run tests with coverage (if XDebug enabled)
php artisan test --coverage

# Run tests in parallel (for faster execution)
php artisan test --parallel
```

### Specific Test Categories
```bash
# Run only unit tests
php artisan test tests/Unit/

# Run only feature tests  
php artisan test tests/Feature/

# Run specific test file
php artisan test tests/Feature/AuthenticationTest.php

# Run specific test method
php artisan test --filter=test_admin_can_view_customers_list
```

### Test Options
```bash
# Stop on first failure
php artisan test --stop-on-failure

# Show detailed output
php artisan test --verbose

# Run tests without output (CI environments)
php artisan test --quiet
```

## Test Structure

### Unit Tests (`tests/Unit/`)

#### CustomerTest.php
- **Purpose**: Test Customer model business logic
- **Key Tests**:
  - Loyalty points calculation based on spending
  - VIP status identification (>$1000 spent)
  - Visit statistics updates
  - Upcoming appointments detection
  - Factory state testing

#### StaffTest.php  
- **Purpose**: Test Staff model functionality
- **Key Tests**:
  - Appointment counting and commission calculation
  - Monthly revenue calculations
  - Availability checking for time slots
  - Staff hierarchy and roles
  - Factory state testing

#### AppointmentTest.php
- **Purpose**: Test Appointment model logic
- **Key Tests**:
  - Overlapping appointment detection
  - Duration calculations
  - Status management and scopes
  - Cancellation handling
  - Factory state testing

#### ServiceTest.php
- **Purpose**: Test Service model features
- **Key Tests**:
  - Revenue calculations
  - Popularity ranking
  - Price and duration filtering
  - Category associations
  - Factory state testing

### Feature Tests (`tests/Feature/`)

#### AuthenticationTest.php
- **Purpose**: Test user authentication flows
- **Key Tests**:
  - Login/logout functionality
  - Registration process
  - Role-based redirects after login
  - Input validation
  - Guest access restrictions

#### AppointmentBookingTest.php
- **Purpose**: Test complete appointment booking workflow
- **Key Tests**:
  - Customer booking process (service → staff → time → confirm)
  - Appointment viewing and management
  - Cancellation workflows
  - Staff appointment management
  - Guest access prevention

#### AdminCrudTest.php
- **Purpose**: Test administrative CRUD operations
- **Key Tests**:
  - Customer management (create, read, update, delete)
  - Staff management with validation
  - Service management
  - Dashboard analytics
  - Input validation and error handling

#### RoleBasedAccessTest.php
- **Purpose**: Test security and access control
- **Key Tests**:
  - Admin access to all features
  - Staff limited to appropriate functions
  - Customer access restrictions
  - Cross-user data access prevention
  - Middleware protection

## Test Data Management

### Factories
Laravel factories generate realistic test data:

```php
// Create test customers
Customer::factory()->count(10)->create();

// Create VIP customers
Customer::factory()->vip()->count(3)->create();

// Create staff with specific roles
Staff::factory()->manager()->create();
Staff::factory()->senior()->create();

// Create appointments with states
Appointment::factory()->upcoming()->count(5)->create();
Appointment::factory()->completed()->count(10)->create();
```

### Factory States
- **Customer**: `vip()`, `inactive()`, `newCustomer()`
- **Staff**: `senior()`, `manager()`, `inactive()`
- **Service**: `premium()`, `quick()`, `inactive()`
- **Appointment**: `upcoming()`, `completed()`, `cancelled()`, `today()`, `noShow()`

## Coverage Goals

### Target Coverage
- **Overall**: 85%+ code coverage
- **Unit Tests**: 90%+ coverage of model methods
- **Feature Tests**: 80%+ coverage of HTTP endpoints
- **Critical Paths**: 100% coverage of authentication and payment flows

### Coverage Areas
1. **Authentication & Authorization**: 100%
2. **Appointment Booking**: 95%
3. **Admin Functions**: 90%
4. **Data Models**: 85%
5. **API Endpoints**: 80%

## Test Results & Examples

### Sample Test Output
```
PHPUnit 11.5.39 by Sebastian Bergmann and contributors.

✓ Tests\Unit\CustomerTest
  ✓ it can calculate loyalty points based on total spent
  ✓ it identifies vip customers with over 1000 spent
  ✓ it returns full name attribute
  ✓ it can check if customer has upcoming appointments
  ✓ it scopes active customers

✓ Tests\Feature\AuthenticationTest  
  ✓ users can view login page
  ✓ users can login with valid credentials
  ✓ authenticated users are redirected based on role
  ✓ guests cannot access dashboard

Tests:    45 passed (123 assertions)
Duration: 2.34s
```

### Performance Benchmarks
- **Full Test Suite**: ~3-5 seconds
- **Unit Tests Only**: ~1-2 seconds  
- **Feature Tests Only**: ~2-3 seconds
- **Database Refresh**: ~0.5 seconds per test

## Testing Best Practices

### Test Writing Guidelines
1. **Descriptive Names**: Test method names should clearly describe what is being tested
2. **Single Responsibility**: Each test should verify one specific behavior
3. **Arrange, Act, Assert**: Structure tests with clear setup, execution, and verification
4. **Data Isolation**: Each test should be independent and not rely on other tests

### Example Test Structure
```php
/** @test */
public function customers_can_book_appointments()
{
    // Arrange: Set up test data
    $customer = Customer::factory()->create();
    $staff = Staff::factory()->create();
    $service = Service::factory()->create();
    
    // Act: Perform the action being tested
    $response = $this->actingAs($customer->user)
        ->post('/appointments', [
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'appointment_date' => now()->addDays(7)->format('Y-m-d'),
        ]);
    
    // Assert: Verify the expected outcome
    $response->assertRedirect();
    $this->assertDatabaseHas('appointments', [
        'customer_id' => $customer->id,
        'staff_id' => $staff->id,
    ]);
}
```

## Continuous Integration

### GitHub Actions / CI Setup
```yaml
# .github/workflows/tests.yml
name: Tests
on: [push, pull_request]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.4
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test
```

## Troubleshooting

### Common Issues

1. **Database Errors**
   - Ensure `.env.testing` is configured correctly
   - Check database migrations are up to date
   - Verify factory relationships match database schema

2. **Authentication Issues**
   - Confirm user roles are set correctly in factories
   - Check middleware is applied to routes
   - Verify session configuration in testing environment

3. **Test Failures**
   - Use `--stop-on-failure` flag to isolate issues
   - Add debug output with `dd()` or `dump()`
   - Check test database is being refreshed properly

### Debug Commands
```bash
# Clear test cache
php artisan config:clear --env=testing

# Run migrations fresh
php artisan migrate:fresh --env=testing

# Check test database connection
php artisan tinker --env=testing
>>> DB::connection()->getPdo()
```

## Maintenance

### Regular Tasks
1. **Weekly**: Review test coverage reports
2. **Sprint End**: Update tests for new features  
3. **Monthly**: Performance benchmarking
4. **Release**: Full regression testing

### Test Updates
- Add tests for all new features
- Update existing tests when requirements change
- Remove or update tests for deprecated features
- Maintain factory relationships as models evolve

## Summary

The Luxe Hair Studio testing suite provides comprehensive coverage of:
- ✅ **Authentication & Role Management**
- ✅ **Appointment Booking Workflows** 
- ✅ **Administrative CRUD Operations**
- ✅ **Data Model Business Logic**
- ✅ **Security & Access Controls**

This testing framework ensures the application is reliable, secure, and ready for production deployment while maintaining high code quality standards throughout development.