# Bienes Raices

Proyecto web de bienes raices con PHP + MySQL, maquetacion responsive y pipeline de assets con Gulp.

## Resumen

Este repositorio combina:

- Sitio publico multi pagina (`index`, `anuncios`, `anuncio`, `blog`, `entrada`, `nosotros`, `contacto`)
- Area administrativa con autenticacion y CRUD de propiedades
- Compilacion de SCSS/JS e imagenes optimizadas en `build/`
- Entorno Docker para desarrollo local
- CI en GitHub Actions para validar build de frontend
- Dependabot para actualizar dependencias

## Stack Tecnico

- PHP (con `mysqli`)
- MySQL 8.4
- Composer (`intervention/image`)
- Node.js 22 + pnpm 10
- Gulp 5 + Sass + Terser + Sharp
- Docker + Docker Compose

## Estructura Principal

```text
.
|-- admin/
|   |-- index.php
|   `-- propiedades/
|       |-- crear.php
|       `-- actualizar.php
|-- classes/
|   `-- Propiedad.php
|-- includes/
|   |-- app.php
|   |-- funciones.php
|   |-- config/database.php
|   `-- templates/
|       |-- header.php
|       |-- footer.php
|       `-- anuncios.php
|-- src/
|   |-- scss/
|   |-- js/
|   `-- img/
|-- build/                # generado por Gulp
|-- imagenes/             # imagenes subidas por admin
|-- docker-compose.yml
|-- dockerfile
|-- gulpfile.js
|-- package.json
|-- composer.json
`-- .github/
    |-- workflows/build-assets.yml
    `-- dependabot.yml
```

## Requisitos

- Docker Desktop (recomendado), o
- PHP 8.x + MySQL + Node.js 22 + pnpm + Composer

## Configuracion Rapida con Docker

1. Crear variables de entorno desde el ejemplo:

```bash
cp .env.example .env
```

1. Levantar servicios:

```bash
docker compose up -d --build
```

1. Abrir aplicacion:

- Web: `http://localhost:8080` (o el puerto definido en `APP_PORT`)
- MySQL host local: `127.0.0.1:3307` (o `MYSQL_HOST_PORT`)

Servicios definidos:

- `web`: PHP 8.4 + Apache
- `db`: MySQL 8.4
- `node`: watcher de assets con `pnpm run dev`

## Configuracion Manual (sin Docker)

1. Instalar dependencias de frontend:

```bash
pnpm install
```

1. Instalar dependencias PHP:

```bash
composer install
```

1. Construir o vigilar assets:

```bash
pnpm run dev
```

1. Servir proyecto con XAMPP/Apache o con servidor embebido de PHP.

## Scripts Disponibles

En `package.json`:

- `pnpm run dev`: compila y queda en modo watch
- `pnpm run build`: build de una sola ejecucion (`gulp build`)

Salida de assets:

- `src/scss/**/*.scss` -> `build/css/app.css`
- `src/js/**/*.js` -> `build/js/bundle.min.js`
- `src/img/**/*` -> `build/img/` (incluye `.webp` y `.avif`)

## Flujo de Aplicacion

- `includes/app.php` inicializa funciones, conexion y autoload
- `classes/Propiedad.php` encapsula logica del modelo de propiedad
- `admin/index.php` lista propiedades y permite eliminar
- `admin/propiedades/crear.php` crea propiedad y procesa imagen con Intervention Image
- `admin/propiedades/actualizar.php` actualiza propiedad e imagen
- `login.php` autentica usuarios
- `cerrar-sesion.php` destruye sesion

## Base de Datos

La conexion actual esta en `includes/config/database.php` y usa valores fijos:

- host: `localhost`
- user: `root`
- pass: `root`
- db: `bienesraices_crud`

Si usas Docker con `db` como contenedor, ajusta este archivo para usar host `db` o lee variables de entorno.

## Usuario Admin

Existe `usuario.php` para insertar un usuario de prueba con password hasheado.

Recomendacion:

- Ejecutarlo solo una vez para bootstrap local
- No usar ese flujo tal cual en produccion

## Automatizacion en GitHub

### CI

Workflow: `.github/workflows/build-assets.yml`

- Se ejecuta en pull requests a `main` y `dev`
- Instala pnpm + Node 22
- Ejecuta `pnpm install --frozen-lockfile`
- Ejecuta build (`pnpm exec gulp build`)
- Verifica que `build/` exista y no este vacio

### Dependabot

Archivo: `.github/dependabot.yml`

Ecosistemas configurados:

- `npm`
- `composer`
- `docker-compose`
- `github-actions`

## Notas Importantes

- `build/`, `imagenes/`, `node_modules/`, `.env` y `vendor/` estan ignorados por git
- No edites manualmente archivos dentro de `build/`
- Si cambias SCSS/JS/imagenes fuente, vuelve a correr el pipeline de Gulp
