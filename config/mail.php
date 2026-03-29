<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

function sendMail($pdo, $to_email, $subject, $message, $headers_custom = '') {
    // Fetch SMTP settings from DB
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    $smtp_host = $settings['smtp_host'] ?? 'localhost';
    $smtp_port = $settings['smtp_port'] ?? '587';
    $smtp_user = $settings['smtp_username'] ?? '';
    $smtp_pass = $settings['smtp_password'] ?? '';
    $smtp_enc = $settings['smtp_encryption'] ?? 'tls';
    $from_email = $settings['smtp_from_email'] ?? 'noreply@nexplay.local';
    $from_name = $settings['smtp_from_name'] ?? 'NexPlay Hub';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = !empty($smtp_user);
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->Port       = (int)$smtp_port;
        
        $smtp_enc = strtolower($smtp_enc);
        if ($smtp_enc === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ($smtp_enc === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPAutoTLS = false;
            $mail->SMTPSecure = '';
        }

        // Recipients
        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($to_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);
        
        // Timeout fix for slow servers
        $mail->Timeout = 10;

        return $mail->send();
    } catch (Exception $e) {
        // Error logging into PHP's native error.log rather than disrupting the user UI
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
