<?php
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token is valid
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Invalid or expired token!");
    }
} else {
    die("No token provided!");
}
?>

<form method="post" action="update_password.php">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <input type="password" name="new_password" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
</form>
