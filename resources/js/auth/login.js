/**
 * Login Form Handler
 * Mengelola navigasi berdasarkan role yang dipilih
 */

function initLoginForm() {
    const loginBtn = document.getElementById('btnSubmitLogin');
    if (loginBtn) {
        loginBtn.addEventListener('click', handleLoginSubmit);
    }
}

function handleLoginSubmit() {
    const roleSelect = document.getElementById('role');
    const selectedRole = roleSelect.value;

    if (!selectedRole) {
        alert('Silakan pilih hak akses terlebih dahulu!');
        return;
    }

    const routes = JSON.parse(document.body.dataset.loginRoutes || '{}');
    const route = routes[selectedRole];

    if (route) {
        window.location.href = route;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initLoginForm);
