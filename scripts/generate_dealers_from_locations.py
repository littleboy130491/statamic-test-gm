#!/usr/bin/env python3
"""Generate dealer entries from career location taxonomy terms."""

from __future__ import annotations

import re
import uuid
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
LOCATIONS_DIR = ROOT / "content" / "taxonomies" / "locations"
DEALERS_DIR = ROOT / "content" / "collections" / "dealers"
AUTHOR = "28d34247-1c17-42bf-8548-5b36f18adcbd"
UPDATED_AT = 1785386400

# Sinkron dengan scripts/generate_career_locations.py (legend peta GM Mobil).
OFFICE_TYPE_TO_DEALER_CATEGORY = {
    "dealer": "cabang-dealer",
    "branch": "cabang-dealer",
    "head_office": "cabang-dealer",
    "parts_service": "service-center",
}


def parse_existing_id(path: Path) -> str | None:
    if not path.exists():
        return None
    match = re.search(r"^id: (.+)$", path.read_text(encoding="utf-8"), re.M)
    return match.group(1).strip() if match else None


def parse_location(path: Path) -> dict:
    text = path.read_text(encoding="utf-8")
    title_match = re.search(r"^title: '(.+)'$", text, re.M)
    type_match = re.search(r"^office_type: (\S+)$", text, re.M)
    category_match = re.search(r"^dealer_category:\s*\n\s+- (\S+)$", text, re.M)
    lat_match = re.search(r"^\s+latitude: (.+)$", text, re.M)
    lng_match = re.search(r"^\s+longitude: (.+)$", text, re.M)

    if not all([title_match, type_match, lat_match, lng_match]):
        raise ValueError(f"Invalid location file: {path.name}")

    office_type = type_match.group(1)
    category = (
        category_match.group(1)
        if category_match
        else OFFICE_TYPE_TO_DEALER_CATEGORY[office_type]
    )

    title = title_match.group(1)
    city = title.split(" (", 1)[0]

    return {
        "slug": path.stem,
        "title": title,
        "city": city,
        "dealer_category": category,
        "latitude": lat_match.group(1).strip(),
        "longitude": lng_match.group(1).strip(),
    }


def dealer_yaml(data: dict, entry_id: str) -> str:
    return (
        f"---\n"
        f"id: {entry_id}\n"
        f"blueprint: dealer\n"
        f"title: '{data['title']}'\n"
        f"city: '{data['city']}'\n"
        f"is_active: true\n"
        f"dealer_categories:\n"
        f"  - {data['dealer_category']}\n"
        f"location:\n"
        f"  latitude: {data['latitude']}\n"
        f"  longitude: {data['longitude']}\n"
        f"updated_by: {AUTHOR}\n"
        f"updated_at: {UPDATED_AT}\n"
        f"---\n"
    )


def main() -> None:
    DEALERS_DIR.mkdir(parents=True, exist_ok=True)

    location_files = sorted(LOCATIONS_DIR.glob("*.yaml"))
    if not location_files:
        raise SystemExit(f"No location terms found in {LOCATIONS_DIR}")

    counts: dict[str, int] = {}
    created = 0
    for path in location_files:
        data = parse_location(path)
        out_path = DEALERS_DIR / f"{data['slug']}.md"
        entry_id = parse_existing_id(out_path) or str(uuid.uuid4())
        out_path.write_text(dealer_yaml(data, entry_id), encoding="utf-8")
        counts[data["dealer_category"]] = counts.get(data["dealer_category"], 0) + 1
        created += 1

    print(f"Updated {created} dealer entries in {DEALERS_DIR}")
    for category, total in sorted(counts.items()):
        print(f"  {category}: {total}")


if __name__ == "__main__":
    main()
