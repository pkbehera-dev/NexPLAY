<?php 
require_once dirname(__DIR__) . '/config/init.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /NexPLAY/");
    exit();
}
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        header("Location: smtp_settings.php");
        exit();
    } else {
        foreach ($_POST['settings'] as $key => $value) {
            $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->execute([$value, $key]);
        }
        $_SESSION['msg'] = "SMTP configuration updated successfully.";
        header("Location: smtp_settings.php");
        exit();
    }
}

// Fetch current
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
include 'includes/head_admin.php'; 
include 'includes/nav_admin.php'; 
?>

<main class="container py-5" id="main-content" tabindex="-1" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h1 class="h2 fw-bold text-dark">Outbound Email (SMTP) Configuration</h1>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm" aria-label="Return to Dashboard"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <!-- Toast notifications handle msg -->

    <div class="admin-card shadow-sm">
        <form action="smtp_settings.php" method="POST">
            <fieldset class="mb-4">
                <legend class="h5 fw-bold text-primary border-bottom pb-2 mb-3">Server Authentication</legend>
                
                <div class="mb-3">
                    <label for="smtpHost" class="form-label fw-bold text-dark">Connection Host</label>
                    <input type="text" id="smtpHost" name="settings[smtp_host]" class="form-control border-dark" value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>" required aria-describedby="hostHelp">
                    <div id="hostHelp" class="form-text text-muted">Example: smtp.gmail.com or mail.example.com</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="smtpPort" class="form-label fw-bold text-dark">Port</label>
                        <input type="number" id="smtpPort" name="settings[smtp_port]" class="form-control border-dark" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="smtpEnc" class="form-label fw-bold text-dark">Encryption Standard</label>
                        <select id="smtpEnc" name="settings[smtp_encryption]" class="form-select border-dark">
                            <option value="tls" <?php echo ($settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : ''; ?>>TLS / STARTTLS (Recommended)</option>
                            <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            <option value="none" <?php echo ($settings['smtp_encryption'] ?? '') == 'none' ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="smtpUser" class="form-label fw-bold text-dark">Account Username</label>
                        <input type="text" id="smtpUser" name="settings[smtp_username]" class="form-control border-dark" value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="smtpPass" class="form-label fw-bold text-dark">Account Password</label>
                        <div class="input-group">
                            <input type="password" id="smtpPass" name="settings[smtp_password]" class="form-control border-dark" value="<?php echo htmlspecialchars($settings['smtp_password'] ?? ''); ?>" required>
                            <button class="btn btn-outline-dark" type="button" onclick="togglePassword('smtpPass', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
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

            <fieldset class="mb-5">
                <legend class="h5 fw-bold text-primary border-bottom pb-2 mb-3">Sender Identity</legend>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="fromEmail" class="form-label fw-bold text-dark">From Email Address</label>
                        <input type="email" id="fromEmail" name="settings[smtp_from_email]" class="form-control border-dark" value="<?php echo htmlspecialchars($settings['smtp_from_email'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fromName" class="form-label fw-bold text-dark">From Display Name</label>
                        <input type="text" id="fromName" name="settings[smtp_from_name]" class="form-control border-dark" value="<?php echo htmlspecialchars($settings['smtp_from_name'] ?? ''); ?>" required>
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
        <form action="smtp_settings.php" method="POST" class="d-flex gap-2">
            <input type="hidden" name="action" value="test_email">
            <input type="email" name="test_email_address" class="form-control border-dark" placeholder="Enter recipient email address..." required aria-label="Test Email Address">
            <button type="submit" class="btn btn-secondary fw-bold shadow-sm" style="min-width: 150px;">Send Test</button>
        </form>
    </div>
</main>

</div> <!-- End admin-content-wrapper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
