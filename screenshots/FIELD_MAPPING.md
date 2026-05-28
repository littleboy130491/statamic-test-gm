# Screenshot → Page builder block mapping

Content-only fields (layout/styling in Blade + Tailwind). Header and footer are out of scope.

## Homepage.jpg

| Section | Block type |
|---------|------------|
| Hero (bg image, headline, subcopy, CTA) | `hero` |
| About + logos + stats + CTA + truck image | `intro_about` |
| Product range carousel | `product_showcase` (Products entries) |
| Layanan Kami cards | `service_cards` |
| Marketplace logos | `logo_cloud` |
| Community / blog cards | `entries_highlight` (Posts entries) |
| Dealer map + stats + tabs | `dealer_network` (Dealers entries) |
| Our Group logos | `logo_cloud` |
| Berita Terbaru (featured + list) | `news_featured` (Posts entries) |
| Pre-footer CTA + social | `contact_banner` |

## GM TELETECH.jpg

| Section | Block type |
|---------|------------|
| Hero title + bg | `hero` |
| Intro paragraph + illustration | `section_intro` + `image_text` or `rich_text` + image in `image_text` |
| Fitur & benefit (6 icons) | `feature_grid` |
| Monitoring (phones + phone number) | `contact_banner` (`visual_image`, `phone`, `contact_label`) |
| Bottom CTA + social | `contact_banner` |

## Layanan Purna Jual.jpg

| Section | Block type |
|---------|------------|
| Hero | `hero` |
| Intro paragraph | `section_intro` |
| 7 alternating service rows | `alternating_rows` |
| Bottom CTA | `contact_banner` |

## Management.jpg

| Section | Block type |
|---------|------------|
| Hero | `hero` |
| Intro heading + text | `section_intro` |
| CEO profile (photo, bio, name, role) | `team_primary` |
| Director grid | `team_grid` |
| Bottom CTA | `contact_banner` |

## Also available (generic)

`rich_text`, `image_text`, `cta`, `stats`, `testimonials`, `faq`, `video`, `gallery`, `spacer`, `divider`
