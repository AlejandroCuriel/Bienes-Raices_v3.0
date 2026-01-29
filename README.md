# Bienes Raices

A static real estate (bienes raíces) website built with vanilla HTML, SCSS, and JavaScript. The project uses Gulp for asset compilation, image optimization, and live reload during development.

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Development](#development)
- [Build Output](#build-output)
- [Features](#features)
- [Pages](#pages)
- [Conventions & Best Practices](#conventions--best-practices)
- [Contributing](#contributing)

---

## Overview

This is a multi-page real estate showcase site with a responsive layout, dark mode support, and modern image formats (WebP, AVIF). Source assets live in `src/` and are compiled into the `build/` directory. HTML pages reference the built CSS and JS from `build/`.

---

## Tech Stack

| Layer      | Technology |
|-----------|------------|
| Markup    | HTML5      |
| Styles    | SCSS (Sass), BEM-style structure |
| Scripts   | Vanilla JavaScript (ES modules) |
| Build     | Gulp 5     |
| Images    | Sharp (JPEG, WebP, AVIF generation) |

**Key dev dependencies:** `gulp`, `gulp-sass`, `gulp-concat`, `gulp-terser`, `gulp-rename`, `sharp`, `glob`, `sass`.

---

## Project Structure

```
bienesRaices/
├── index.html          # Home
├── anuncios.html       # Listings
├── anuncio.html        # Single listing
├── blog.html           # Blog index
├── entrada.html        # Blog post
├── nosotros.html       # About
├── contacto.html       # Contact
├── base.html           # Base layout reference
├── gulpfile.js         # Gulp tasks (CSS, JS, images, watch)
├── package.json
├── pnpm-lock.yaml
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

- **Node.js** (v18+ recommended)
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

Run the Gulp dev task to compile assets and watch for changes:

```bash
pnpm run dev
```

Or:

```bash
npm run dev
```

This will:

- Compile SCSS → `build/css/app.css` (with source maps)
- Concatenate and minify JS → `build/js/bundle.min.js`
- Process images from `src/img/` → `build/img/` (JPEG + WebP + AVIF; SVGs copied as-is)
- Watch `src/scss`, `src/js`, and `src/img` for changes and re-run the relevant tasks

Serve the project with any static server (e.g. XAMPP, Live Server, or `npx serve .`) and open the root or `index.html`.

---

## Build Output

| Source              | Output |
|---------------------|--------|
| `src/scss/**/*.scss` | `build/css/app.css` (+ `.map`) |
| `src/js/**/*.js`     | `build/js/bundle.min.js` |
| `src/img/*.jpg`      | `build/img/<name>.jpg`, `.webp`, `.avif` |
| `src/img/*.svg`      | `build/img/<name>.svg` (copied) |

HTML files reference:

- `build/css/app.css`
- `build/js/bundle.min.js`
- `build/img/...` for images

---

## Features

- **Responsive layout** with a mobile-friendly navigation (hamburger menu)
- **Dark mode** via system preference and a toggle button (persists during session)
- **Modern images**: `<picture>` with WebP/JPEG (and AVIF where needed) for better performance
- **Lazy loading** on images where applied (`loading="lazy"`)
- **Modular SCSS**: base (normalize, variables, mixins), layout components, and page-specific partials

---

## Pages

| File           | Purpose                    |
|----------------|----------------------------|
| `index.html`   | Home: hero, features, listings preview, CTA |
| `anuncios.html`| All property listings      |
| `anuncio.html` | Single property detail     |
| `nosotros.html`| About us                   |
| `blog.html`    | Blog listing               |
| `entrada.html` | Single blog post           |
| `contacto.html`| Contact form               |
| `base.html`    | Base layout template       |

---

## Conventions & Best Practices

1. **Do not edit files inside `build/`** — they are generated. Change source files in `src/` and run `pnpm run dev`.
2. **Images**: Add originals (JPG/PNG) and SVGs in `src/img/`. Gulp will generate optimized and multi-format outputs.
3. **Styles**: Follow the existing SCSS structure (base → layout → internas). Use variables and mixins from `base/`.
4. **Scripts**: Add or edit files in `src/js/`; they are concatenated and minified into `build/js/bundle.min.js`.
5. **HTML**: Keep shared structure (header, footer, nav) in sync across pages; consider a simple include/template step if the project grows.
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
