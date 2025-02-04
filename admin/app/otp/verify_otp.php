<?php
session_start();

// Debugging: Check if session is set
if (!isset($_SESSION['otp'])) {
    echo json_encode(["status" => 'error', "message" => "Session expired or OTP not set"]);
    exit;
}

header('Content-Type: application/json');

// Debugging: Print session data
error_log("Session OTP: " . $_SESSION['otp']); 
error_log("Posted OTP: " . $_POST['otp']); 



// Check if OTP is provided and not empty
if (empty($_POST['otp'])) {
    echo json_encode(["status" => false, "message" => "OTP is required"]);
    exit;
}

$otp = trim($_POST['otp']); 

if ((string) $_SESSION['otp'] === (string) $otp) {
    echo json_encode(["status" => '200', "message" => "OTP matched successfully"]);

} else {
    echo json_encode(["status" => false, "message" => "Invalid OTP"]);
}
?>
