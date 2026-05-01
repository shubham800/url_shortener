# 🚀 URL Shortener (Laravel 12)

A multi-tenant role-based URL Shortening System built with Laravel 12, MySQL, and Laravel Breeze authentication. Supports company-based access control, invitations, and full test coverage.

---

## ⚙️ Tech Stack

- Laravel 12
- MySQL
- Laravel Breeze (Authentication)
- PHPUnit (Testing)
- Blade / Tailwind CSS

---

## 📌 Features

### 👤 Authentication & Roles
- Role-based system:
  - SuperAdmin
  - Admin
  - Member
- Laravel Breeze authentication (login/logout)
- SuperAdmin account created via database seeder (raw SQL)

---

### 🏢 Multi-Company Invitation System
- SuperAdmin can invite Admin to a new company
- Admin can invite:
  - Another Admin
  - Member (within same company)
- Company-based user isolation

---

### 🔗 URL Shortener System
- Admin & Member can create short URLs
- SuperAdmin cannot create short URLs
- Public URL redirection support

Access Rules:
- SuperAdmin → Can view ALL short URLs across companies
- Admin → Can view only their company’s URLs
- Member → Can view only their own URLs

---

## 🔁 URL Redirection

All short URLs are publicly accessible and redirect to original URL:

/s/abc123 → https://example.com

---

## 🧪 Testing

This project includes full feature test coverage using PHPUnit.

Covered Test Cases:
- Admin can create short URLs
- Member can create short URLs
- SuperAdmin cannot create short URLs
- Admin sees only company URLs
- Member sees only their own URLs
- Short URLs are publicly resolvable

Run Tests:
php artisan test

---

## 🛠️ Setup Instructions

1. Clone Repository
git clone <repo-url>
cd url-shortener

2. Install Dependencies
composer install
npm install && npm run build

3. Environment Setup

Linux / Mac:
cp .env.example .env

Windows (CMD):
copy .env.example .env

php artisan key:generate

4. Configure Database
DB_CONNECTION=mysql
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=your_password

5. Run Migrations & Seeder
php artisan migrate --seed

6. Start Server
php artisan serve

---

## 🔐 Default SuperAdmin Login

Email: superadmin@example.com  
Password: password

---

## 🧠 System Design Summary

- Multi-tenant (Company-based architecture)
- Role-Based Access Control (RBAC)
- Secure URL redirection
- Fully tested backend system
- Scalable Laravel structure

---

## 📊 Project Purpose

This project demonstrates:
- Backend architecture design
- Multi-company SaaS logic
- Role-based authorization system
- Laravel feature testing with factories
- Production-style URL shortener design

---

## 👨‍💻 Author

Built with Laravel for learning real-world backend architecture, testing, and scalable SaaS design patterns.