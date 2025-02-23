<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

$contact = $data->contact;
$otp = rand(100000, 999999);
session_start();
$_SESSION["otp"] = $otp;

// Send OTP via email (Use SMTP like PHPMailer)
$subject = "Your OTP Code";
$message = "Your OTP code is: $otp";
$headers = "From: noreply@yourwebsite.com";

if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
    mail($contact, $subject, $message, $headers);
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
