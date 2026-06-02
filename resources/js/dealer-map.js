document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('dealer-map');
    if (!mapEl) return;

    const locations = window.dealerLocations || [];
    const map = L.map('dealer-map', { zoomControl: false }).setView([-6.2088, 106.8456], 6);

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    const layerStreet = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        subdomains: 'abcd',
        maxZoom: 20
    });

    const layerSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; Esri'
    });

    layerStreet.addTo(map);

    // Custom toggle Peta / Satelit
    const LayerToggle = L.Control.extend({
        options: { position: 'topleft' },
        onAdd: function () {
            const container = L.DomUtil.create('div', 'leaflet-layer-toggle');
            container.innerHTML = `
                <button class="layer-btn active" data-layer="street">Peta</button>
                <button class="layer-btn" data-layer="satellite">Satelit</button>
            `;
            L.DomEvent.disableClickPropagation(container);
            container.querySelectorAll('.layer-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    container.querySelectorAll('.layer-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    if (this.dataset.layer === 'street') {
                        map.removeLayer(layerSatellite);
                        map.addLayer(layerStreet);
                    } else {
                        map.removeLayer(layerStreet);
                        map.addLayer(layerSatellite);
                    }
                });
            });
            return container;
        }
    });
    new LayerToggle().addTo(map);

    const iconWa = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="dealer-contact-icon"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.136.562 4.14 1.541 5.874L.057 23.886a.5.5 0 0 0 .606.61l6.188-1.458A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.886 0-3.65-.523-5.153-1.43l-.36-.214-3.733.879.941-3.618-.235-.374A9.953 9.953 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>`;

    const iconPhone = `<img src="/assets/telepon-icon.svg" class="dealer-contact-icon" alt="" aria-hidden="true">`;

    const categoryLabel = {
        'cabang-dealer': 'Cabang & Dealer',
        'service-center': 'Service Center',
        'part-shop': 'Part Shop',
    };

    const markers = [];

    locations.forEach(function (loc) {
        const label = categoryLabel[loc['dealer-category']] || loc['dealer-category'];
        const waNumber = loc.whatsapp.replace(/\D/g, '').replace(/^0/, '62');

        const popupContent = `
            <div class="dealer-popup">
                <div class="popup-header">
                    <div class="dealer-popup-city">${loc.city}</div>
                    <div class="dealer-popup-category">${label}</div>
                </div>
                <div class="wrap-popup-dealer">
                    <div class="dealer-popup-company">${loc.company}</div>
                    <div class="dealer-popup-address">${loc.address}</div>
                    <div class="dealer-popup-contacts">
                        <a href="https://wa.me/${waNumber}" target="_blank" rel="noopener">
                            ${iconWa} ${loc.whatsapp}
                        </a>
                        <a href="tel:${loc.phone}">
                            ${iconPhone} ${loc.phone}
                        </a>
                    </div>
                    <a href="${loc.maps_url}" target="_blank" rel="noopener" class="dealer-popup-gmaps">
                        Temukan Lokasi di Peta
                    </a>
                </div>
            </div>
        `;

        const marker = L.marker([loc.lat, loc.lng])
            .addTo(map)
            .bindPopup(popupContent, { maxWidth: 280 });

        markers.push({ marker, loc });
    });

    // Filter kategori (desktop)
    document.querySelectorAll('.dealer-cat-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.dealer-cat-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            applyFilters();
        });
    });

    // Filter kategori (mobile)
    const categorySelect = document.getElementById('dealer-category-select');
    if (categorySelect) {
        categorySelect.addEventListener('change', applyFilters);
    }

    // Search kota
    const searchInput = document.getElementById('dealer-search');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    function applyFilters() {
        const isMobile = window.matchMedia('(max-width: 1023px)').matches;
        const activeCategory = isMobile
            ? (categorySelect?.value || 'all')
            : (document.querySelector('.dealer-cat-btn.active')?.dataset.category || 'all');
        const searchQuery = (searchInput?.value || '').toLowerCase().trim();

        markers.forEach(function ({ marker, loc }) {
            const matchCategory = activeCategory === 'all' || loc['dealer-category'] === activeCategory;
            const matchSearch = !searchQuery || loc.city.toLowerCase().includes(searchQuery);

            if (matchCategory && matchSearch) {
                marker.addTo(map);
            } else {
                marker.remove();
            }
        });
    }
});
