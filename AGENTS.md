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
- Layouts: Blade templates **ignore** the Antlers layout cascade. Use layout components: `<x-layouts.app>` for Statamic collection pages (SEO Pro, `site.css`); `<x-layouts.main>` with header/footer for branded static pages.

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
| `products` | title, description, featured_image |
| `dealers` | title, address |
| `pages` | title, content |
| `categories`, `product_categories`, `industries` | title, content (description), featured_image |

Docs: [SEO Pro documentation](https://github.com/statamic/seo-pro/blob/7.x/DOCUMENTATION.md).

### Yoast → SEO Pro (WordPress migration)

Source files (project root, Excel `.xls`):

| File | Used for |
|------|----------|
| `SEO-Posts-Export.xls` | Collection `posts` |
| `SEO-Pages-Export.xls` | Collection `products`, page `produk`, taxonomy `product_categories` |

Required columns: `id`, `_yoast_wpseo_title`, `_yoast_wpseo_metadesc` (pages export also has `Title`). Ignore `_yoast_wpseo_focuskw` and `_yoast_wpseo_primary_category` — SEO Pro has no equivalent fields.

**Field mapping**

| Yoast | Statamic (`seo` on entry/term) |
|-------|--------------------------------|
| Empty title, `%%title%%`, or `%%title%% … %%sep%% %%sitename%%` / site name | `title: '@seo:title'` |
| `%%title%% %%page%% %%sep%% {suffix}` (e.g. Dump Truck FAW) | `title: '{Statamic title} - {suffix}'` |
| `_yoast_wpseo_metadesc` present | `description: '{metadesc}'` |
| Empty metadesc | posts: `'@seo:excerpt'`; products/pages: `'@seo:description'` |
| — | `image: '@seo:featured_image'` (terms: `'@seo:images'`) |

Do not invent meta when Yoast is empty; inherit via `@seo:…` and collection `inject.seo`.

**Matching**

1. Convert `.xls` to CSV only as a throwaway (Excel COM `SaveAs` CSV). Do not commit the CSV.
2. **Posts:** match WordPress post `id` (and slug/title from the posts content export if the SEO sheet has no title) to Statamic entries. Applied to all posts that exist in the catalog.
3. **Products:** match WordPress **page** `id` to the product that was imported from that page (`wp_slug` / model in the WP title). `SEO-Pages-Export.xls` is a full WP **pages** dump, not products-only — skip Sample Page, Privacy, shop/cart, Elementor stubs, Career, and discontinued units that are not in `content/collections/products/`.
4. Also apply the matching rows to `content/collections/pages/produk.md` (WP Products) and terms `dump-truck`, `mixer-truck-truk-molen`, `tractor-head`, `chasis-cargo`.
5. After writing YAML, `php please stache:clear`.

**Section `inject.seo` already set**

- `content/collections/posts.yaml` — title, excerpt, featured_image
- `content/collections/products.yaml` — title, description, featured_image
- `content/taxonomies/product_categories.yaml` — title, images

**Known gaps / source quirks**

- No WP SEO row for `faw-dd140mt-4x4-euro-4.md` and `2026-08-12-0000.faw-fd460th-6x4.md`.
- WP page `11637` (FD380TH CNG) metadesc still says FD290TH; imported as in Yoast.
- WP page `14515` is titled FD380TH but metadesc is FD375TH; mapped to `faw-fd375th-6x4-euro-5.md`.
- Other WP pages in `SEO-Pages-Export.xls` (home, after-sales, dealer, reman, teletech, news, contact, old Euro 2 units) are **not** applied unless a later pass maps them to `pages` / leftover products.

**Cleanup:** delete converter CSV and one-off Python under `storage/` after a run. Keep the `.xls` sources and all `content/` entries.

## Content model

### Collections

| Handle | Route | Taxonomies | Notes |
|--------|-------|------------|-------|
| `pages` | `{parent_uri}/{slug}` | — | Structured tree; root `home` |
| `posts` | `/berita-dan-artikel/{slug}` | `categories`, `social_media` | Dated blog; listing page `berita-dan-artikel` |
| `products` | `/products/{slug}` | `product_categories`, `industries` | Catalog |
| `dealers` | `/dealers/{slug}` | `dealer_categories` | Dealer locator |

Blueprints: `resources/blueprints/collections/{collection}/{blueprint}.yaml` (e.g. `products/product.yaml`). Taxonomies: `resources/blueprints/taxonomies/{taxonomy}/{term}.yaml`.

### Taxonomies

| Handle | Route | Notes |
|--------|-------|-------|
| `categories` | `/categories/{slug}` | Post categories; optional `parent` |
| `product_categories` | `/product-categories/{slug}` | Product categories; optional `parent` |
| `industries` | `/industries/{slug}` | Flat industry tags |
| `dealer_categories` | `/dealer-categories/{slug}` | Dealer types |

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
