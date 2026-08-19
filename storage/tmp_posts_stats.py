import re
from collections import Counter
from pathlib import Path

posts_dir = Path(r"C:\Users\Cendy Saputra\Herd\statamic-test-gm\content\collections\posts")
files = list(posts_dir.glob("*.md"))

cats = Counter()
no_cat = 0
unpublished = 0
published_explicit = 0
has_featured = 0
has_excerpt = 0
has_description = 0
empty_description = 0
has_gallery = 0
has_social = 0
elementor = 0
no_id = 0
has_content_field = 0
years = Counter()

for p in files:
    text = p.read_text(encoding="utf-8", errors="replace")
    fm = text.split("---", 2)
    front = fm[1] if len(fm) > 2 else text
    body = fm[2].strip() if len(fm) > 2 else ""

    if "published: false" in front:
        unpublished += 1
    elif re.search(r"^published:\s*true", front, re.M):
        published_explicit += 1

    if not re.search(r"^id:", front, re.M):
        no_id += 1
    if re.search(r"^featured_image:", front, re.M):
        has_featured += 1
    if re.search(r"^excerpt:", front, re.M):
        has_excerpt += 1
    if re.search(r"^gallery:", front, re.M):
        has_gallery += 1
    if re.search(r"^social_media:", front, re.M):
        has_social += 1
    if re.search(r"^content:", front, re.M):
        has_content_field += 1

    title_m = re.search(r"^title:\s*(.+)$", front, re.M)
    title = title_m.group(1) if title_m else ""
    if "Elementor" in title or "elementor-" in p.name:
        elementor += 1

    if re.search(r"^description:\s*\[\]\s*$", front, re.M):
        empty_description += 1
    elif re.search(r"^description:", front, re.M):
        has_description += 1

    cat_block = re.search(r"^categories:\n((?:  - .+\n)+)", front, re.M)
    if cat_block:
        for line in cat_block.group(1).strip().splitlines():
            cats[line.replace("-", "", 1).strip()] += 1
    elif re.search(r"^categories:", front, re.M):
        cats["(present but empty/other)"] += 1
    else:
        no_cat += 1

    ym = re.match(r"(\d{4})-", p.name)
    if ym:
        years[ym.group(1)] += 1

print("TOTAL FILES", len(files))
print("unpublished/draft (published: false)", unpublished)
print("published: true explicit", published_explicit)
print("neither (Statamic dated default published unless false)", len(files) - unpublished - published_explicit)
print("no id", no_id)
print("featured_image", has_featured)
print("excerpt", has_excerpt)
print("description (non-empty key)", has_description)
print("description: []", empty_description)
print("markdown body after front matter", sum(1 for p in files if (p.read_text(encoding="utf-8", errors="replace").split("---", 2)[2:] and p.read_text(encoding="utf-8", errors="replace").split("---", 2)[2].strip())))
print("gallery", has_gallery)
print("social_media", has_social)
print("content field", has_content_field)
print("elementor titles/files", elementor)
print("no categories", no_cat)
print("categories", dict(cats))
print("years", dict(sorted(years.items())))
print("\nElementor files:")
for p in files:
    if "elementor" in p.name.lower():
        print(" ", p.name)
