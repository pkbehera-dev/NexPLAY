<?php 
require_once dirname(__DIR__) . '/config/init.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /NexPLAY/");
    exit();
}
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];
$active_tab = $_GET['tab'] ?? 'profile';

// Handle Profile Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'profile') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$username, $email, $user_id]);
    if ($stmt->fetch()) {
        $_SESSION['msg'] = "Username or Email already taken by another account.";
        header("Location: settings.php?tab=profile");
        exit();
    }

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password_hash = ? WHERE id = ?");
        $stmt->execute([$username, $email, $hash, $user_id]);
        $_SESSION['msg'] = "Profile and password updated successfully.";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $user_id]);
        $_SESSION['msg'] = "Profile updated successfully.";
    }
    
    $_SESSION['username'] = $username;
    header("Location: settings.php?tab=profile");
    exit();
}

// Handle SMTP Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'smtp') {
    if (isset($_POST['action']) && $_POST['action'] === 'test_email') {
        require_once '../config/mail.php';
        $test_email = filter_var($_POST['test_email_address'], FILTER_VALIDATE_EMAIL);
        if ($test_email) {
            $subject = "NexPlay SMTP Test";
            $message = "<h1>SMTP Configuration is successful!</h1><p>Your SMTP details in NexPlay are working correctly.</p>";
            if (sendMail($pdo, $test_email, $subject, $message)) {
                $_SESSION['msg'] = "Test email sent successfully to $test_email!";
            } else {
                $_SESSION['msg'] = "Failed to send test email. Check your configuration or server environment.";
            }
        } else {
             $_SESSION['msg'] = "Invalid test email address.";
        }
        header("Location: settings.php?tab=smtp");
        exit();
    } else {
        foreach ($_POST['settings'] as $key => $value) {
            $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->execute([$value, $key]);
        }
        $_SESSION['msg'] = "SMTP configuration updated successfully.";
        header("Location: settings.php?tab=smtp");
        exit();
    }
}

// Fetch Profile Data
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch SMTP Data
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$smtp_settings = [];
while ($row = $stmt->fetch()) {
    $smtp_settings[$row['setting_key']] = $row['setting_value'];
}

include 'includes/head_admin.php'; 
include 'includes/nav_admin.php'; 
?>

