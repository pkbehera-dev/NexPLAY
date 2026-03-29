<?php include_once dirname(__DIR__, 2) . '/includes/toast.php'; ?>
<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white shadow" style="width: 250px; height: 100vh; position: fixed; left: 0; top: 0; z-index: 1050; transition: transform 0.3s ease-in-out;" id="sidebarMenu">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none w-100">
        <a href="/NexPLAY/admin/dashboard.php" class="text-white text-decoration-none fs-4 fw-bold">
            <i class="bi bi-shield-lock-fill text-primary me-2"></i>Admin
        </a>
        <button class="btn btn-sm btn-outline-light d-md-none border-0" id="closeSidebarBtn">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <hr class="border-secondary">
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item mb-2">
        <a href="/NexPLAY/admin/dashboard.php" class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active fw-bold' : ''; ?>" aria-current="page">
          <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="/NexPLAY/admin/manage_users.php" class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'manage_users.php' ? 'active fw-bold' : ''; ?>">
          <i class="bi bi-people me-2"></i> Users
        </a>
      </li>
      <li class="nav-item">
        <a href="/NexPLAY/admin/settings.php" class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active fw-bold' : ''; ?>">
          <i class="bi bi-gear me-2"></i> Settings
        </a>
      </li>
    </ul>
    <hr class="border-secondary">
    <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: rgba(255,255,255,0.05);">
        <span class="small fw-bold text-truncate" style="max-width: 140px;" title="<?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>">
            <i class="bi bi-person-circle text-primary me-1"></i> <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
        </span>
        <a href="/NexPLAY/logout" class="btn btn-outline-danger btn-sm border-0" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
    </div>
</div>

<!-- Mobile Toggle Header (Hidden on Desktop) -->
<div class="d-md-none bg-dark text-white p-3 d-flex justify-content-between align-items-center shadow-sm w-100 border-bottom border-secondary" style="position: sticky; top: 0; z-index: 1000;" id="mobileHeader">
    <div class="fw-bold fs-5">
        <i class="bi bi-shield-lock-fill text-primary me-2"></i>Admin Panel
    </div>
    <button class="btn btn-outline-light btn-sm border-0" id="openSidebarBtn">
        <i class="bi bi-list fs-4"></i>
    </button>
</div>

<!-- Dynamic Layout Styling -->
<style>
    body {
        background-color: #f8f9fa; /* Uniform light-grey background for all admin pages */
    }
    
    .admin-content-wrapper {
        margin-left: 250px;
        min-height: 100vh;
        width: calc(100% - 250px);
    }

    /* Mobile specific adjustments */
    @media (max-width: 768px) {
        #sidebarMenu {
            transform: translateX(-100%);
        }
        #sidebarMenu.open {
            transform: translateX(0);
        }
        .admin-content-wrapper {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebarMenu');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        if(openBtn) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.add('open');
            });
        }
        
        if(closeBtn) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('open');
            });
        }
    });
</script>

<!-- Content wrapper initialization (Should be closed right before </body>) -->
<div class="admin-content-wrapper">
