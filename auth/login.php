<?php require_once dirname(__DIR__) . '/config/init.php'; include dirname(__DIR__) . '/includes/head.php'; include dirname(__DIR__) . '/includes/nav.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="flex: 1; padding: 4rem 15px;">
    <div class="glass-panel w-100" style="max-width: 400px;">
        <h2 class="text-center mb-4 navbar-brand" style="font-size: 2rem;">LOGIN</h2>
        
        <!-- Toast notifications will handle auth messages -->

        <form action="/NexPLAY/auth_actions" method="POST">
            <input type="hidden" name="action" value="login">
            <div class="mb-4">
                <label class="form-label text-secondary">Username or Email</label>
                <input type="text" name="login_id" class="form-control form-control-cyber" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-secondary">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control form-control-cyber" required>
                    <button class="btn btn-outline-secondary border-secondary-subtle" type="button" onclick="togglePassword('password', this)" style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
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
            <button type="submit" class="btn btn-cyber w-100 mb-3">Sign In</button>
            <div class="text-center mt-3">
                <small class="text-secondary">Don't have an account? <a href="/NexPLAY/register" class="text-info text-decoration-none">Register here</a></small>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
