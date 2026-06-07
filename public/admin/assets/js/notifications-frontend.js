(function() {
    let lastCheck = Date.now();
    const INTERVAL = 15000;
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;max-width:350px;';
    document.body.appendChild(container);

    function notify(msg) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-info alert-dismissible fade show shadow';
        toast.innerHTML = `<strong>Hoạt động mới</strong><p class="mb-0 small">${msg}</p><button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 8000);
    }

    function poll() {
        fetch('/admin/logs/latest?since=' + lastCheck)
            .then(r => r.ok ? r.json() : null)
            .then(d => {
                if (d && d.new_activities > 0) {
                    notify(`Có ${d.new_activities} hoạt động mới`);
                    lastCheck = Date.now();
                }
            })
            .catch(() => {});
    }

    if (window.location.pathname.includes('/admin')) {
        setInterval(poll, INTERVAL);
    }
})();
