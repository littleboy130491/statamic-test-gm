// Dropdown manual (JS) untuk .comparison-select (single produk) dan
// select.contact-form-input (form kontak).
//
// Kenapa manual: customizable select CSS (appearance: base-select) merender
// panel di TOP-LAYER sehingga menembus sticky header dan tak bisa ditutup dari
// JS. Solusinya: <select> asli disembunyikan (tetap jadi sumber data + tetap
// men-dispatch 'change' agar logika lain/AJAX tidak perlu diubah), lalu kita
// bangun tombol + panel <div> biasa dengan z-index normal (tidak menembus
// header). Panel adalah elemen biasa, jadi buka/tutup 100% terkontrol.

function buildDropdown(select) {
  // Bungkus posisi relatif untuk anchor panel.
  const wrap = document.createElement('div');
  wrap.className = 'cmp-dd';

  const button = document.createElement('button');
  button.type = 'button';
  button.className = 'cmp-dd-button ' + select.className;
  button.setAttribute('aria-haspopup', 'listbox');
  button.setAttribute('aria-expanded', 'false');

  const label = document.createElement('span');
  label.className = 'cmp-dd-label notranslate';
  button.appendChild(label);

  const caret = document.createElement('span');
  caret.className = 'cmp-dd-caret';
  button.appendChild(caret);

  const panel = document.createElement('div');
  panel.className = 'cmp-dd-panel';
  panel.setAttribute('role', 'listbox');
  panel.hidden = true;

  // Placeholder = <option value="" disabled> (mis. "Pilih subjek"). Tidak
  // dirender sebagai item pilihan, hanya jadi label awal tombol.
  const isPlaceholder = (opt) => opt.value === '' && opt.disabled;

  // Bangun isi panel dari optgroup/option milik <select>.
  const optionEls = [];
  Array.from(select.children).forEach((child) => {
    if (child.tagName === 'OPTGROUP') {
      const group = document.createElement('div');
      group.className = 'cmp-dd-group';
      group.textContent = child.label;
      panel.appendChild(group);

      Array.from(child.children).forEach((opt) => {
        if (isPlaceholder(opt)) return;
        panel.appendChild(makeOption(opt));
      });
    } else if (child.tagName === 'OPTION') {
      if (isPlaceholder(child)) return;
      panel.appendChild(makeOption(child));
    }
  });

  function makeOption(opt) {
    const el = document.createElement('div');
    el.className = 'cmp-dd-option notranslate';
    el.textContent = opt.textContent.trim();
    el.dataset.value = opt.value;
    el.setAttribute('role', 'option');
    if (opt.disabled) el.setAttribute('aria-disabled', 'true');
    optionEls.push(el);

    el.addEventListener('click', () => {
      if (opt.disabled) return;
      select.value = opt.value;
      // Trigger 'change' agar comparison.js memuat data (AJAX) seperti biasa.
      select.dispatchEvent(new Event('change', { bubbles: true }));
      syncFromSelect();
      close();
    });
    return el;
  }

  function syncFromSelect() {
    const current = select.options[select.selectedIndex];
    label.textContent = current ? current.textContent.trim() : '';
    // Tandai jika yang tampil masih placeholder (untuk styling teks muted).
    button.classList.toggle('is-placeholder', !!current && isPlaceholder(current));
    optionEls.forEach((el) => {
      el.classList.toggle('is-selected', el.dataset.value === select.value);
    });
  }

  function open() {
    // Tutup semua dropdown lain — hanya satu yang boleh terbuka.
    document.dispatchEvent(new CustomEvent('cmp-dd:open', { detail: wrap }));
    panel.hidden = false;
    button.setAttribute('aria-expanded', 'true');
    wrap.classList.add('is-open');
  }

  // Tutup jika dropdown LAIN yang dibuka.
  document.addEventListener('cmp-dd:open', (e) => {
    if (e.detail !== wrap) close();
  });

  function close() {
    panel.hidden = true;
    button.setAttribute('aria-expanded', 'false');
    wrap.classList.remove('is-open');
  }

  function toggle() {
    if (panel.hidden) open();
    else close();
  }

  button.addEventListener('click', (e) => {
    e.stopPropagation();
    toggle();
  });

  // Tutup saat klik di luar.
  document.addEventListener('click', (e) => {
    if (!wrap.contains(e.target)) close();
  });

  // Tutup saat Escape.
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });

  // Sisipkan struktur manual, sembunyikan <select> asli (tetap di DOM).
  select.parentNode.insertBefore(wrap, select);
  wrap.appendChild(button);
  wrap.appendChild(panel);
  wrap.appendChild(select);
  select.classList.add('cmp-dd-native');

  // Jika comparison.js mengubah value select secara programatik, ikut sync.
  select.addEventListener('change', syncFromSelect);

  syncFromSelect();
}

function init() {
  document
    .querySelectorAll('.comparison-select, select.contact-form-input')
    .forEach((select) => {
      if (select.dataset.cmpDdReady) return;
      select.dataset.cmpDdReady = '1';
      buildDropdown(select);
    });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