<main class="container py-5" id="main-content" tabindex="-1" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h1 class="h2 fw-bold text-dark">Platform Settings</h1>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab === 'profile' ? 'active' : '' ?> text-dark fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="<?= $active_tab === 'profile' ? 'true' : 'false' ?>">
                <i class="bi bi-person-gear me-2"></i>Profile Settings
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab === 'smtp' ? 'active' : '' ?> text-dark fw-bold" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp" type="button" role="tab" aria-controls="smtp" aria-selected="<?= $active_tab === 'smtp' ? 'true' : 'false' ?>">
                <i class="bi bi-envelope-gear me-2"></i>SMTP Configuration
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="settingsTabContent">
        
        <!-- Profile Tab -->
        <div class="tab-pane fade <?= $active_tab === 'profile' ? 'show active' : '' ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="admin-card shadow-sm">
                <form action="settings.php?tab=profile" method="POST">
                    <input type="hidden" name="form_type" value="profile">
                    <fieldset class="mb-4">
                        <legend class="h5 fw-bold text-primary border-bottom pb-2 mb-3">Account Information</legend>
                        
                        <div class="mb-3">
                            <label for="profileUsername" class="form-label fw-bold text-dark">Username</label>
                            <input type="text" id="profileUsername" name="username" class="form-control border-dark" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="profileEmail" class="form-label fw-bold text-dark">Email Address</label>
                            <input type="email" id="profileEmail" name="email" class="form-control border-dark" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="profilePassword" class="form-label fw-bold text-dark">New Password <span class="text-muted fw-normal">(Leave blank to keep current)</span></label>
                            <div class="input-group">
                                <input type="password" id="profilePassword" name="password" class="form-control border-dark">
                                <button class="btn btn-outline-dark" type="button" onclick="togglePassword('profilePassword', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </fieldset>

                    <script>
                        function togglePassword(inputId, btn) {
                            const input = document.getElementById(inputId);
                            const icon = btn.querySelector('i');
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.replace('bi-eye', 'bi-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.replace('bi-eye-slash', 'bi-eye');
                            }
                        }
                    </script>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SMTP Tab -->
        <div class="tab-pane fade <?= $active_tab === 'smtp' ? 'show active' : '' ?>" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
            <div class="admin-card shadow-sm">
                <form action="settings.php?tab=smtp" method="POST">
                    <input type="hidden" name="form_type" value="smtp">
                    <fieldset class="mb-4">
                        <legend class="h5 fw-bold text-primary border-bottom pb-2 mb-3">Server Authentication</legend>
                        
                        <div class="mb-3">
                            <label for="smtpHost" class="form-label fw-bold text-dark">Connection Host</label>
                            <input type="text" id="smtpHost" name="settings[smtp_host]" class="form-control border-dark" value="<?php echo htmlspecialchars($smtp_settings['smtp_host'] ?? ''); ?>" required aria-describedby="hostHelp">
                            <div id="hostHelp" class="form-text text-muted">Example: smtp.gmail.com or mail.example.com</div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="smtpPort" class="form-label fw-bold text-dark">Port</label>
                                <input type="number" id="smtpPort" name="settings[smtp_port]" class="form-control border-dark" value="<?php echo htmlspecialchars($smtp_settings['smtp_port'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="smtpEnc" class="form-label fw-bold text-dark">Encryption Standard</label>
                                <select id="smtpEnc" name="settings[smtp_encryption]" class="form-select border-dark">
                                    <option value="tls" <?php echo ($smtp_settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : ''; ?>>TLS / STARTTLS (Recommended)</option>
                                    <option value="ssl" <?php echo ($smtp_settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                    <option value="none" <?php echo ($smtp_settings['smtp_encryption'] ?? '') == 'none' ? 'selected' : ''; ?>>None</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="smtpUser" class="form-label fw-bold text-dark">Account Username</label>
                                <input type="text" id="smtpUser" name="settings[smtp_username]" class="form-control border-dark" value="<?php echo htmlspecialchars($smtp_settings['smtp_username'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="smtpPass" class="form-label fw-bold text-dark">Account Password</label>
                                <div class="input-group">
                                    <input type="password" id="smtpPass" name="settings[smtp_password]" class="form-control border-dark" value="<?php echo htmlspecialchars($smtp_settings['smtp_password'] ?? ''); ?>" required>
                                    <button class="btn btn-outline-dark" type="button" onclick="togglePassword('smtpPass', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-5">
                        <legend class="h5 fw-bold text-primary border-bottom pb-2 mb-3">Sender Identity</legend>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fromEmail" class="form-label fw-bold text-dark">From Email Address</label>
                                <input type="email" id="fromEmail" name="settings[smtp_from_email]" class="form-control border-dark" value="<?php echo htmlspecialchars($smtp_settings['smtp_from_email'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fromName" class="form-label fw-bold text-dark">From Display Name</label>
                                <input type="text" id="fromName" name="settings[smtp_from_name]" class="form-control border-dark" value="<?php echo htmlspecialchars($smtp_settings['smtp_from_name'] ?? ''); ?>" required>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm" aria-label="Save current form changes">Save Configuration</button>
                    </div>
                </form>
            </div>

            <!-- Test Email Section -->
            <div class="admin-card shadow-sm mt-4 bg-light">
                <h2 class="h5 fw-bold text-dark border-bottom pb-2 mb-3">Test Configuration</h2>
                <p class="text-muted small">Send a test email to verify your SMTP settings above before utilizing them on the platform.</p>
                <form action="settings.php?tab=smtp" method="POST" class="d-flex gap-2">
                    <input type="hidden" name="form_type" value="smtp">
                    <input type="hidden" name="action" value="test_email">
                    <input type="email" name="test_email_address" class="form-control border-dark" placeholder="Enter recipient email address..." required aria-label="Test Email Address">
                    <button type="submit" class="btn btn-secondary fw-bold shadow-sm" style="min-width: 150px;">Send Test</button>
                </form>
            </div>
        </div>
        
    </div>
</main>

</div> <!-- End admin-content-wrapper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Update URL without reloading when switching tabs
    document.addEventListener("DOMContentLoaded", function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('click', function (event) {
                var tab = event.target.getAttribute('aria-controls');
                history.replaceState(null, null, 'settings.php?tab=' + tab);
            });
        });
    });
</script>
</body>
</html>
