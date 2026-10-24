import './bootstrap';
import './flash';
import './login-success';
import { applySidebarState, toggleSidebar } from './sidebar';
import { openCropper, closeCropper, saveCrop } from './cropper-handler';
import { confirmDelete, closeDeleteModal, openQrModal, closeQrModal, openImageModal, closeImageModal } from './modals';
import { togglePassword } from './auth';

// Assign to window for inline HTML event binding (onclick, onchange, etc.)
window.applySidebarState = applySidebarState;
window.toggleSidebar = toggleSidebar;

window.openCropper = openCropper;
window.closeCropper = closeCropper;
window.saveCrop = saveCrop;

window.confirmDelete = confirmDelete;
window.closeDeleteModal = closeDeleteModal;

window.openQrModal = openQrModal;
window.closeQrModal = closeQrModal;

window.openImageModal = openImageModal;
window.closeImageModal = closeImageModal;

window.togglePassword = togglePassword;
