# Pamantasan ng Lungsod ng Pasig (PLP) Alumni Portal

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-8.x+-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-blue)](https://www.mysql.com/)

## Overview

The **PLP Alumni Portal** is a comprehensive PHP-based web application for **Pamantasyan ng Lungsod ng Pasig** alumni and students. It provides a complete platform for alumni registration, login, job browsing, events management, profile management, and an admin dashboard for managing alumni data.

**Current Features**:
- User registration (alumni/student forms) with validation
- Login system with session management
- Job board with listing, search, and filter capabilities
- Events management and listing
- User profile management
- Responsive admin dashboard with charts and data visualization
- Alumni CRUD operations (Create, Read, Update, Delete)
- Data export functionality

## Live Features

| Page | Key Features |
|------|--------------|
| **Login** (`login.php`) | Email/password login with registration modal |
| **Registration** (`alumni_form.php`) | Form validation, school ID, PII fields, password strength meter |
| **Jobs** (`jobs.php`) | Job listings, search, filter, post-job modal |
| **Events** (`events.php`) | Event listings and management |
| **Profile** (`profile-page.php`) | User profile view and edit |
| **Home** (`index.php`) | Landing page with alumni homepage |
| **Alumni Homepage** (`alumni_homepage.php`) | Alumni community homepage |
| **Admin Dashboard** (`admin/dashboard.php`) | Charts, statistics, alumni management |
| **Add Alumnus** (`admin/add_alumnus.php`) | Add new alumni records |
| **All Alumni** (`admin/all_alumni.php`) | View and manage all alumni |
| **Edit Alumnus** (`admin/edit_alumnus.php`) | Edit existing alumni records |
| **Export Data** (`admin/export_data.php`) | Export alumni data |

> **Note**: Additional admin features include profile editing (`admin/edit_profile.php`) and viewing individual alumni (`admin/view_alumnus.php`).

## Tech Stack

| Category | Technologies |
|----------|--------------|
| **Backend** | PHP 8.x, MySQL 8.0+ |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Charts** | ApexCharts.js |
| **Alerts** | SweetAlert2 |
| **Assets** | Custom CSS/JS in `assets/` and `admin/` directories |
| **Database** | MySQL (database/alumniDB.sql) |
| **Responsive** | Bootstrap 5.3 (Admin Dashboard) |

## Quick Start

1. **Setup Local Server** (XAMPP/WAMP recommended):
   ```bash
   # Or use PHP built-in server
   cd c:/xampp/htdocs/MAIN-PROJECT/Alumni-Portal
   php -S localhost:8000
   ```
   Open http://localhost:8000

2. **Database Setup**:
   - Import `database/alumniDB.sql` to MySQL (via phpMyAdmin)
   - Update `backend/db.php` with your database credentials
   - Update `backend/db_admin.php` with admin database credentials

3. **Default Admin Access**:
   - Contact your administrator for login credentials
   - Session-based authentication with role validation

4. **Test**:
   - Open browser tabs: login.php, alumni_form.php, jobs.php
   - Test admin dashboard at admin/dashboard.php
   - Check browser console for JavaScript validation errors

## Project Structure

```
Alumni-Portal/
├── index.php                    # Landing/Home page
├── login.php                    # Login page
├── alumni_form.php             # Alumni registration form
├── alumni_homepage.php         # Alumni community homepage
├── jobs.php                     # Job board
├── events.php                   # Events page
├── profile-page.php            # User profile page
├── contact.php                  # Contact page
├── articles_page.php           # Articles page
├── write_article.php           # Write article page
├── view_article.php            # View article page
├── DPA.php                      # Data Privacy Act page
├── admin/                       # Admin dashboard
│   ├── dashboard.php           # Admin dashboard with charts
│   ├── admin.php               # Admin login
│   ├── add_alumnus.php         # Add new alumni
│   ├── all_alumni.php         # View all alumni
│   ├── edit_alumnus.php        # Edit alumni
│   ├── edit_profile.php        # Edit admin profile
│   ├── profile.php            # Admin profile
│   ├── view_alumnus.php       # View alumni details
│   ├── export_data.php         # Export data
│   ├── css/                   # Admin stylesheets
│   ├── js/                    # Admin JavaScript
│   └── includes/              # Admin includes (navbar, sidebar, footer)
├── backend/                    # PHP backend scripts
│   ├── db.php                # Main database connection
│   ├── db_admin.php          # Admin database connection
│   ├── login_process.php     # Login processing
│   └── register_process.php # Registration processing
├── assets/                     # Frontend assets
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript
│   └── image/                # Images
├── database/
│   └── alumniDB.sql          # Database schema
├── PHPMailer/                 # Email library
├── TODO.md                    # Progress tracking
├── README.md
└── LICENSE
```

## Admin Dashboard Features

The admin dashboard includes:

1. **Statistics Cards**:
   - Total Alumni Members
   - Total Active Users
   - Total Events

2. **Data Visualization**:
   - Alumni per program/course chart (ApexCharts)
   - Interactive and animated charts

3. **Alumni Management**:
   - Add new alumni with all details
   - View all alumni in a table
   - Edit existing alumni records
   - Delete alumni records

4. **Data Export**:
   - Export alumni data to CSV/Excel

5. **Profile Management**:
   - Edit admin profile
   - Session-based security

## Database Schema

The database includes tables for:
- `users` - User accounts
- `alumnidetails` - Alumni personal information
- `courses` - Academic programs/courses
- `events` - Event listings
- `jobs` - Job postings
- And more in `database/alumniDB.sql`

## Roadmap

**Completed**:
- ✅ User registration and login
- ✅ Job board with search and filter
- ✅ Events management
- ✅ Profile management
- ✅ Admin dashboard with charts
- ✅ Alumni CRUD operations
- ✅ Data export functionality
- ✅ Email functionality (PHPMailer integration)

**In Progress**:
- 🔄 Enhanced session security
- 🔄 Advanced search and filtering

**Next**:
- 📝 Complete CRUD for all entities
- 📝 Enhanced security measures
- 📝 Email notifications
- 📝 Alumni verification system

## Contributing

1. Fork the repository
2. Clone your fork: `git clone <your-repo-url>`
3. Create a new branch: `git checkout -b feat/add-feature`
4. Make your changes and commit: `git commit -m "Add feature"`
5. Push to the branch: `git push origin feat/add-feature`
6. Submit a Pull Request

**Code Style**:
- PHP: PSR-12 coding standards
- JavaScript/CSS: Consistent indentation
- See TODO.md for current tasks and priorities

## temporary domain

- http://alumni-portal.xo.je

## License

[MIT](LICENSE)

---

*Built with ❤️ for Pamantasyan ng Lungsod ng Pasig Alumni Community*
