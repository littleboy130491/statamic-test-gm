// Javascript untuk click overlay popup form single career (jika overlay di klik akan menutup popup)

document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('career-popup');
    if (!popup) return;

    const observer = new MutationObserver(function () {
        document.body.style.overflow = popup.open ? 'hidden' : '';
    });
    observer.observe(popup, { attributes: true, attributeFilter: ['open'] });

    popup.addEventListener('click', function (e) {
        const box = popup.querySelector('.career-popup-inner');
        if (box && !box.contains(e.target)) {
            popup.close();
        }
    });

    if (popup.dataset.autoOpen === 'true') {
        popup.showModal();
    }
});