import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

const setupFeaturesSlider = () => {
    if (!document.querySelector('.features-swiper')) return;

    new Swiper('.features-swiper', {
        modules: [Navigation],
        slidesPerView: 1,
        spaceBetween: 20,
        // Berhenti scroll otomatis saat semua slide muat di breakpoint aktif
        // (desktop 3, tablet 2, mobile 1). Ini juga yang memicu Swiper menambah
        // class .swiper-button-lock ke arrow sehingga arrow ikut tersembunyi.
        watchOverflow: true,
        navigation: {
            nextEl: '.features-next',
            prevEl: '.features-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupFeaturesSlider);
} else {
    setupFeaturesSlider();
}
