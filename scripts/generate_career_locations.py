#!/usr/bin/env python3
"""Generate career location taxonomy terms."""

from __future__ import annotations

import re
import unicodedata
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "content" / "taxonomies" / "locations"
AUTHOR = "28d34247-1c17-42bf-8548-5b36f18adcbd"
UPDATED_AT = 1785386400

# Koordinat berikut masih perkiraan titik kota, belum alamat outlet asli.
APPROXIMATE_CITY_COORDS = {
    "oki",
    "bayung-lencir",
    "marunda",
    "melak",
    "sebamban",
    "magalau",
    "morowali",
}

LOCATIONS = [
    ("ACEH", "Dealer", 5.548290, 95.323753),
    ("MEDAN", "Dealer", 3.595196, 98.672226),
    ("PEKANBARU", "Dealer", 0.507068, 101.447777),
    ("PADANG", "Dealer", -0.947083, 100.417181),
    ("JAMBI", "Dealer", -1.610123, 103.613121),
    ("PALEMBANG", "Branch", -2.976074, 104.775429),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("OKI", "Parts & Service", -3.394700, 104.840800),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("BAYUNG LENCIR", "Parts & Svc", -2.021700, 103.707500),
    ("LAHAT", "Parts & Service", -3.786944, 103.542778),
    ("LAMPUNG", "Branch", -5.397140, 105.266739),
    ("CILEGON", "Dealer", -6.002500, 106.011944),
    ("JAKARTA", "Head Office", -6.208763, 106.845599),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("MARUNDA", "Parts & Service", -6.105000, 106.945000),
    ("BEKASI", "Dealer", -6.238270, 106.975571),
    ("KARAWANG", "Parts & Service", -6.304167, 107.305556),
    ("CIREBON", "Parts & Service", -6.732000, 108.552300),
    ("TEGAL", "Parts & Service", -6.869444, 109.140556),
    ("PURWOKERTO", "Parts & Svc", -7.421944, 109.234444),
    ("SEMARANG", "Branch", -6.966667, 110.416664),
    ("TUBAN", "Parts & Service", -6.897600, 112.064800),
    ("SURABAYA", "Branch", -7.257472, 112.752090),
    ("PROBOLINGGO", "Parts & Svc", -7.756111, 113.211944),
    ("MATARAM", "Parts & Service", -8.583333, 116.116667),
    ("PONTIANAK", "Branch", -0.026330, 109.342503),
    ("PANGKALAN BUN", "Parts & Svc", -2.681944, 111.623611),
    ("MUARA TEWEH", "Parts & Svc", -0.951944, 114.891389),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("MELAK", "Parts & Service", -0.203300, 115.766700),
    ("BANJARMASIN", "Branch", -3.319437, 114.590836),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("SEBAMBAN", "Parts & Service", -3.466700, 115.733300),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("MAGALAU", "Parts & Service", -2.783300, 115.916700),
    ("BERAU", "Parts & Service", 2.155556, 117.494444),
    ("SAMARINDA", "Branch", -0.502183, 117.153709),
    ("BALIKPAPAN", "Branch", -1.265386, 116.831200),
    ("MANADO", "Branch", 1.474830, 124.842079),
    ("GORONTALO", "Parts & Service", 0.543500, 123.059000),
    # APPROXIMATE: perkiraan titik kota, belum alamat outlet asli
    ("MOROWALI", "Parts & Service", -2.533300, 121.966700),
    ("KOLAKA", "Parts & Service", -4.056389, 121.593611),
    ("KENDARI", "Branch", -3.972220, 122.514900),
    ("MAKASSAR", "Branch", -5.147665, 119.432732),
    ("SORONG", "Branch", -0.876000, 131.255000),
    ("TIMIKA", "Parts & Service", -4.545000, 136.888000),
    ("JAYAPURA", "Branch", -2.533333, 140.716667),
]

TYPE_MAP = {
    "Dealer": "dealer",
    "Branch": "branch",
    "Parts & Service": "parts_service",
    "Parts & Svc": "parts_service",
    "Head Office": "head_office",
}

TYPE_LABEL = {
    "Dealer": "Dealer",
    "Branch": "Branch",
    "Parts & Service": "Parts & Service",
    "Parts & Svc": "Parts & Service",
    "Head Office": "Head Office",
}

# Legend peta GM Mobil (taxonomy dealer_categories).
OFFICE_TYPE_TO_DEALER_CATEGORY = {
    "dealer": "cabang-dealer",
    "branch": "cabang-dealer",
    "head_office": "cabang-dealer",
    "parts_service": "service-center",
}

# Akronim / nama khusus yang tidak boleh di-title-case biasa.
CITY_DISPLAY = {
    "OKI": "OKI",
}


def title_case(city: str) -> str:
    if city in CITY_DISPLAY:
        return CITY_DISPLAY[city]
    return " ".join(part.capitalize() for part in city.split())


def slugify(city: str, office_type: str) -> str:
    if city == "JAKARTA" and office_type == "Head Office":
        return "jakarta"
    text = unicodedata.normalize("NFKD", city).encode("ascii", "ignore").decode("ascii")
    text = re.sub(r"[^a-zA-Z0-9]+", "-", text.lower()).strip("-")
    suffix = TYPE_MAP[office_type].replace("_", "-")
    return f"{text}-{suffix}"


def dealer_category_slug(office_type_key: str) -> str:
    return OFFICE_TYPE_TO_DEALER_CATEGORY[office_type_key]


def yaml_content(city: str, office_type: str, lat: float, lng: float) -> str:
    office_type_key = TYPE_MAP[office_type]
    title = f"{title_case(city)} ({TYPE_LABEL[office_type]})"
    category = dealer_category_slug(office_type_key)

    return (
        f"title: '{title}'\n"
        f"office_type: {office_type_key}\n"
        f"dealer_category:\n"
        f"  - {category}\n"
        f"location:\n"
        f"  latitude: {lat}\n"
        f"  longitude: {lng}\n"
        f"updated_by: {AUTHOR}\n"
        f"updated_at: {UPDATED_AT}\n"
        f"blueprint: location\n"
    )


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    for path in OUT.glob("*.yaml"):
        path.unlink()

    counts: dict[str, int] = {}
    for city, office_type, lat, lng in LOCATIONS:
        office_type_key = TYPE_MAP[office_type]
        slug = slugify(city, office_type)
        category = dealer_category_slug(office_type_key)
        counts[category] = counts.get(category, 0) + 1
        (OUT / f"{slug}.yaml").write_text(
            yaml_content(city, office_type, lat, lng),
            encoding="utf-8",
        )

    print(f"Created {len(LOCATIONS)} location terms in {OUT}")
    for category, total in sorted(counts.items()):
        print(f"  {category}: {total}")


if __name__ == "__main__":
    main()
