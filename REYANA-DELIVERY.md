# Reyana development delivery

Branch: `feat/reyana-storefront`. Local review: **http://127.0.0.1:8000** (Laravel development server).

This is an implemented **private preview**, not a launch-ready transactional shop. No public deployment was performed.

## Implemented

- Separate, scoped storefront layout, neutral/olive theme, wordmark, editorial hero, category tiles, new arrivals, featured picks, brand story, original journal article and consent-based newsletter form.
- Shop, seven collection routes, search, size/colour/price/stock filters, sort, count, selected-filter removal, clear-all, crawlable pagination and useful empty states. Mobile filters use a native modal dialog; mobile navigation uses an expanded-state button and keyboard-accessible links.
- Product template, mandatory size/colour selection, unavailable options, quantities, size guide, details/care/policy sections, related products, wishlist and persistent session bag. Prices and variant availability are checked on the server; client-submitted prices are ignored.
- Guest **demonstration** checkout with county, town/area, address, optional landmark, Kenyan phone normalization, server recalculation and idempotent session confirmation. It explicitly collects **KSh 0**, writes no orders/payments/bookings, and reserves no inventory.
- About, contact, size guide, delivery, returns, FAQs, account entry, privacy, terms, journal and article pages. Missing business facts are identified rather than invented. Existing sign-in, registration and password reset forms now use the Reyana public theme; their controllers and credentials are preserved.
- Additive `fashion_products`, `fashion_variants`, and `fashion_subscribers` tables. `/admin/fashion` uses the existing dashboard shell and permission middleware; it supports product creation/editing, image uploads, publishing and per-size/colour stock. Disable a variant by setting its stock to zero; existing variant records are preserved.
- Preview catalog is a PHP demonstration dataset, **never seeded into business tables**. Switch `REYANA_PREVIEW=false` to use active real catalog records instead. Uploaded images are served through a constrained `/fashion-images/{filename}` route; no symlink replacement is required.
- Page-specific metadata, canonicals, social metadata, Organization/BreadcrumbList schema, genuine catalog Product/Offer schema, sitemap, robots, noindex rules and branded 404. Demonstration products deliberately emit no Product/Offer schema.
- Local responsive WebP derivatives, explicit image dimensions, lazy loading, priority hero image, system fonts, small vanilla JS, focus states, skip link and reduced-motion handling.

## Dashboard and legacy preservation

`resources/views/layouts/dashboard.blade.php`, the dashboard views/controllers, service/booking/provider/report controllers, role checks, and the existing M-Pesa controller are unchanged. Storefront CSS loads only through the new public layout. New catalog forms inherit dashboard styles and do not add or move sidebar/header items. Reach catalog management through Account → Manage fashion catalog while signed in as an admin/dispatcher, or directly at `/admin/fashion`.

Existing service content records remain intact. Generic legacy article/page URLs return 404 to public visitors; administrators/dispatchers can still preview them using the original PageController and manage them through the existing dashboard. No unrelated service URL is redirected to the fashion homepage. Existing bookings and management routes remain protected and available.

Only the new migration was applied to the existing local database. It creates three new tables; it contains no updates/deletes to existing business tables. No original seeder was run. The pre-existing untracked `scripts/update_live_articles_61_90.php` was not changed.

## Verification

- `php artisan test`: **11 passed, 220 assertions**. Tests use in-memory SQLite, not business data.
- Coverage: public templates, noindex, robots/sitemap, 404, filters/sort/pagination, mandatory variants, stock bounds, server prices, bag updates/removals, phone normalization, checkout retries, no demo business records, newsletter consent/deduplication, wishlist, real catalog separation/schema, dashboard access and service/provider/booking routes.
- `npm run build`: passed (Vite). `php artisan view:cache`: passed. `node --check public/reyana/store.js`: passed. The storefront itself uses standalone CSS/JS and does not require Vite at runtime.
- HTTP smoke checks against the running server: home, shop, product, bag, checkout, login, robots, sitemap and asset URLs returned 200. Sample local HTML response times were approximately 184–1,113 ms; these are **server request timings, not Core Web Vitals**.
- Dashboard preservation checked by unchanged source diff and authenticated route/render tests. **No rendered screenshot comparison was possible.**
- Reference inspection: fetched current homepage HTML, read current homepage/dress collection through web access, inspected responsive rules and navigation, and visually inspected local reference photographs. **Rendered desktop/mobile reference inspection and storefront visual/browser interaction QA are outstanding.** The browser host was unavailable; native Computer Use then stopped because it could not establish the current Chrome URL confidently. No further computer interaction was attempted.
- LCP/INP/CLS were **not measured**; no field data is available. Do not claim the requested CWV thresholds are achieved. Test 320/375/390/768/1440 px, keyboard focus, menu and modal behaviour, and run Lighthouse before launch.

