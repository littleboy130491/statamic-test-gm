// Javascript untuk popup form single career.
// - Klik overlay untuk menutup popup.
// - Submit form via AJAX supaya popup TIDAK menutup setelah submit/success/error.

document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('career-popup');
    if (!popup) return;

    // Kunci scroll body saat popup terbuka.
    const observer = new MutationObserver(function () {
        document.body.style.overflow = popup.open ? 'hidden' : '';
    });
    observer.observe(popup, { attributes: true, attributeFilter: ['open'] });

    // Klik di luar box menutup popup.
    popup.addEventListener('click', function (e) {
        const box = popup.querySelector('.career-popup-inner');
        if (box && !box.contains(e.target)) {
            popup.close();
        }
    });

    // Buka otomatis jika ada success/error dari render server (fallback non-JS).
    if (popup.dataset.autoOpen === 'true') {
        popup.showModal();
    }

    const form = popup.querySelector('[data-ajax-form]');
    if (!form) return;

    const successBox = popup.querySelector('.career-form-success');
    const errorBox = popup.querySelector('.career-form-error');
    const errorHeading = errorBox ? errorBox.querySelector('.career-form-error-heading') : null;
    const errorList = errorBox ? errorBox.querySelector('.career-form-error-list') : null;
    const submitBtn = form.querySelector('button[type="submit"]');
    const submitLabel = submitBtn ? submitBtn.innerHTML : '';
    const csrf = document.querySelector('meta[name="csrf-token"]');

    function hide(el) {
        if (el) el.classList.add('hidden');
    }
    function show(el) {
        if (el) el.classList.remove('hidden');
    }

    function showErrors(messages) {
        if (!errorBox) return;
        const failedMsg = errorBox.dataset.messageFailed || '';
        if (errorHeading) {
            if (failedMsg) {
                // Pesan dari Bard berupa HTML.
                errorHeading.innerHTML = failedMsg;
                show(errorHeading);
            } else {
                hide(errorHeading);
            }
        }
        if (errorList) {
            errorList.innerHTML = '';
            messages.forEach(function (msg) {
                const li = document.createElement('li');
                li.textContent = msg;
                errorList.appendChild(li);
            });
        }
        show(errorBox);
        hide(successBox);
        errorBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function showSuccess(message) {
        hide(errorBox);
        if (successBox) {
            // Utamakan pesan dari Bard (HTML). Pesan dari server (plain) di-escape.
            const bardMsg = successBox.dataset.successMessage || '';
            if (bardMsg) {
                successBox.innerHTML = bardMsg;
            } else {
                successBox.textContent = message || '';
            }
            show(successBox);
            successBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Reset state pesan sebelumnya.
        hide(errorBox);
        hide(successBox);

        if (submitBtn) submitBtn.disabled = true;

        const formData = new FormData(form);
        const headers = {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };
        if (csrf) headers['X-CSRF-TOKEN'] = csrf.content;

        fetch(form.getAttribute('action'), {
            method: (form.getAttribute('method') || 'POST').toUpperCase(),
            headers: headers,
            body: formData,
        })
            .then(function (res) {
                return res.json().then(function (data) {
                    return { ok: res.ok, data: data };
                });
            })
            .then(function (result) {
                const data = result.data || {};
                if (result.ok && (data.success || !data.errors)) {
                    form.reset();
                    // Reset nama file yang dipilih ke placeholder.
                    form.querySelectorAll('.career-form-file-name').forEach(function (el) {
                        if (el.dataset.placeholder) el.textContent = el.dataset.placeholder;
                    });
                    showSuccess(data.success);
                } else {
                    let messages = [];
                    if (Array.isArray(data.errors)) {
                        messages = data.errors;
                    } else if (data.errors && typeof data.errors === 'object') {
                        Object.keys(data.errors).forEach(function (key) {
                            const val = data.errors[key];
                            messages = messages.concat(Array.isArray(val) ? val : [val]);
                        });
                    }
                    if (!messages.length) messages = ['Terjadi kesalahan. Silakan coba lagi.'];
                    showErrors(messages);
                }
            })
            .catch(function () {
                showErrors(['Terjadi kesalahan jaringan. Silakan coba lagi.']);
            })
            .finally(function () {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitLabel;
                }
            });
    });
});
