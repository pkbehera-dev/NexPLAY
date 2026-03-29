<?php
require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/config/mail.php';

$action = strtolower(trim($_POST['action'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'register') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try {
            // Check if username or email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $_SESSION['auth_error'] = "Username or Email already exists.";
                header("Location: /NexPLAY/register");
                exit();
            }

            // Hash password
            $hash = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);

            // Try sending welcome email
            $subject = "Welcome to NexPlay Hub!";
            $message = "<h1>Hello $username!</h1><p>Thank you for registering at NexPlay. We are excited to have you onboard.</p>";
            sendMail($pdo, $email, $subject, $message);

            $_SESSION['auth_success'] = "Registration successful! You may now login.";
            header("Location: /NexPLAY/login");
            exit();

        } catch (PDOException $e) {
            $_SESSION['auth_error'] = "Database error: " . $e->getMessage();
            header("Location: /NexPLAY/register");
            exit();
        }
    } 
    elseif ($action === 'login') {
        $login_id = trim($_POST['login_id']); // Can be username or email
        $password = $_POST['password'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$login_id, $login_id]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Check if banned or blocked
                if ($user['status'] === 'banned') {
                    $_SESSION['auth_error'] = "This account has been permanently banned.";
                    header("Location: /NexPLAY/login");
                    exit();
                }

                if ($user['status'] === 'blocked' && $user['blocked_until'] !== null) {
                    $blocked_until = new DateTime($user['blocked_until']);
                    $now = new DateTime();
                    if ($now < $blocked_until) {
                        $_SESSION['auth_error'] = "This account is temporarily blocked until " . $blocked_until->format('Y-m-d H:i:s');
                        header("Location: /NexPLAY/login");
                        exit();
                    } else {
                        // Block expired, set to active
                        $stmt = $pdo->prepare("UPDATE users SET status = 'active', blocked_until = NULL WHERE id = ?");
                        $stmt->execute([$user['id']]);
                    }
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header("Location: /NexPLAY/admin/dashboard.php");
                } else {
                    header("Location: /NexPLAY/");
                }
                exit();
            } else {
                $_SESSION['auth_error'] = "Invalid credentials.";
                header("Location: /NexPLAY/login");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['auth_error'] = "Database error: " . $e->getMessage();
            header("Location: /NexPLAY/login");
            exit();
        }
    }
}
?>
