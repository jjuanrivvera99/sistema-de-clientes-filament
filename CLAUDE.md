# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 11 customer management system built with Filament v3 admin panel. The application manages customers, their document types, memberships, and contact information. It includes features for customer registration, soft deletes, data export, and activity logging.

## Core Architecture

### Domain Models
- **Customer**: Central entity with soft deletes, comments support via `HasFilamentComments`
- **DocumentType**: Reference data for customer identification documents
- **Membership**: One-to-one relationship with customers, tracks membership status
- **Contact**: One-to-many relationship with customers (max 3 contacts per customer)

### Key Relationships
- Customer belongs to DocumentType
- Customer has one Membership
- Customer has many Contacts (max 3)
- Soft delete on Customer automatically sets membership status to inactive

### Filament Resources
All admin functionality is built with Filament v3 resources located in `app/Filament/Resources/`:
- `CustomerResource`: Main customer management with export functionality
- `DocumentTypeResource`: Document type management
- `MembershipResource`: Membership management
- `TrashedCustomerResource`: Soft-deleted customer management
- `UserResource`: User management

## Common Development Commands

### Laravel/Artisan Commands
```bash
# Run the application
php artisan serve

# Database operations
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Generate application key
php artisan key:generate

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Storage link
php artisan storage:link
```

### Frontend Development
```bash
# Install dependencies
npm install

# Development server with hot reloading
npm run dev

# Build for production
npm run build
```

### Testing
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run tests with coverage
php artisan test --coverage
```

### Code Quality & Static Analysis

#### CI/CD Pipeline
The project uses an optimized GitHub Actions workflow with parallel job execution:
- **code-style-and-analysis**: Runs Laravel Pint and PHPStan in parallel (fast validation)
- **tests-and-security**: Runs full test suite, security audit, and dependency checks
- **deployment-check**: Final validation for main branch deployments

#### Local Development Commands
```bash
# Laravel Pint (code formatting)
./vendor/bin/sail exec laravel.test ./vendor/bin/pint

# Check code formatting without fixing
./vendor/bin/sail exec laravel.test ./vendor/bin/pint --test

# Static Analysis with PHPStan
./vendor/bin/sail composer analyse

# Static Analysis with cache clearing
./vendor/bin/sail composer analyse-clear

# Run complete code quality suite
./vendor/bin/sail exec laravel.test ./vendor/bin/pint --test && ./vendor/bin/sail composer analyse
```

#### Git Hooks for Automated Quality Checks

The project includes pre-commit hooks that automatically run code quality checks before each commit:

```bash
# Install git hooks (one-time setup)
./hooks/install-hooks.sh

# The hook will automatically run on each commit:
# 1. Laravel Pint (code style check)
# 2. PHPStan (static analysis)
# 3. Auto-fix code style issues
# 4. Re-stage modified files

# To skip hooks (not recommended)
git commit --no-verify

# To manually test the hook
.git/hooks/pre-commit
```

**Benefits of Pre-commit Hooks:**
- Prevents committing code that doesn't meet quality standards
- Automatically fixes code style issues
- Catches static analysis errors early
- Ensures consistent code quality across the team
- Reduces CI failures due to code quality issues
```

### Blueprint Code Generation
The project uses Laravel Blueprint for code generation. The schema is defined in `draft.yml`:
```bash
# Generate code from draft.yml
php artisan blueprint:build
```

## Important Plugins & Extensions

### Filament Plugins
- **Filament Shield**: Role-based permissions (`filament-shield`)
- **Jobs Monitor**: Queue job monitoring (`filament-jobs-monitor`)
- **Edit Profile**: User profile management (`filament-edit-profile`)  
- **Comments**: Comment system on resources (`filament-comments`)
- **Logger**: Activity logging (`filament-logger`)
- **Impersonate**: User impersonation functionality (`filament-impersonate`)

### Configuration
- Admin panel path: `/admin`
- Primary color: Amber
- Database notifications enabled
- User avatar support in profile editing

## Database Architecture

### Migration Pattern
- Standard Laravel timestamps on all models
- Soft deletes on Customer model
- Foreign key constraints with cascade deletes
- Unique constraints on document combinations

### Database Configuration
- **Production**: MySQL (configured in .env)
- **Testing/CI**: SQLite (phpunit.xml configuration)

#### Why SQLite for Testing?
The project uses SQLite for testing and CI environments for several strategic reasons:
- **Performance**: In-memory SQLite databases are significantly faster than MySQL for test execution
- **Simplicity**: No external service setup required in CI environments
- **Reliability**: No network dependencies that could cause flaky tests
- **Cost Efficiency**: Reduced CI resource usage and execution time
- **Compatibility**: Laravel/Eloquent provides identical functionality across both databases
- **Isolation**: Each test run gets a fresh database state
- **CI Optimization**: Parallel jobs can use in-memory databases without conflicts

### Key Tables
- `customers`: Core customer data with soft deletes
- `document_types`: Reference data for ID types
- `memberships`: Customer membership information
- `contacts`: Customer contact details (phone, email, address)

## Testing Structure

Tests are organized in `tests/` directory:
- `Feature/`: Integration tests including auth flow and controller tests
- `Unit/`: Unit tests for individual components
- PHPUnit configuration in `phpunit.xml`

## Development Notes

- Use `php artisan tinker` for REPL debugging
- Blueprint stubs are customized in `stubs/blueprint/`
- Docker support available via `docker-compose.yml`
- Vite for asset compilation with Livewire component refresh
- TailwindCSS with Flowbite components for styling

## File Structure Highlights

- `app/Filament/`: All Filament admin panel components
- `app/Livewire/`: Livewire components (e.g., CustomerStatsOverview)
- `app/Policies/`: Authorization policies for all resources
- `database/factories/`: Model factories for testing
- `database/seeders/`: Database seeders
- `resources/views/`: Blade templates (auth, customer views)

## Development Best Practices

- Remember to use 'sail' command for any bash operation regarding php, composer or project related.

## 🚨 MANDATORY CODE QUALITY REQUIREMENTS

**ALL CODE CHANGES MUST PASS THE FOLLOWING CHECKS BEFORE BEING COMMITTED OR MERGED:**

### Required Pre-Commit Checks
1. **Code Style**: `./vendor/bin/sail exec laravel.test ./vendor/bin/pint --test`
2. **Static Analysis**: `./vendor/bin/sail composer analyse`
3. **Tests**: `./vendor/bin/sail exec laravel.test php artisan test` *(Currently requires database setup)*

### GitHub Actions Workflow
The project has automated quality checks in `.github/workflows/code-quality.yml` that run on every push and pull request:

- ✅ Laravel Pint code style verification
- ✅ PHPStan static analysis (Level 5)
- ✅ Full test suite with coverage
- ✅ Security audit
- ✅ Dependency checks

### For Developers
Before pushing code or creating a pull request:

```bash
# Run the complete quality check suite
./vendor/bin/sail exec laravel.test ./vendor/bin/pint --test
./vendor/bin/sail composer analyse

# Note: Tests currently require database setup configuration
# ./vendor/bin/sail exec laravel.test php artisan test

# If any check fails, fix the issues before proceeding
```

### For Code Reviews
- Pull requests MUST have all GitHub Actions checks passing
- Code that doesn't meet these standards will be automatically rejected
- Use the existing Claude Code Review workflow for additional feedback

### Static Analysis Configuration
- PHPStan configuration: `phpstan.neon`
- Analysis level: 5 (strict but practical)
- Optimized for Laravel + Filament patterns
- Excludes common false positives while catching real issues