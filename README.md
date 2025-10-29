
https://drive.google.com/file/d/1XwzNGsabAItg2b49hlczUsqbpiqrGKtI/view?usp=drivesdk
<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

---

# 🛒 E-Commerce Order Management System

## 📖 About the Project

The **E-Commerce Order Management System** is a **Laravel 12-based** application designed for managing online orders through **role-based access control**.  
It provides a simple e-commerce frontend and a powerful backend system that allows different user roles to manage orders efficiently.

This system includes three user roles:  
- **Super Admin** – Full system access  
- **Admin** – Manage orders and transfer between outlets  
- **Outlet In-Charge** – Handle outlet-specific orders  

---

## 🎯 Objective

To develop a **role-based order management system** with APIs that allow users to place and manage orders efficiently, ensuring a clear distinction of permissions across user roles.

---

## ⚙️ Key Features

### 🖥️ Frontend
- Simple and clean e-commerce design  
- Product list with “Add to Cart” functionality (API-based)  
- Checkout and order placement via REST API  

### 🛠️ Backend
- Role-based authentication (Laravel Sanctum)  
- Order management (view, accept, cancel, transfer)  
- Outlet-based access for Outlet In-Charges  
- REST API endpoints for all operations  

---

## 👥 User Roles and Permissions

| Role | Access | Description |
|------|---------|-------------|
| **Super Admin** | Full | Manage users, products, and all orders |
| **Admin** | Medium | Accept, cancel, or transfer orders between outlets |
| **Outlet In-Charge** | Limited | View own outlet orders, accept or transfer if needed |

---

## 🧩 Tech Stack

- **Framework:** Laravel 12  
- **Language:** PHP 8+  
- **Database:** MySQL  
- **Frontend:** Blade / API Integration  
- **Authentication:** Laravel Sanctum  
- **Version Control:** Git & GitHub  

---

## 🚀 Installation & Setup

### Step 1: Clone the repository
```bash
git clone https://github.com/your-username/ecommerce-order-management.git
cd ecommerce-order-management
Step 2: Install dependencies
composer install
npm install && npm run dev

Step 3: Setup environment file
cp .env.example .env


Update your .env file with database credentials:

DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

Step 4: Generate application key
php artisan key:generate

Step 5: Run migrations and seeders
php artisan migrate --seed

Step 6: Start the development server
php artisan serve