<div id="toast-container"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to create and show a Bootstrap 5 toast
        window.showBootstrapToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            // Define theme color classes
            let bgClass = 'bg-success';
            let iconClass = 'fa-circle-check';
            if (type === 'error' || type === 'danger') {
                bgClass = 'bg-danger';
                iconClass = 'fa-circle-exclamation';
            } else if (type === 'warning') {
                bgClass = 'bg-warning text-dark';
                iconClass = 'fa-triangle-exclamation';
            } else if (type === 'info') {
                bgClass = 'bg-info text-white';
                iconClass = 'fa-circle-info';
            }

            const toastId = 'toast-' + Date.now();
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center border-0 text-white ${bgClass} shadow-soft" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
                    <div class="d-flex align-items-center p-2">
                        <div class="toast-body d-flex align-items-center gap-2">
                            <i class="fa-solid ${iconClass} fs-5"></i>
                            <span class="fw-semibold small">${message}</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', toastHtml);
            const toastEl = document.getElementById(toastId);
            const bsToast = new bootstrap.Toast(toastEl);
            bsToast.show();

            // Automatically clean up toast elements after they hide
            toastEl.addEventListener('hidden.bs.toast', function() {
                toastEl.remove();
            });
        };

        // Listen for Livewire/window dispatch notifications
        window.addEventListener('session-message', function(event) {
            showBootstrapToast(event.detail.message, event.detail.type);
        });

        window.addEventListener('notify', function(event) {
            showBootstrapToast(event.detail.message, event.detail.type);
        });

        // Trigger flash session notifications immediately on load
        @if(session('success'))
            showBootstrapToast("{{ session('success') }}", 'success');
        @endif
        @if(session('error'))
            showBootstrapToast("{{ session('error') }}", 'danger');
        @endif
        @if(session('status'))
            showBootstrapToast("{{ session('status') }}", 'info');
        @endif
    });
</script>
