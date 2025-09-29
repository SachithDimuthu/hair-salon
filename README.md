# Luxe Hair Studio - Salon Management System

<p align="center">
    <img src="/public/images/logo/luxe-hair-studio-square.svg" width="120" alt="Luxe Hair Studio Logo">
</p>

<h1 align="center">Luxe Hair Studio</h1>
<h2 align="center">Professional Salon Management System</h2>

A comprehensive salon management system built with Laravel 11, featuring appointment booking, staff management, service catalogs, and administrative dashboards. This project was developed as part of a university assignment to demonstrate modern web development practices and database design principles.

## 📋 Project Overview

This Laravel-based salon management system implements a complete business solution for beauty salons, following industry best practices and modern web development standards. The application features a multi-tier architecture with distinct user roles, comprehensive database relationships, and interactive Livewire components.

### 🎯 Academic Objectives
- Demonstrate proficiency in Laravel framework and PHP development
- Implement comprehensive ERD (Entity Relationship Diagram) with proper relationships
- Create interactive user interfaces using Livewire components
- Apply database design principles and data normalization
- Showcase modern web development practices and clean code architecture

## 🚀 Key Features

### Core Functionality
- **Multi-role Authentication** - Secure access for Admin, Staff, and Customer roles
- **Appointment Booking System** - Complete booking workflow with service selection
- **Service Management** - Comprehensive catalog of salon services and pricing
- **Customer Management** - Customer profiles, booking history, and relationship tracking
- **Deal Management** - Promotional offers and special pricing configurations
- **Administrative Dashboard** - Real-time analytics and business insights

### Technical Features
- **Livewire Components** - 5 interactive components for seamless user experience
- **Hybrid Database Architecture** - SQLite for relational data, MongoDB for catalog data
- **MongoDB Integration** - Advanced NoSQL features for services and deals management
- **Database Relationships** - Fully implemented ERD with M:M and 1:1 relationships
- **Sample Data Integration** - Comprehensive test data for demonstration purposes
- **Responsive Design** - Mobile-friendly interface using Tailwind CSS
- **Authentication System** - Laravel Jetstream with team management capabilities

- **Staff Management** - Profiles, specializations, and working hours

- **Service Catalog** - Categories, services, pricing, and duration management- **Name:** Luxe Hair Studio