## Image provenance

All temporary photographs came from **https://www.ikojn.com/**. Source URLs for catalog photographs are recorded in `resources/demo/catalog.php`; the full downloaded asset manifest is `resources/demo/image-sources.json`. `scripts/prepare_reyana_images.php` creates local 400/750 px WebP derivatives without hotlinking. Downloaded photographs were visually inspected and original garment proportions are retained with containment.

These are styling references, not evidence that Reyana stocks an item. Sample labels, prices and variant stocks are invented test data. The matching-sets entry is explicitly an outfit concept, not a claim that the photographed garments form a stocked matching set. Reference photographs are automatically replaced with neutral placeholders in homepage editorial sections outside preview mode. Remove all reference files from the production artifact even after switching off preview.

## Launch checklist and unresolved work

- [ ] Enter real products, licensed/owned photographs, descriptive alt text, garment-specific measurements, material/care information, accurate prices, colours and stock; retire demo data and reference assets.
- [ ] Confirm business identity, contact email/phone, social accounts, delivery counties/areas, charges, delivery estimates, return/exchange/refund terms, and legal/privacy wording. No location or delivery promise has been invented.
- [ ] **Implement the real commerce order lifecycle and payment adapter.** This delivery contains a demo checkout only. Durable fashion orders, transactional stock reservations/locking, verified payment states, customer order history and shopping emails are not implemented. The existing booking M-Pesa flow remains unchanged and is not used for fashion purchases.
- [ ] Configure and verify Daraja consumer key/secret, shortcode, passkey, environment, transaction type, public HTTPS callback and status-query credentials. Use server-side status verification, receipt/amount/order matching, idempotent callbacks, duplicate-order constraints, pending/failed/cancelled states, retry/reconciliation and reservation expiry. Never enable the existing booking callback as a fashion payment verifier without this work.
- [ ] Add actual delivery calculation and show the final delivered total before enabling payment. `config/reyana.php` deliberately fixes `checkout_enabled` to false; setting environment flags alone cannot enable real purchases.
- [ ] Complete newsletter delivery integration, unsubscribe handling and retention rules. Current production mode stores consent and deduplicates signups; preview mode stores no subscribers.
- [ ] Configure shopping mail sender identity and branded password-reset/shopping templates; existing SMTP/from settings and authentication mail defaults have not been replaced or invented.
- [ ] Perform rendered desktop/mobile QA and real keyboard/touch tests, including dashboard before/after screenshots. Add multiple product photographs where owned assets are available. Add supported variant schema when verified real variants and permanent variant URLs exist.
- [ ] Run payment sandbox end-to-end tests once implemented; test concurrent stock purchases, duplicate callbacks, cancelled requests and abandoned sessions. No live payment test was performed.
- [ ] Set `APP_URL` to the confirmed production hostname, `APP_ENV=production`, `APP_DEBUG=false`, secure session/cookie settings, and HTTPS. Configure staging authentication separately if externally accessible. Run config/view cache commands after environment changes.
- [ ] Keep `REYANA_PREVIEW=true` and `REYANA_INDEXABLE=false` for development/staging. Indexing requires **production environment + preview off + indexable true**. Review canonical URLs, sitemap, schema and robots before enabling indexing; do not index placeholder policy pages or empty collections.
- [ ] If the domain changes: map genuine replacement URLs with 301s; update APP_URL, canonicals, image/social URLs and sitemap; verify both properties in Search Console and perform migration work as appropriate. Do not redirect unrelated service content en masse.
- [ ] Measure Lighthouse lab performance/accessibility and validate structured data; collect field CWV after launch. Requested targets: LCP ≤2.5 s, INP ≤200 ms, CLS ≤0.1.

## Local commands

```powershell
C:\xampp\php\php.exe artisan serve --host=127.0.0.1 --port=8000
C:\xampp\php\php.exe artisan test
npm run build
```

No secrets are needed for the demo. Do not run the original database seeder against existing records.
