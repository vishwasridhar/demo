<?php
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate reset token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store token in database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $stmt->execute([$token, $expiry, $email]);

        // Send email (using mail function)
        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password: \n\n$resetLink";
        mail($email, $subject, $message, "From: no-reply@yourwebsite.com");

        echo "Check your email for the reset link.";
    } else {
        echo "Email not found!";
    }
}
?>
