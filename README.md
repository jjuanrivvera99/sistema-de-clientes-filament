# Sistema de Clientes - Customer Management System

A comprehensive customer management system built with Laravel 11 and Filament v3 admin panel. This application provides a complete solution for managing customers, their document types, memberships, and contact information with advanced features like soft deletes, activity logging, and data export capabilities.

## 🚀 Features

### Core Functionality
- **Customer Management**: Complete CRUD operations with soft delete support
- **Document Types**: Manage different types of identification documents
- **Membership System**: Track customer membership status and information
- **Contact Management**: Store multiple contacts per customer (max 3)
- **Soft Deletes**: Safely delete customers with recovery options
- **Activity Logging**: Track all system activities and changes
- **Data Export**: Export customer data in various formats
- **Comment System**: Add comments to customer records

### Admin Panel Features
- **Modern UI**: Built with Filament v3 for intuitive administration
- **Role-based Permissions**: Comprehensive permission system with Shield
- **User Management**: Complete user administration with role assignments
- **Queue Monitoring**: Real-time job queue monitoring
- **Database Notifications**: In-app notification system
- **Profile Management**: User profile editing with avatar support
- **User Impersonation**: Admin ability to impersonate other users

### Technical Features
- **Laravel 11**: Latest Laravel framework with modern PHP features
- **MySQL Database**: Robust relational database with optimized queries
- **Queue System**: Background job processing for heavy operations
- **Localization**: Multi-language support (Spanish/English)
- **Docker Support**: Full Docker development environment with Laravel Sail
- **Testing Suite**: Comprehensive test coverage with PHPUnit
- **Code Quality**: Laravel Pint for consistent code formatting

## 🛠 Technology Stack

- **Backend**: Laravel 11 with PHP 8.3
- **Admin Panel**: Filament v3
- **Database**: MySQL 8.0
- **Frontend**: TailwindCSS with Flowbite components
- **Asset Compilation**: Vite with Livewire support
- **Containerization**: Docker with Laravel Sail
- **Testing**: PHPUnit with Feature and Unit tests

## 📦 Key Packages

- **filament/filament**: Modern admin panel framework
- **filament-shield**: Role-based access control
- **filament-jobs-monitor**: Queue monitoring dashboard
- **filament-edit-profile**: User profile management
- **filament-comments**: Comment system for resources
- **filament-logger**: Activity logging
- **filament-impersonate**: User impersonation functionality
- **spatie/laravel-permission**: Permission management
- **spatie/laravel-activitylog**: Activity logging
- **laravel/sail**: Docker development environment

## 🚀 Quick Start

### Prerequisites

- Docker and Docker Compose
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd sistema-de-clientes-filament
   ```

2. **Install Dependencies with Docker**
   ```bash
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php83-composer:latest \
       composer install --ignore-platform-reqs
   ```

3. **Start the Development Environment**
   ```bash
   ./vendor/bin/sail up -d
   ```

4. **Set up the Database**
   ```bash
   # Wait for MySQL to fully initialize (about 15-20 seconds)
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```

5. **Install Shield Permissions**
   ```bash
   ./vendor/bin/sail artisan shield:install --fresh
   ```

6. **Create Super Admin User**
   ```bash
   ./vendor/bin/sail artisan tinker --execute="
   \$user = App\Models\User::create([
       'name' => 'Admin User',
       'email' => 'admin@admin.com',
       'password' => bcrypt('password')
   ]);
   \$user->assignRole('super_admin');
   echo 'Super admin created: ' . \$user->email;
   "
   ```

### Access the Application

- **Main Application**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/admin
- **Email Testing (Mailpit)**: http://localhost:8026
- **MySQL**: localhost:3308

**Default Admin Credentials:**
- Email: `admin@admin.com`
- Password: `password`

## 🔧 Development

### Common Commands

```bash
# Start the development environment
./vendor/bin/sail up -d

# Stop the environment
./vendor/bin/sail down

# View logs
./vendor/bin/sail logs

