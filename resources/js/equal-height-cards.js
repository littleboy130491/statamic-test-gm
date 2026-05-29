// Menyamakan tinggi card dalam satu container secara otomatis.
// Digunakan pada halaman yang menampilkan grid card (contoh: fitur & benefit - GM Teletech).
// Cara: Tambah atribut data-equal-height di elemen container card.

function equalizeHeights(container) {
    const cards = Array.from(container.children);
    cards.forEach((c) => (c.style.height = ''));
    const maxHeight = Math.max(...cards.map((c) => c.offsetHeight));
    cards.forEach((c) => (c.style.height = maxHeight + 'px'));
}

function initEqualHeightCards() {
    const containers = document.querySelectorAll('[data-equal-height]');
    if (window.innerWidth <= 640) {
        containers.forEach((container) => {
            Array.from(container.children).forEach((c) => (c.style.height = ''));
        });
        return;
    }
    containers.forEach(equalizeHeights);
}

document.addEventListener('DOMContentLoaded', initEqualHeightCards);
window.addEventListener('resize', initEqualHeightCards);
