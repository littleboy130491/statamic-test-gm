// Tutup panel dropdown customizable select saat halaman di-scroll,
// meniru perilaku native <select> yang otomatis menutup ketika di-scroll.
// Generik untuk SEMUA <select> customizable (comparison, form kontak, dsb).
//
// Catatan: untuk customizable select, hidePopover() saja sering tidak menutup
// picker. Menghilangkan fokus (blur) dari select adalah cara paling andal —
// picker akan otomatis tertutup, sama seperti perilaku native.
function closeOpenSelect() {
  document.querySelectorAll('select').forEach((select) => {
    const isOpen =
      (typeof select.matches === 'function' && select.matches(':open')) ||
      select.hasAttribute('open');

    if (!isOpen) return;

    if (typeof select.hidePopover === 'function') {
      try {
        select.hidePopover();
      } catch (e) {
        // hidePopover melempar jika popover tidak dalam keadaan terbuka —
        // abaikan, blur() di bawah akan menutupnya.
      }
    }

    select.blur();
  });
}

// Capture phase (true) supaya scroll dari elemen mana pun (termasuk
// container ber-overflow) ikut tertangkap, bukan hanya scroll di window.
document.addEventListener('scroll', closeOpenSelect, true);