# Run Artisan commands
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan tinker

# Run tests
./vendor/bin/sail test

# Code formatting
./vendor/bin/sail exec laravel.test ./vendor/bin/pint

# Install npm dependencies
./vendor/bin/sail npm install

# Start Vite development server
./vendor/bin/sail npm run dev

# Build for production
./vendor/bin/sail npm run build
```

### Database Operations

```bash
# Fresh migration with seeding
./vendor/bin/sail artisan migrate:fresh --seed

# Run specific seeder
./vendor/bin/sail artisan db:seed --class=DocumentTypeSeeder

# Generate application key
./vendor/bin/sail artisan key:generate
```

### Code Generation with Blueprint

The project uses Laravel Blueprint for rapid code generation:

```bash
# Generate code from draft.yml
./vendor/bin/sail artisan blueprint:build
```

## 📊 Database Schema

### Core Tables

- **customers**: Main customer data with soft deletes
- **document_types**: Reference data for identification types
- **memberships**: Customer membership information (1:1 with customers)
- **contacts**: Customer contact details (1:many, max 3 per customer)

### System Tables

- **users**: Application users with role-based permissions
- **roles**: User roles for access control
- **permissions**: Granular permissions system
- **activity_log**: System activity tracking
- **notifications**: Database notifications

## 🧪 Testing

```bash
# Run all tests
./vendor/bin/sail test

# Run with coverage
./vendor/bin/sail test --coverage

# Run specific test suite
./vendor/bin/sail test --testsuite=Feature
./vendor/bin/sail test --testsuite=Unit
```

## 🎯 Project Structure

```
app/
├── Filament/           # Filament admin resources
│   ├── Resources/      # CRUD resources
│   ├── Pages/          # Custom pages
│   └── Widgets/        # Dashboard widgets
├── Livewire/           # Livewire components
├── Models/             # Eloquent models
├── Policies/           # Authorization policies
└── ...

database/
├── factories/          # Model factories
├── migrations/         # Database migrations
└── seeders/           # Database seeders

resources/
├── views/             # Blade templates
└── js/                # Frontend assets

tests/
├── Feature/           # Integration tests
└── Unit/              # Unit tests
```

## 🚨 Troubleshooting

### MySQL Connection Issues

If you encounter database connection errors during setup:

1. **Socket Lock Issues**: MySQL containers may fail due to socket locks
   ```bash
   ./vendor/bin/sail down -v  # Remove volumes
   ./vendor/bin/sail up -d    # Restart fresh
   ```

2. **Shield Bootstrap Error**: If migrations fail due to missing roles table
   ```bash
   # Temporarily disable HasPanelShield trait in User model
   # Run migrations, then re-enable the trait
   ```

3. **Container Not Starting**: Check container logs
   ```bash
   ./vendor/bin/sail logs mysql
   ./vendor/bin/sail logs laravel.test
   ```

### Permission Issues

1. **File Permissions**: Ensure proper file permissions for Docker
   ```bash
   sudo chown -R $(id -u):$(id -g) .
   ```

2. **Storage Permissions**: Laravel storage directory permissions
   ```bash
   ./vendor/bin/sail artisan storage:link
   chmod -R 775 storage bootstrap/cache
   ```

### Performance Issues

1. **Clear Caches**
   ```bash
   ./vendor/bin/sail artisan cache:clear
   ./vendor/bin/sail artisan config:clear
   ./vendor/bin/sail artisan route:clear
   ./vendor/bin/sail artisan view:clear
   ```

2. **Optimize for Production**
   ```bash
   ./vendor/bin/sail artisan config:cache
   ./vendor/bin/sail artisan route:cache
   ./vendor/bin/sail artisan view:cache
   ```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## 📞 Support

For issues and questions:
1. Check the troubleshooting section above
2. Review the [Laravel documentation](https://laravel.com/docs)
3. Check [Filament documentation](https://filamentphp.com/docs)
4. Open an issue in the repository