<?php
require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/db.php';

try {
    // Generate bcrypt hash for 'admin123'
    $password = 'admin123';
    $hash = password_hash($password, PASSWORD_BCRYPT);
    
    // Update the admin user
    $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE username = 'admin'");
    $stmt->execute([$hash]);
    
    echo "Admin password has been reset to: <strong>admin123</strong>";
    echo "<br><a href='/NexPLAY/login'>Go to Login</a>";
} catch (PDOException $e) {
    echo "Error resetting admin password: " . $e->getMessage();
}
?>
