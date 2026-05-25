# AGENTS.md

Guidance for AI agents working in this repository.

## Project overview

| Item | Value |
|------|--------|
| CMS | [Statamic](https://statamic.dev) **v6** (`statamic/cms: ^6.0`) |
| Framework | Laravel **13** (`laravel/framework: ^13.8`) |
| PHP | **8.3+** |
| Frontend | **Blade** templates + **Tailwind CSS v4** |
| SEO | **[SEO Pro](https://statamic.com/addons/statamic/seo-pro)** v7 (`statamic/seo-pro: ^7.9`) |
| Assets | Vite (`vite.config.js`) — `resources/css/site.css`, `resources/js/site.js` |

Flat-file content lives under `content/`. Blueprints under `resources/blueprints/`. Custom PHP under `app/`.

## Frontend conventions

### Use Blade for all new templates

- New views: `resources/views/{name}.blade.php` (not `.antlers.html`).
- Set scaffolding preference in `config/statamic/templates.php` → `'language' => 'blade'` when generating templates from the CP.
- Legacy Antlers views (`.antlers.html`) still exist; **do not add new Antlers templates** unless explicitly migrating or fixing existing pages.

### Blade + Statamic data

- Current entry/page: `$page` (e.g. `{{ $page->title }}`, `{!! $page->content !!}` for HTML).
- Globals: `$settings`, etc. (one variable per global set handle).
- Escaping: Blade `{{ }}` escapes; use `{!! !!}` for trusted HTML (entry content, SEO output where appropriate).
- Collection/taxonomy listings: prefer `<s:collection:handle>` tags, `Statamic::tag()`, or `@tags` — see [Blade docs](https://statamic.dev/blade).
- Layouts: Blade templates **ignore** the Antlers layout cascade; use `@extends('layouts.app')` / `@section` / `@yield` (or Blade components).

### Tailwind CSS

- Entry: `resources/css/site.css` — Tailwind v4 via `@import "tailwindcss"` and `@tailwindcss/vite`.
- Typography plugin: `@plugin "@tailwindcss/typography"` — use `prose` / `prose-zinc` / `dark:prose-invert` for rich text.
- Content sources: `@source "../views"` and `@source "../../content"` (class scanning includes views + content).
- Load assets in layout: `@vite(['resources/css/site.css', 'resources/js/site.js'])` (or the project’s existing Vite directive pattern).
- Prefer utility classes; match existing zinc/indigo palette where extending UI.

### Vite / dev

```bash
composer dev          # serve + queue + pail + vite (see composer.json)
npm run dev           # vite only
npm run build         # production assets
php please stache:clear # refresh Statamic content cache after YAML/markdown changes
```

## SEO (SEO Pro)

**Do not hand-roll** meta tags, Open Graph, Twitter cards, canonical URLs, or sitemaps when SEO Pro covers them.

### Layout requirement

In the main layout `<head>`, use:

```blade
@seo_pro('meta')
```

Do not duplicate `<title>`, `meta description`, or `og:*` tags unless there is a documented exception.

### Configuration (cascade)

1. **Site defaults** — CP: `Tools → SEO Pro → Site Defaults`, or `resources/addons/seo-pro.yaml`.
2. **Section defaults** — per collection/taxonomy; saved in that section’s YAML under `inject.seo`.
3. **Entry/term overrides** — `seo` array in entry front matter or CP SEO tab.

Reference fields with `@seo:field_handle` (e.g. `description: "@seo:summary"`). Antlers strings are allowed in YAML config (e.g. `"{{ content | strip_tags | truncate(250, '...') }}"`).

Disable SEO for a section: `seo: false` in `inject` in the collection/taxonomy YAML.

### Section defaults for this project

When adding collections/taxonomies, configure SEO Pro section defaults to map:

| Section | Suggested sources |
|---------|-------------------|
| `posts` | title, excerpt/summary, content, featured_image |
| `products` | title, description, hero_image |
| `pages` | title, content |
| `categories`, `product_categories`, `industries` | title, content (description) |

Docs: [SEO Pro documentation](https://github.com/statamic/seo-pro/blob/7.x/DOCUMENTATION.md).

## Content model

### Collections

| Handle | Route | Taxonomies | Notes |
|--------|-------|------------|-------|
| `pages` | `{parent_uri}/{slug}` | — | Structured tree; root `home` |
| `posts` | `/blog/{year}/{month}/{day}/{slug}` | `categories` | Dated blog |
| `products` | `/products/{slug}` | `product_categories`, `industries` | Catalog |

Blueprints: `resources/blueprints/collections/{collection}/{blueprint}.yaml` (e.g. `products/product.yaml`). Taxonomies: `resources/blueprints/taxonomies/{taxonomy}/{term}.yaml`.

### Taxonomies

| Handle | Route | Notes |
|--------|-------|-------|
| `categories` | `/categories/{slug}` | Post categories; optional `parent` |
| `product_categories` | `/product-categories/{slug}` | Product categories; optional `parent` |
| `industries` | `/industries/{slug}` | Flat industry tags |

Terms: `content/taxonomies/{handle}/{slug}.yaml`. Blueprints: `resources/blueprints/taxonomies/{handle}.yaml`.

Taxonomies are attached on the **collection** YAML (`taxonomies: [...]`), not on blueprints. Entry fields must match taxonomy handles exactly (`categories`, `product_categories`, `industries`).

### Key paths

```
content/collections/{handle}.yaml    # collection config
content/collections/{handle}/*.md    # entries
content/taxonomies/{handle}.yaml     # taxonomy config
content/taxonomies/{handle}/*.yaml   # terms
content/trees/collections/pages.yaml # page hierarchy
resources/blueprints/                # CP field definitions
resources/views/                     # frontend (prefer .blade.php)
```

### Adding a new collection (checklist)

1. `content/collections/{handle}.yaml` — `title`, `route`, `template`, `taxonomies`, `blueprints`.
2. `resources/blueprints/collections/{handle}.yaml`.
3. Blade views: `{handle}/show.blade.php`, index page or listing template.
4. SEO Pro section defaults for the new section.
5. `php please stache:clear`.

## Control panel & caching

- CP: `/cp`
- After editing content YAML or blueprints, run `php please stache:clear`.
- Git-tracked content is typical; avoid committing `.env`, licenses, or secrets.

## Code style

- PHP: Laravel conventions; run `./vendor/bin/pint` if formatting PHP.
- Keep diffs minimal; match existing naming and structure.
- Comments only for non-obvious business rules.
- Do not commit unless the user asks.

## References

- [Statamic 6 docs](https://statamic.dev)
- [Blade in Statamic](https://statamic.dev/blade)
- [Collections](https://statamic.dev/content-modeling/collections)
- [Taxonomies](https://statamic.dev/content-modeling/taxonomies)
- [SEO Pro](https://statamic.com/addons/statamic/seo-pro)
