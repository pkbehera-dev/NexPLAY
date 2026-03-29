<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-cyber sticky-top">
  <div class="container">
    <a class="navbar-brand text-uppercase" href="/NexPLAY/">
        <i class="bi bi-controller"></i> NexPlay
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/NexPLAY/">Home</a>
        </li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-bold" href="/NexPLAY/admin/dashboard.php">
                        <i class="bi bi-shield-lock"></i> Admin
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item dropdown ms-3">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; margin-right: 8px;">
                        <i class="bi bi-person text-white"></i>
                    </div>
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item text-danger" href="/NexPLAY/logout">Logout</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="/NexPLAY/login">Login</a>
            </li>
            <li class="nav-item ms-2">
                <a class="btn btn-cyber btn-sm" href="/NexPLAY/register">Sign Up</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<?php include_once __DIR__ . '/toast.php'; ?>
