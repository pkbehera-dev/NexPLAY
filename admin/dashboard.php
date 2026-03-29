<?php 
require_once dirname(__DIR__) . '/config/init.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /NexPLAY/");
    exit();
}
require_once '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['favicon'])) {
    $file = $_FILES['favicon'];
    $allowed_types = ['image/png', 'image/x-icon', 'image/vnd.microsoft.icon'];
    
    if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowed_types)) {
        $upload_dir = dirname(__DIR__) . '/assets/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $target_path = $upload_dir . 'favicon.png';
        
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            $_SESSION['msg'] = "Platform favicon updated successfully!";
        } else {
            $_SESSION['auth_error'] = "Failed to save file. Check directory permissions.";
        }
    } else {
        $_SESSION['auth_error'] = "Invalid file type or upload error. Please upload a valid PNG or ICO file.";
    }
    header("Location: dashboard.php");
    exit();
}

include 'includes/head_admin.php'; 
include 'includes/nav_admin.php'; 

// Fetch stats
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$active_users = $pdo->query("SELECT COUNT(*) FROM users WHERE status = 'active'")->fetchColumn();
$banned_users = $pdo->query("SELECT COUNT(*) FROM users WHERE status = 'banned'")->fetchColumn();
?>

<main class="container py-5" id="main-content" tabindex="-1">
    <header class="mb-5 border-bottom pb-3">
        <h1 class="display-5 text-dark fw-bold">System Dashboard</h1>
        <p class="text-muted fs-5">Overview of NexPlay system configuration and user metrics.</p>
    </header>

    <div class="row g-4">
        <!-- User Stats -->
        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="h5 border-bottom pb-2">User Population</h2>
                <ul class="list-group list-group-flush mt-3 mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                        Total Users
                        <span class="badge bg-secondary rounded-pill fs-6"><?php echo $total_users; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                        Active Accounts
                        <span class="badge bg-success rounded-pill fs-6"><?php echo $active_users; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                        Banned Accounts
                        <span class="badge bg-danger rounded-pill fs-6"><?php echo $banned_users; ?></span>
                    </li>
                </ul>
                <a href="manage_users.php" class="btn btn-primary w-100 shadow-sm" aria-label="Navigate to user management">Manage Users</a>
            </div>
        </div>
        
        <!-- SMTP Config -->
        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="h5 border-bottom pb-2">Email Configuration</h2>
                <p class="text-dark my-3">Update your outbound SMTP connection details to ensure platform emails are successfully dispatched.</p>
                <a href="smtp_settings.php" class="btn btn-outline-primary w-100 shadow-sm" aria-label="Navigate to SMTP configuration">Configure SMTP</a>
            </div>
        </div>

        <!-- Branding Upload -->
        <div class="col-md-4">
            <div class="admin-card h-100 bg-light d-flex flex-column">
                <h2 class="h5 border-bottom pb-2">Platform Branding</h2>
                <div class="flex-grow-1">
                    <p class="text-dark mt-3 mb-2 small">Upload a custom `.png` or `.ico` file to update your site's Favicon (browser tab icon) universally.</p>
                </div>
                <form action="dashboard.php" method="POST" enctype="multipart/form-data" class="mt-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control border-dark" type="file" name="favicon" accept=".png, .ico" required aria-label="Upload Favicon">
                        <button type="submit" class="btn btn-dark fw-bold border-dark">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

</div> <!-- End admin-content-wrapper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
