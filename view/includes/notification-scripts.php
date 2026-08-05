<script>
(function () {
    const containerId = 'notificationContainer';

    function createContainer() {
        let container = document.getElementById(containerId);
        if (!container) {
            container = document.createElement('div');
            container.id = containerId;
            container.className = 'notification-container';
            document.body.appendChild(container);
        }
        return container;
    }

    function showNotification(message, type = 'success', duration = 4500) {
        const container = createContainer();
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `<span>${message}</span>`;
        container.appendChild(notification);

        requestAnimationFrame(() => {
            notification.classList.add('show');
        });

        const hideTimeout = setTimeout(() => {
            notification.classList.remove('show');
            notification.addEventListener('transitionend', () => notification.remove(), { once: true });
        }, duration);

        notification.addEventListener('click', () => {
            clearTimeout(hideTimeout);
            notification.classList.remove('show');
            notification.addEventListener('transitionend', () => notification.remove(), { once: true });
        });
    }

    window.notify = showNotification;
    window.notifySuccess = (message, duration) => showNotification(message, 'success', duration);
    window.notifyError = (message, duration) => showNotification(message, 'error', duration);
    window.notifyWarning = (message, duration) => showNotification(message, 'warning', duration);
    window.confirmAction = function (message) {
        return window.confirm(message);
    };
})();
</script>
