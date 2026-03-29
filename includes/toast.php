<?php
$toastMsg = '';
$toastType = 'bg-success text-white';

if (isset($_SESSION['msg'])) {
    $toastMsg = $_SESSION['msg'];
    $toastType = 'bg-success text-white';
    unset($_SESSION['msg']);
} elseif (isset($_SESSION['auth_success'])) {
    $toastMsg = $_SESSION['auth_success'];
    $toastType = 'bg-success text-white';
    unset($_SESSION['auth_success']);
} elseif (isset($_SESSION['auth_error'])) {
    $toastMsg = $_SESSION['auth_error'];
    $toastType = 'bg-danger text-white';
    unset($_SESSION['auth_error']);
}

if ($toastMsg !== ''): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
        <div id="systemToast" class="toast align-items-center <?php echo $toastType; ?> border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi bi-info-circle-fill me-2"></i><?php echo htmlspecialchars($toastMsg); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('systemToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
<?php endif; ?>
