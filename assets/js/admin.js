// SAS TokoRumah - Shared Admin JS
// Digunakan di semua halaman admin (sidebar toggle, toast, modal swipe)

function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    if (sidebar) sidebar.classList.toggle('show');
    if (overlay) overlay.classList.toggle('show');
}

function toast(msg, type) {
    const t = document.getElementById('toast');
    if (!t) return;
    t.className = 'toast ' + (type || 'info') + ' show';
    document.getElementById('toastMsg').textContent = (type === 'success' ? '✓ ' : type === 'error' ? '⚠ ' : '') + msg;
    setTimeout(() => t.classList.remove('show'), 3000);
}

// Touch swipe down to close modal (mobile)
(function() {
    let startY = 0, currentY = 0, dragging = false, target = null;
    document.addEventListener('touchstart', e => {
        const modal = e.target.closest('.admin-modal-content');
        if (modal && e.touches[0].clientY < 100) {
            target = modal; startY = e.touches[0].clientY; dragging = true;
        }
    }, {passive: true});
    document.addEventListener('touchmove', e => {
        if (!dragging || !target) return;
        currentY = e.touches[0].clientY - startY;
        if (currentY > 0) {
            target.style.transform = `translateY(${currentY}px)`;
            target.style.transition = 'none';
        }
    }, {passive: true});
    document.addEventListener('touchend', e => {
        if (!dragging || !target) return;
        dragging = false;
        if (currentY > 100) {
            target.style.transition = 'transform .25s';
            target.style.transform = 'translateY(100%)';
            setTimeout(() => {
                target.style.transform = '';
                const modalId = target.parentElement.id;
                if (modalId) document.getElementById(modalId).classList.remove('show');
            }, 250);
        } else {
            target.style.transition = 'transform .25s';
            target.style.transform = '';
        }
        currentY = 0; target = null;
    });
})();