- **Dashboard Analytics** - KPIs, revenue tracking, and performance metrics- **Colors:** Purple (#6A1B9A), Pink (#E91E63), White

- **Customer Management** - Profiles, appointment history, and preferences- **Fonts:** Playfair Display (headings), Inter (body)

- **Product Inventory** - Stock management and order tracking- **Logo:** Elegant “LHS” monogram or hair-scissors icon

## 🛠️ Technology Stack

### Backend
- **Laravel 11** - Modern PHP framework with advanced features
- **PHP 8.4** - Latest PHP version with enhanced performance
- **SQLite** - Lightweight database for development and testing
- **Laravel Jetstream** - Authentication scaffolding with team management
- **Laravel Sanctum** - API token authentication

### Frontend
- **Livewire 3** - Dynamic, reactive components without JavaScript
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Minimal JavaScript framework for interactivity
- **Vite** - Fast build tool and development server

### Development Tools
- **Composer** - PHP dependency management
- **NPM** - JavaScript package management
- **PHPUnit** - Testing framework for PHP applications

## 📊 Database Architecture (ERD Implementation)

The system implements a comprehensive Entity Relationship Diagram with the following key relationships:

### Core Entities
1. **Customer** (CustomerID, Name, Email, Phone)
2. **Admin** (AdminID, Name, Email, Role)
3. **Service** (ServiceID, ServiceName, Description, Price, Duration)
## 🗄️ Database Architecture

### Hybrid Database System
The application uses a hybrid approach combining the strengths of both SQLite and MongoDB:

#### SQLite (Relational Data)
**Tables**: Customer, User, Admin, Booking, Team relationships
1. **Customer** (CustomerID, Name, Email, Phone, DateOfBirth)
2. **Admin** (AdminID, Name, Email, Role, Department)
3. **User** (UserID, Name, Email, Role, Team associations)
4. **Booking** (BookingID, CustomerID, ServiceID, BookingDate, Status)

#### MongoDB (Catalog Data)
**Collections**: Services, Deals - Enhanced with NoSQL flexibility
1. **Service** (_id, Name, Description, Price, Duration, Category, IsVisible)
2. **Deal** (_id, Title, Description, DiscountPercent, ValidUntil, Terms, MaxUses, CurrentUses)

### Database Relationships
- **Customer ↔ Service**: Many-to-Many through Bookings table
- **Admin ↔ Customer**: Many-to-Many (admin can manage multiple customers)
- **Admin ↔ Service**: Many-to-Many (admin can manage multiple services via MongoDB)
- **Admin ↔ Deal**: Many-to-Many (admin can manage multiple deals via MongoDB)
- **Service ↔ Deal**: Referenced relationship (deals reference services by _id)

### MongoDB Integration Features
- **Enhanced Fields**: Duration, Category for services; Terms, usage limits for deals
- **Flexible Schema**: Easy addition of new fields without migrations
- **Query Performance**: Optimized for catalog browsing and search
- **Scalability**: Document-based storage for growing service catalogs

## 🧩 Livewire Components

The application features 5 fully functional Livewire components updated for MongoDB integration:

### 1. BookService Component (`/book-service`)
- **Purpose**: Customer service booking interface
- **Features**: Service selection from MongoDB, date/time picker, booking confirmation
- **MongoDB Integration**: Reads services from MongoDB collection
- **File**: `app/Livewire/BookService.php`

### 2. ManageCustomers Component (`/admin/customers`)
- **Purpose**: Admin customer management interface
- **Features**: Customer listing, profile management, booking history
- **Database**: Uses SQLite for customer data
- **File**: `app/Livewire/ManageCustomers.php`

### 3. ManageServices Component (`/admin/services`)
- **Purpose**: Service catalog administration via MongoDB
- **Features**: Service CRUD operations, pricing, duration, category management
- **MongoDB Features**: Enhanced fields (Duration, Category), flexible schema
- **File**: `app/Livewire/ManageServices.php`

### 4. ManageDeals Component (`/admin/deals`)
- **Purpose**: Promotional deals management via MongoDB
- **Features**: Deal creation, discount configuration, terms, usage tracking
- **MongoDB Features**: Terms field, MaxUses/CurrentUses tracking, availability checking
- **File**: `app/Livewire/ManageDeals.php`

### 5. Dashboard Component (`/dashboard`)
- **Purpose**: Administrative overview with hybrid data analytics
- **Features**: Booking statistics (SQLite), service/deal analytics (MongoDB)
- **File**: `app/Livewire/Dashboard.php`

## 🗄️ Sample Data

### SQLite Sample Data

The application includes comprehensive sample data via `SampleDataSeeder`:

### Services (11 total)
- Professional haircuts, styling, coloring, and spa treatments
- Pricing range: $25 - $150
- Duration: 30 minutes - 3 hours

### Customers (5 total)
- Diverse customer profiles with realistic contact information
- Includes regular customers and new clients

### Administrators (2 total)
- **Super Admin**: Full system access and management capabilities
### SQLite Sample Data
- **Customers**: 3 sample customers with diverse profiles
- **Admins**: Multiple admin roles and permissions
- **Manager**: Service and customer management permissions

### MongoDB Sample Data

#### Services (5 professional services)
- **Haircut & Style**: Classic cut with styling - £35, 60 min, Hair category
- **Hair Coloring**: Full color transformation - £80, 120 min, Color category  
- **Highlights & Lowlights**: Partial color enhancement - £65, 90 min, Color category
- **Deep Conditioning Treatment**: Intensive hair therapy - £40, 45 min, Treatment category
- **Wedding Hair Package**: Special occasion styling - £120, 150 min, Special category

#### Deals (3 promotional offers)
- **First Visit Special**: 20% discount for new customers (Max 100 uses)
- **Student Discount**: 15% off all services with valid student ID (Max 50 uses)  
- **Holiday Package**: 25% off premium services during holidays (Max 30 uses)

### Bookings (3 total)
- Sample appointments demonstrating relationships between SQLite customers and MongoDB services
- Shows hybrid database integration in action

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ and NPM
- **MongoDB Community Edition 7.0+** (NEW)
- **PHP MongoDB Extension** (NEW)
- Git for version control

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd luxe-hair-studio
   ```

2. **Install PHP dependencies**
   ```bash
   composer install --ignore-platform-req=ext-mongodb
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Install MongoDB**
   - **Windows**: Download MongoDB Community Edition from mongodb.com
   - **Install**: Follow the installation wizard
   - **Service**: MongoDB will run as a Windows service automatically
   - **Verify**: MongoDB should be accessible at `mongodb://127.0.0.1:27017`

5. **Install PHP MongoDB Extension**
   ```bash
   # For Windows with XAMPP
   # Download php_mongodb.dll for your PHP version
   # Place in XAMPP\php\ext\ directory
   # Add 'extension=mongodb' to php.ini
   # Restart Apache/PHP
   ```

6. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

7. **Update .env for MongoDB**
   ```env
   # Add MongoDB configuration
   DB_MONGO_HOST=127.0.0.1
   DB_MONGO_PORT=27017
   DB_MONGO_DATABASE=luxe_hair_studio
   DB_MONGO_USERNAME=
   DB_MONGO_PASSWORD=
   ```

8. **Set up databases**
   ```bash
   # SQLite database and migrations
   php artisan migrate
   php artisan db:seed --class=SampleDataSeeder
   
   # MongoDB collections and sample data
   php artisan db:seed --class=MongoDBSeeder
   ```

9. **Verify MongoDB integration**
   ```bash
   php test_mongodb_integration.php
   ```

10. **Build frontend assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

11. **Start development server**
   ```bash
   php artisan serve
   ```

### MongoDB Setup Verification

After installation, verify MongoDB is working:

```bash
# Test MongoDB connection
php artisan tinker

# In Tinker, test the connection
> use App\Models\Service;
> Service::count(); // Should return service count
> Service::first(); // Should return a service document
```

### Alternative: Development Without MongoDB

If you prefer to test without MongoDB initially:
- The application will work with the existing SQLite setup
- MongoDB features will be available once you install the server
- All code is ready for immediate MongoDB integration

### Accessing the Application
- **Homepage**: http://127.0.0.1:8000
- **Admin Dashboard**: http://127.0.0.1:8000/dashboard
- **Book Service**: http://127.0.0.1:8000/book-service
- **MongoDB Management**: Available through admin interface once MongoDB is running

## 👥 Default User Accounts

After running the seeder, you can log in with these accounts:

### Administrator Accounts
- **Email**: admin@luxehair.com
- **Password**: password123
- **Role**: Super Administrator

- **Email**: manager@luxehair.com
- **Password**: password123
- **Role**: Manager

### Customer Accounts
- **Email**: emily.johnson@email.com
- **Password**: password123

## 🧪 Testing & Verification

### Database Relationship Testing
All ERD relationships have been verified through Laravel Tinker:

```bash
php artisan tinker

# Test relationship counts
echo 'Services: ' . \App\Models\Service::count();
echo 'Customers: ' . \App\Models\Customer::count();
echo 'Deals: ' . \App\Models\Deal::count();

# Test M:M relationships
echo 'Customers for first service: ' . \App\Models\Service::first()->customers()->count();
echo 'Services for first customer: ' . \App\Models\Customer::first()->services()->count();

# Test 1:1 relationships
echo 'Deal service: ' . \App\Models\Deal::with('service')->first()->service->ServiceName;
```

### Component Testing
All 5 Livewire components are accessible and functional:
- ✅ Dashboard component loads with analytics
- ✅ ManageCustomers shows customer list
- ✅ ManageServices displays service catalog
- ✅ ManageDeals shows promotional offers
- ✅ BookService provides booking interface

## 📁 Project Structure

```
app/
├── Livewire/              # 5 Interactive Livewire components
├── Models/                # Eloquent models matching ERD
├── Http/Controllers/      # Route controllers
└── Providers/            # Service providers

database/
├── migrations/           # Database schema definitions
├── seeders/             # Sample data population
└── database.sqlite      # SQLite database file

resources/
├── views/
│   ├── livewire/        # Livewire component views
│   └── layouts/         # Application layouts
├── css/                 # Tailwind CSS styles
└── js/                  # Alpine.js components

routes/
├── web.php              # Web application routes
└── api.php              # API endpoints
```

## 🎓 Academic Requirements Fulfilled

This project demonstrates mastery of the following concepts:

### Database Design
- ✅ Comprehensive ERD implementation
- ✅ Proper normalization and relationship design
- ✅ Foreign key constraints and data integrity
- ✅ Sample data that reflects real-world scenarios

### Laravel Framework
- ✅ MVC architecture implementation
- ✅ Eloquent ORM relationships
- ✅ Migration and seeding strategies
- ✅ Authentication and authorization

### Frontend Development
- ✅ Responsive design with Tailwind CSS
- ✅ Interactive components with Livewire
- ✅ User experience best practices
- ✅ Modern JavaScript integration

### Software Engineering
- ✅ Clean code architecture
- ✅ Version control with Git
- ✅ Documentation and commenting
- ✅ Testing and verification procedures

## 📝 License

This project is open source and available under the MIT License.

## 🤝 Contributing

This is an academic project developed for university coursework. While not actively seeking contributions, the codebase serves as a learning resource for Laravel development and modern web application architecture.

## 📞 Contact

For questions about this academic project, please refer to the course materials or contact the development team through the university portal.

---

**Note**: This application was developed as part of a university assignment to demonstrate proficiency in Laravel framework, database design, and modern web development practices. All sample data is fictional and used for educational purposes only.

## 🍃 MongoDB Setup & Validation (Viva Guide)

### 1. Where MongoDB Config Lives
- **.env**: MongoDB connection variables (DB_MONGO_HOST, DB_MONGO_PORT, DB_MONGO_DATABASE, etc)
- **config/database.php**: 'mongodb' connection array for Laravel MongoDB package

### 2. Which Models Use MongoDB
- **app/Models/Service.php**: Extends MongoDB\Laravel\Eloquent\Model, uses $connection = 'mongodb'
- **app/Models/Deal.php**: Extends MongoDB\Laravel\Eloquent\Model, uses $connection = 'mongodb'

### 3. How to Seed and Test with Tinker
- **Seeding**: Run `php artisan db:seed --class=MongoDBSeeder` to populate demo services and deals
- **Testing**:
  - Run `php artisan tinker`
  - Try:
    ```php
    App\Models\Service::count(); // Should show 5
    App\Models\Deal::count();    // Should show 3
    App\Models\Service::first(); // View first service
    App\Models\Deal::first();    // View first deal
    ```
- **Quick Test Script**: Run `php test_mongodb.php` for a summary of MongoDB data

### 4. Livewire Components Powered by MongoDB
- **ManageServices**: CRUD for services, all data from MongoDB
- **ManageDeals**: CRUD for deals, all data from MongoDB
- **BookService**: Service selection and booking uses MongoDB service data

### 5. Troubleshooting
- If seeder or test fails, check:
  - MongoDB service is running (`net start MongoDB`)
  - PHP MongoDB extension is installed and enabled
  - .env and config/database.php match your local MongoDB settings

---
**This project uses a hybrid database: SQLite for customers/bookings, MongoDB for catalog (services/deals). All admin and booking features for services/deals are now powered by MongoDB.**
