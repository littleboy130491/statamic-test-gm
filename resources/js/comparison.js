// Product comparison (AJAX)
const setupComparison = () => {
    const grid = document.querySelector('#comparison-grid');
    if (!grid) return;

    const endpoint = grid.dataset.endpoint;
    const selects = grid.querySelectorAll('.comparison-select');

    // Cache respons per id produk (tidak fetch ulang)
    const cache = new Map();

    const fetchProduct = async (id) => {
        if (cache.has(id)) return cache.get(id);

        const request = fetch(`${endpoint}/${id}/comparison`, {
            headers: { Accept: 'application/json' },
        }).then((res) => {
            if (!res.ok) throw new Error(`Request failed: ${res.status}`);
            return res.json();
        });

        cache.set(id, request);
        return request;
    };

    const placeholder = grid.dataset.emptyPlaceholder || '';

    // Nilai mentah per kolom (baris kosong)
    const columnValues = new Map();

    const isEmpty = (value) => value === undefined || value === null || String(value).trim() === '';

    // Hide kolom kosong
    const refreshRows = () => {
        grid.querySelectorAll('.comparison-row').forEach((row) => {
            const rowIndex = Number(row.dataset.row);
            let allEmpty = true;

            columnValues.forEach((rows) => {
                if (!isEmpty(rows[rowIndex])) allEmpty = false;
            });

            row.classList.toggle('hidden', allEmpty);

            row.querySelectorAll('[data-comparison-cell]').forEach((cell) => {
                const col = cell.dataset.comparisonCell;
                const value = columnValues.get(col)?.[rowIndex];
                cell.textContent = isEmpty(value) ? placeholder : value;
            });
        });
    };

    const renderColumn = (col, data) => {
        const image = grid.querySelector(`[data-comparison-image="${col}"]`);
        if (image) {
            setColumnImage(image, data.image, data.title);
        }

        columnValues.set(col, (data.rows || []).map((row) => row.value));
        refreshRows();
    };

    const setColumnImage = (image, url, alt) => {
        const wrap = image.closest('.comparison-image-wrap');

        image.classList.remove('opacity-100');
        image.classList.add('opacity-0');

        if (!url) {
            image.removeAttribute('src');
            wrap?.classList.remove('is-loading');
            return;
        }

        wrap?.classList.add('is-loading');

        const preload = new Image();
        preload.onload = () => {
            image.src = url;
            image.alt = alt || '';
            wrap?.classList.remove('is-loading');
            
            requestAnimationFrame(() => {
                image.classList.remove('opacity-0');
                image.classList.add('opacity-100');
            });
        };
        preload.onerror = () => {
            image.removeAttribute('src');
            wrap?.classList.remove('is-loading');
        };
        preload.src = url;
    };

    const loadColumn = async (select) => {
        const col = select.dataset.column;
        const id = select.value;
        if (!id) return;

        try {
            const data = await fetchProduct(id);
            renderColumn(col, data);
        } catch (error) {
            console.error('Comparison load failed:', error);
        }
    };

    selects.forEach((select) => {
        select.addEventListener('change', () => loadColumn(select));
        loadColumn(select);
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupComparison);
} else {
    setupComparison();
}
