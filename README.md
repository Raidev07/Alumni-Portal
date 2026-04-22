# Pamantasan ng Lungsod ng Pasig (PLP) Alumni Portal

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Overview

The **PLP Alumni Portal** is a PHP-based web application for **Pamantasan ng Lungsod ng Pasig** alumni and students. It supports registration, login, job browsing, events, and profiles, with MySQL backend.

**Current Features**:
- User registration (alumni/student forms) with validation (assets/js/registration_script.js)
- Login system (login.php + backend/login_process.php)
- Job board (jobs.php + assets/js/jobscript.js)
- Events (events.php + assets/js/eventscript.js)
- Profile page (profile-page.php + assets/js/profile.js)
- Responsive design with custom CSS/JS

## Live Features

| Page | Key Features |
|------|--------------|
| **Login** (`login.php`) | Email/password login, registration modal |
| **Registration** (`alumni_form.php`, `student_form.php`) | Form validation, school ID, PII fields, password strength |
| **Jobs** (`jobs.php`) | Listing, search, filter, post-job modal |
| **Events** (`events.php`) | Event listings |
| **Profile** (`profile-page.php`) | User profile view/edit |
| **Home** (`index.php`) | Landing page |

## Tech Stack

| Category | Technologies |
|----------|--------------|
| **Backend** | PHP, MySQL (database/almuniDB.sql) |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Assets** | Custom CSS/JS in `assets/`, images |
| **Responsive** | Mobile-first design (NOT ALL) |

## Quick Start 🚀

1. **Setup Local Server** (XAMPP/WAMP recommended):
   ```
   # Or use PHP built-in server
   cd d:/htdocs/Alumni-Portal
   php -S localhost:8000
   ```
   Open http://localhost:8000

2. **Database**:
   - Import `database/almuniDB.sql` to MySQL (phpMyAdmin)
   - Update `backend/db.php` with DB credentials

3. **Test**:
   - Open tabs: login.php, forms, jobs.php
   - Check console for JS validation

## Project Structure

```
Alumni-Portal/
├── index.php              # Home
├── login.php
├── alumni_form.php
├── student_form.php
├── jobs.php
├── events.php
├── profile-page.php
├── backend/               # PHP scripts
│   ├── db.php
│   ├── login_process.php
│   └── register_process.php
├── assets/                # CSS/JS/Images
│   ├── css/
│   ├── js/
│   └── image/
├── database/
│   └── almuniDB.sql
├── TODO.md                # Progress tracking
├── README.md
└── LICENSE
```

## Roadmap

See detailed [TODO.md](./TODO.md) for today's progress and missing features.

**Recent Updates**:
- Backend login/register processing
- Form JS enhancements

**Next**:
- Full CRUD operations
- Session/auth security
- Admin dashboard

## Contributing

1. Fork & clone
2. Branch: `git checkout -b feat/add-feature`
3. Commit & PR

**Code Style**:
- PHP: PSR-12
- JS/CSS: Consistent indentation
- See TODO.md for tasks

## temporary domain
- http://alumni-portal.xo.je
## License

[MIT](LICENSE)

