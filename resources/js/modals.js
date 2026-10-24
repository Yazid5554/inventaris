/**
 * Global Custom Modals Handler (Delete Confirmation, QR Preview, Image Preview)
 */

let activeDeleteForm = null;

// Delete Modal Functions
export function confirmDelete(event, message) {
    if (event) event.preventDefault();
    const form = event ? (event.target.closest('form') || event.target) : null;
    if (!form) return false;

    activeDeleteForm = form;
    if (message) {
        const msgEl = document.getElementById('deleteModalMessage');
        if (msgEl) msgEl.textContent = message;
    }

    const modal = document.getElementById('deleteConfirmModal');
    const content = document.getElementById('deleteConfirmModalContent');

    if (modal && content) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    return false;
}

export function closeDeleteModal() {
    const modal = document.getElementById('deleteConfirmModal');
    const content = document.getElementById('deleteConfirmModalContent');

    if (modal && content) {
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            activeDeleteForm = null;
        }, 200);
    }
}

// QR Code Preview Modal Functions
export function openQrModal(id, nama, kode, noInventaris, ruangan, gedungLantai) {
    const namaEl = document.getElementById('qrModalNama');
    const kodeEl = document.getElementById('qrModalKode');
    const noInvEl = document.getElementById('qrModalNoInv');
    const ruanganEl = document.getElementById('qrModalRuangan');
    const gedungEl = document.getElementById('qrModalGedung');
    const qrImg = document.getElementById('qrModalImg');
    const detailBtn = document.getElementById('qrModalDetailBtn');
    const printBtn = document.getElementById('qrModalPrintBtn');

    if (namaEl) namaEl.textContent = nama;
    if (kodeEl) kodeEl.textContent = kode || '-';
    if (noInvEl) noInvEl.textContent = noInventaris || '-';
    if (ruanganEl) ruanganEl.textContent = ruangan || '-';
    if (gedungEl) gedungEl.textContent = gedungLantai || '-';

    if (qrImg) qrImg.src = '/barang/' + id + '/qr';
    if (detailBtn) detailBtn.href = '/barang/' + id;
    if (printBtn) printBtn.href = '/barang/' + id + '/print-qr';

    const modal = document.getElementById('qrModal');
    const content = document.getElementById('qrModalContent');

    if (modal && content) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }
}

export function closeQrModal() {
    const modal = document.getElementById('qrModal');
    const content = document.getElementById('qrModalContent');

    if (modal && content) {
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
}

// Image Preview Modal Functions
export function openImageModal(src, title) {
    const srcEl = document.getElementById('imageModalSrc');
    const titleEl = document.getElementById('imageModalTitle');

    if (srcEl) srcEl.src = src;
    if (titleEl) titleEl.textContent = title || 'Preview Foto';

    const modal = document.getElementById('imageModal');
    const content = document.getElementById('imageModalContent');

    if (modal && content) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }
}

export function closeImageModal() {
    const modal = document.getElementById('imageModal');
    const content = document.getElementById('imageModalContent');

    if (modal && content) {
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
}

// Event Listeners Initialization
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (activeDeleteForm) {
                activeDeleteForm.submit();
            }
            closeDeleteModal();
        });
    }
});
