# Pamantasan ng Lungsod ng Pasig (PLP) Alumni Portal

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Overview

The **PLP Alumni Portal** is a responsive web application for **Pamantasan ng Lungsod ng Pasig** alumni and students to register, login, browse job opportunities, and access future services like events and profiles.

**Current Features (Frontend)**:
- Alumni/Student registration with advanced form validation
- Login system with modal signup selector
- Job board with posting, filtering, search, and detail views
- Consistent branded navbar across pages
- Modern UI/UX with animations and real-time feedback

Backend-ready with `database/almuniDB.sql` schema.

## Live Features

| Page | Key Features |
|------|--------------|
| **Login** (`pages/login.html`) | Email/password login, forgot password, signup dialog → alumni/student forms, GSAP animations |
| **Registration** (`pages/alumni_form.html`, `pages/student_form.html`) | School ID validation, full PII fields, DOB/sex, email/phone patterns, course/year dropdowns, password strength meter w/ toggle & match check |
| **Jobs** (`pages/jobs.html`) | Job listing/search/filter, post-job modal (full form), detail overlay, badges/responsiveness |
| **Home** (`pages/index.html`) | Landing (TBD) |

## Tech Stack

| Category | Technologies |
|----------|--------------|
| **Frontend** | HTML5, CSS3 (Flex/Grid/Animations), Vanilla JS |
| **UI Libs** | Google Fonts (Roboto), Remixicon/Font Awesome, GSAP (animations) |
| **Forms** | Custom validation (regex, real-time lists), password toggle |
| **Database** | MySQL (`database/almuniDB.sql`) |
| **Responsive** | Mobile-first, viewport meta |

**Zero dependencies**: Pure static site. Open any `pages/*.html` in browser.

## Quick Start 🚀

1. **Clone**:
   ```
   git clone https://github.com/yourusername/Alumni-Portal.git
   cd Alumni-Portal
   ```

2. **Run locally**:
   ```
   # Windows
   start pages/index.html
   
   # Or drag pages/index.html to browser
   ```

3. **Edit & Develop**:
   - VS Code + Live Server extension
   - Changes hot-reload in browser
   - Test forms/job board in open tabs

## Project Structure

```
Alumni-Portal/
├── pages/              # HTML pages
│   ├── index.html
│   ├── login.html
│   ├── alumni_form.html
│   ├── student_form.html
│   ├── jobs.html
│   └── ... (events, profile)
├── assets/             # Static assets
│   ├── css/            # Page-specific + shared styles
│   │   ├── login.css
│   │   ├── jobs.css
│   │   └── registration_style.css
│   ├── js/             # Scripts
│   │   ├── login.js
│   │   ├── jobscript.js
│   │   └── registration_script.js
│   └── image/          # Logos, icons
├── database/           # Backend schema
│   └── almuniDB.sql
├── README.md
├── LICENSE
└── .gitattributes
```

## Roadmap

- ✅ **Done**: Folder reorganization, registration/login forms, job board
- 🔄 **Next**: Events page, profile page, navbar JS consistency
- ⏳ **Future**: Backend (Node/Express + MySQL), auth (JWT), API endpoints
- 📱 PWA support
- 🚀 Deploy: Vercel/Netlify + Railway (DB)

## Contributing

1. Fork → Clone → Branch: `git checkout -b feat/new-page`
2. Commit: `git commit -m "feat: add events page"`
3. PR with screenshots!

**Code Style**:
- Semantic HTML
- BEM-ish CSS
- Vanilla JS, no frameworks
- 2-space indent

## License

[MIT](LICENSE) - Free to use/modify.
