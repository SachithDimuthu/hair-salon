# Luxe Hair Studio - Salon Management System<p align="center"><img src="/public/images/logo/luxe-hair-studio-square.svg" width="120" alt="Luxe Hair Studio Logo"></p>



<p align="center"><img src="/public/images/logo/luxe-hair-studio-square.svg" width="120" alt="Luxe Hair Studio Logo"></p><h1 align="center">Luxe Hair Studio</h1>

<h1 align="center">Salon Management System</h1>

A professional salon management system built with Laravel 12, featuring appointment booking, staff management, service catalogs, and comprehensive dashboards.

## Project Overview

## Features

Luxe Hair Studio is a professional salon management system built with Laravel 11, PHP 8.2+, Blade, Tailwind CSS, and Livewire 3. It supports multi-role authentication, appointment booking, staff management, service catalog, product inventory, analytics dashboard, REST API, and more.

- **Multi-role Authentication** - Admin, Staff, and Customer access levels

- **Appointment Management** - 4-step booking flow with real-time availability### Branding

- **Staff Management** - Profiles, specializations, and working hours

- **Service Catalog** - Categories, services, pricing, and duration management- **Name:** Luxe Hair Studio

- **Dashboard Analytics** - KPIs, revenue tracking, and performance metrics- **Colors:** Purple (#6A1B9A), Pink (#E91E63), White

- **Customer Management** - Profiles, appointment history, and preferences- **Fonts:** Playfair Display (headings), Inter (body)

- **Product Inventory** - Stock management and order tracking- **Logo:** Elegant “LHS” monogram or hair-scissors icon

- **API Integration** - RESTful API with Sanctum authentication

- **Responsive Design** - Mobile-friendly interface with Tailwind CSS## Environment Requirements



## Technology Stack- **PHP:** 8.2 or higher ✅ (Currently: 8.4.0)

- **Laravel:** 11.x ✅ (Currently: 12.30.1)

- **Backend:** Laravel 12, PHP 8.4- **Node.js & NPM:** 18+ ✅ (Currently: 22.14.0 / 10.9.2)

- **Frontend:** Livewire 3, Tailwind CSS, Alpine.js- **Composer:** 2.x ✅ (Latest)

- **Database:** MySQL 8.x- **MySQL:** 8.x (users, customers, staff, appointments, orders)

- **Authentication:** Laravel Jetstream with Sanctum- **MongoDB:** 6.x+ (services, products, categories) - *Optional due to ext-mongodb requirement*

- **Testing:** PHPUnit, Feature & Unit Tests

- **Assets:** Vite build system## Installed Dependencies



## Installation### Laravel Packages (Composer)

- ✅ **Laravel Jetstream** v5.3.8 - Authentication scaffolding

1. **Clone the repository**- ✅ **Livewire** v3.6.4 - Frontend interactivity

   ```bash- ✅ **Laravel Sanctum** v4.2.0 - API authentication

   git clone <repository-url>- ⏸️ **MongoDB for Laravel** - Skipped (requires ext-mongodb PHP extension)

   cd luxe-hair-studio

   ```### Frontend Packages (NPM)

- ✅ **Tailwind CSS** v3.4+ - Utility-first CSS framework

2. **Install dependencies**- ✅ **@tailwindcss/forms** - Form styling plugin

   ```bash- ✅ **@tailwindcss/typography** - Typography plugin

   composer install- ✅ **Autoprefixer & PostCSS** - CSS processing

   npm install

   ```### Branding Configuration

- ✅ **Colors:** Purple (#6A1B9A), Pink (#E91E63), White (#FFFFFF)

3. **Environment setup**- ✅ **Fonts:** Playfair Display (headings), Inter (body)

   ```bash- ✅ **Logo placeholder:** `/public/images/logo.png`

   cp .env.example .env

   php artisan key:generate## Installation Steps

   ```

1. **Clone the repository**

4. **Database setup**   ```bash

   ```bash   git clone <repository-url>

   # Configure database credentials in .env   cd luxe-hair-studio

   php artisan migrate --seed   ```

   php artisan storage:link

   ```2. **Install PHP dependencies**

   ```bash

5. **Build assets**   composer install

   ```bash   ```

   npm run build

   ```3. **Install JavaScript dependencies**

   ```bash

6. **Start development server**   npm install

   ```bash   ```

   php artisan serve

   ```4. **Configure environment**

   ```bash

## Default Accounts   cp .env.example .env

   php artisan key:generate

After seeding the database:   ```



- **Admin:** admin@luxe.com / password5. **Set up database**

- **Staff:** staff@luxe.com / password     ```bash

- **Customer:** customer@luxe.com / password   # Configure MySQL in .env file

   php artisan migrate

## API Documentation   ```



The system includes a RESTful API for appointments and services:6. **Build frontend assets**

   ```bash

- **Base URL:** `/api/v1/`   npm run build

- **Authentication:** Bearer token (Sanctum)   # or for development

- **Endpoints:** `/appointments`, `/services`, `/staff`   npm run dev

   ```

## Testing

7. **Start development server**

Run the test suite:   ```bash

   php artisan serve

```bash   ```

php artisan test

```## Phase 1 Completed ✅



## Database Structure✅ Project setup and dependencies installed  

✅ Jetstream authentication scaffolding configured  

Key entities and relationships:✅ Livewire 3 for frontend interactivity  

- Users → Staff/Customers (1:1)✅ Tailwind CSS with Luxe Hair Studio branding  

- Customers → Appointments (1:many)✅ Database migrations run successfully  

- Staff → Appointments (1:many)✅ Frontend assets compiled  

- Services ↔ Appointments (many:many with pivot)

- Staff ↔ Services (many:many)**Note on MongoDB:** The MongoDB package requires the `ext-mongodb` PHP extension which is not currently installed. For now, the project will use MySQL for all data storage. MongoDB integration can be added later when the extension is available.



## License## Next Phases



This project is built with the Laravel framework, which is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).2. Database Design & Models
3. Routes & Controllers  
4. Livewire Components & UI
5. Dashboards & Analytics
6. API Endpoints & Sanctum
7. Security Documentation
8. Testing
9. Deployment

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
