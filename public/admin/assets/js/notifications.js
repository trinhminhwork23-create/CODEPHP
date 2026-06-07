<script>
(function() {
    let lastNotificationCheck = Date.now();
    const POLL_INTERVAL = 15000;
    const notificationContainer = document.createElement('div');
    notificationContainer.id = 'notification-toast-container';
    notificationContainer.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;max-width:350px;';
    document.body.appendChild(notificationContainer);

    function showNotification(data) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-info alert-dismissible fade show shadow-lg';
        toast.innerHTML = `
            <strong>${data.title || 'Thông báo mới'}</strong>
            <p class="mb-0 small">${data.message}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        notificationContainer.appendChild(toast);
        setTimeout(() => toast.remove(), 8000);
    }

    function checkNewActivity() {
        fetch('/admin/logs/latest?since=' + lastNotificationCheck)
            .then(res => res.ok ? res.json() : null)
            .then(data => {
                if (data && data.new_activities > 0) {
                    showNotification({
                        title: 'Hoạt động mới',
                        message: `Có ${data.new_activities} hoạt động mới trong hệ thống`
                    });
                    lastNotificationCheck = Date.now();
                }
            })
            .catch(() => {});
    }

    if (window.location.pathname.includes('/admin')) {
        setInterval(checkNewActivity, POLL_INTERVAL);
    }
})();
</script>
