# Bienes Raices

A real estate (bienes raíces) website built with PHP for the server-side structure and vanilla HTML, SCSS, and JavaScript for the front end. The project uses shared PHP templates (header/footer), Gulp for asset compilation and image optimization, and outputs static assets to `build/`.

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Development](#development)
- [Build Output](#build-output)
- [PHP App](#php-app)
- [Features](#features)
- [Pages](#pages)
- [Conventions & Best Practices](#conventions--best-practices)
- [Contributing](#contributing)

---

## Overview

This is a multi-page real estate showcase with a responsive layout, dark mode, and modern image formats (WebP, AVIF). **PHP** drives the pages and shared layout via `includes/` (templates and config). Front-end source (SCSS, JS, images) lives in `src/` and is compiled into `build/`; PHP pages reference `build/css/app.css`, `build/js/bundle.min.js`, and `build/img/`.

---

## Tech Stack

| Layer       | Technology |
|------------|------------|
| Server     | PHP        |
| Markup     | HTML5      |
| Styles     | SCSS (Sass), BEM-style structure |
| Scripts    | Vanilla JavaScript (ES modules) |
| Build      | Gulp 5     |
| Images     | Sharp (JPEG, WebP, AVIF generation) |

**Key dev dependencies:** `gulp`, `gulp-sass`, `gulp-concat`, `gulp-terser`, `gulp-rename`, `sharp`, `glob`, `sass`.

---

## Project Structure

```
bienesRaices/
├── index.php           # Home
├── anuncios.php        # Listings
├── anuncio.php         # Single listing
├── blog.php            # Blog index
├── entrada.php         # Blog post
├── nosotros.php        # About
├── contacto.php        # Contact
├── base.php            # Minimal page example (header + main + footer)
├── gulpfile.js         # Gulp tasks (CSS, JS, images, watch)
├── package.json
├── pnpm-lock.yaml
├── includes/
│   ├── app.php         # Path constants (TEMPLATES_URL, etc.)
│   ├── funciones.php   # Helpers (e.g. incluirTemplate)
│   └── templates/
│       ├── header.php  # Shared header + nav
│       └── footer.php  # Shared footer
├── src/
│   ├── scss/
│   │   ├── app.scss              # Main SCSS entry
│   │   ├── base/                 # Reset, variables, mixins, globals
│   │   ├── layout/               # Header, footer, forms, etc.
│   │   └── internas/             # Page-specific styles
│   ├── js/
│   │   ├── app.js                # Main JS (dark mode, mobile menu)
│   │   └── modernizr.js
│   └── img/                      # Source images (JPG, SVG)
└── build/                        # Compiled assets (do not edit by hand)
    ├── css/
    │   └── app.css
    ├── js/
    │   └── bundle.min.js
    └── img/                      # Optimized + WebP/AVIF variants
```

---

## Prerequisites

- **PHP** (7.4+ or 8.x; for serving the app locally, e.g. XAMPP or `php -S`)
- **Node.js** (v18+ recommended) for the front-end build
- **pnpm** (or npm/yarn)

---

## Installation

1. Clone the repository and go to the project folder:

   ```bash
   cd bienesRaices
   ```

2. Install dependencies:

   ```bash
   pnpm install
   ```

   Or with npm:

   ```bash
   npm install
   ```

---

## Development

**1. Build front-end assets (required once, or while developing):**

```bash
pnpm run dev
```

Or `npm run dev`. This compiles SCSS → `build/css/app.css`, bundles JS → `build/js/bundle.min.js`, processes images to `build/img/`, and watches for changes.

**2. Run the PHP app:**

- **XAMPP:** Place the project under `htdocs` and open `http://localhost/personal/bienesRaices/` (or your virtual host).
- **Built-in PHP server:** From the project root, run `php -S localhost:8000` and open `http://localhost:8000` (use `index.php` or the root as entry).

PHP pages use `build/css/app.css`, `build/js/bundle.min.js`, and `build/img/`, so run Gulp at least once before opening the site.

---

## Build Output

| Source              | Output |
|---------------------|--------|
| `src/scss/**/*.scss` | `build/css/app.css` (+ `.map`) |
| `src/js/**/*.js`     | `build/js/bundle.min.js` |
| `src/img/*.jpg`      | `build/img/<name>.jpg`, `.webp`, `.avif` |
| `src/img/*.svg`      | `build/img/<name>.svg` (copied) |

PHP pages reference:

- `build/css/app.css`
- `build/js/bundle.min.js`
- `build/img/...` for images

---

## PHP App

- **`includes/app.php`** — Defines constants such as `TEMPLATES_URL` (path to `includes/templates/`).
- **`includes/funciones.php`** — Requires `app.php` and provides helpers; the main one is **`incluirTemplate($nombre, $inicio)`**, which includes `includes/templates/{$nombre}.php`. Pass `$inicio = true` before including the header on the home page so the hero gets the `inicio` class.
- **`includes/templates/`** — Shared **header.php** and **footer.php**; all pages use `incluirTemplate('header')` and `incluirTemplate('footer')`.
- **`includes/config/`** — Configuration (e.g. `database.php`). Extend here for DB or env settings.

Typical page flow: `require 'includes/funciones.php'` → set optional vars (e.g. `$inicio`) → `incluirTemplate('header')` → main content → `incluirTemplate('footer')`.

---

## Features

- **PHP templates** — Shared header and footer via `includes/templates/` and `incluirTemplate()`.
- **Responsive layout** with a mobile-friendly navigation (hamburger menu).
- **Dark mode** via system preference and a toggle button (persists during session).
- **Modern images**: `<picture>` with WebP/JPEG (and AVIF where needed) for better performance.
- **Lazy loading** on images where applied (`loading="lazy"`).
- **Modular SCSS**: base (normalize, variables, mixins), layout components, and page-specific partials.

---

## Pages

| File           | Purpose                    |
|----------------|----------------------------|
| `index.php`   | Home: hero, features, listings preview, CTA |
| `anuncios.php`| All property listings      |
| `anuncio.php` | Single property detail     |
| `nosotros.php`| About us                   |
| `blog.php`    | Blog listing               |
| `entrada.php` | Single blog post           |
| `contacto.php`| Contact form               |
| `base.php`    | Base layout template       |

---

## Conventions & Best Practices

1. **Do not edit files inside `build/`** — they are generated. Change source files in `src/` and run `pnpm run dev`.
2. **PHP layout**: Use `incluirTemplate('header')` and `incluirTemplate('footer')` in every page. Keep shared markup in `includes/templates/`; add new helpers in `includes/funciones.php` and config in `includes/config/`.
3. **Images**: Add originals (JPG/PNG) and SVGs in `src/img/`. Gulp will generate optimized and multi-format outputs.
4. **Styles**: Follow the existing SCSS structure (base → layout → internas). Use variables and mixins from `base/`.
5. **Scripts**: Add or edit files in `src/js/`; they are concatenated and minified into `build/js/bundle.min.js`.
6. **Accessibility**: Use semantic HTML, `alt` on images, and ensure interactive elements (e.g. dark mode toggle, mobile menu) are keyboard-friendly.

---

## Contributing

Pull requests are welcome. When opening a PR, please use the [pull request template](.github/PULL_REQUEST_TEMPLATE.md):

1. **Description** — Summarize your changes and link the related issue (bullet points preferred).
2. **Ticket link** — Add the issue/ticket URL if it applies.
3. **Type of change** — Check one: New feature, Hot Fix, Bug fix, or Documentation update.
4. **Checklist** — Confirm your code follows the project style, you’ve self-reviewed, and that docs/tests are updated as needed.
5. **Screenshots** — For UI changes, add desktop and mobile screenshots if relevant.

The **Build Assets** workflow runs on push to `main` when `src/`, `package.json`, `pnpm-lock.yaml`, or `gulpfile.js` change. Ensure `pnpm run build` passes locally before pushing.

---

## License

ISC (see `package.json`).
