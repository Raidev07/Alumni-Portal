# Pamantasan ng Lungsod ng Pasig (PLP) Alumni Portal

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Overview

The **PLP Alumni Portal** is a web-based platform designed for alumni of **Pamantasan ng Lungsod ng Pasig** to connect, manage profiles, register for alumni services, and stay updated with events and networking opportunities.

Currently, this is the **initial landing page** featuring:
- Branded navbar with PLP and Alumni logos
- Hero slider highlighting welcome message and registration features

Future expansions will include full authentication, alumni directory, event management, and more.

## Features (Live on Landing Page)

- ✅ **Sticky Navigation Bar**: Home, Services, Portfolio, About links (placeholders for full pages)
- ✅ **Interactive Hero Slider**: 
  - Welcome to alumni community
  - Alumni profile registration with services:
    | Service                  |
    | Alumni Card Application  |
    | Yearbook Claiming        |
    | 2-in-1 Package           |
- ✅ **Branding**: Official PLP colors (#006E14 green theme) and logos



## Tech Stack

| Frontend | Libraries/Tools |
|----------|-----------------|
| HTML5    | Swiper.js (Slider), Font Awesome (Icons), Google Fonts (Roboto) |
| CSS3     | Custom styles, Flexbox, CSS Grid, Animations, Backdrop blur |
| JavaScript | Vanilla JS (Sticky nav, Swiper init) |

- **No build tools**: Pure static site, no dependencies to install
- **External CDNs**: Swiper, Font Awesome, Google Fonts

## Quick Start

1. **Clone the repo**:
   ```
   git clone https://github.com/yourusername/Alumni-Portal.git
   cd Alumni-Portal
   ```

2. **Open in browser**:
   ```
   # Windows
   start index.html
   
   # Or simply double-click index.html
   ```

3. **Development**:
   - Edit `index.html`, `style.css`, `script.js`
   - Refresh browser to see changes
   - Live Server VSCode extension recommended for auto-reload

## Project Structure

```
Alumni-Portal/
├── index.html          # Main landing page
├── style.css           # All styles and responsiveness
├── script.js           # Navbar sticky + Swiper functionality
├── image/              # Assets
│   ├── alumni-logo.png
│   ├── plplogo.png
│   ├── homepage_img.png
│   └── icons.docx      # (Note: Convert to PNG/SVG if needed)
├── README.md           # This file

├── LICENSE
└── .gitattributes
```

## Roadmap / Next Steps

- [ ] Implement full pages: Home (extend landing), Services, About, Contact
- [ ] Add authentication (Login/Signup forms → Firebase/Auth0?)
- [ ] Alumni Dashboard: Profile edit, directory search
- [ ] Backend: Node.js/Express or Supabase for data (events, profiles)
- [ ] Features: Event calendar, job board, donations
- [ ] PWA: Offline support, installable app
- [ ] Deploy: Netlify/Vercel/GitHub Pages

See Roadmap section above for current priorities.

## Contributing

1. Fork the repo
2. Create feature branch: `git checkout -b feature/amazing-feature`
3. Commit changes: `git commit -m 'Add amazing feature'`
4. Push: `git push origin feature/amazing-feature`
5. Open Pull Request

**Guidelines**:
- Follow existing code style (2-space indent, semantic HTML)
- Keep it lightweight (prefer vanilla JS/CSS)
- Add screenshots/GIFs for UI changes
- Update README for new features

Questions? Open an issue!

## License

This project is [MIT licensed](LICENSE). Free to use, modify, distribute.

