<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verify token
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Update password
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?");
        $stmt->execute([$new_password, $user['email']]);

        echo "Password has been reset successfully!";
    } else {
        echo "Invalid or expired token!";
    }
}
?>
