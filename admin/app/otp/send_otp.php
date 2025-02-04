<?php
session_start();
require '../../includes/db-config.php';
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $query = "SELECT ID FROM users WHERE Email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $otp = rand(100000, 999999); 
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        
        // Send OTP via email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'safdarali.cse@gmail.com';
            $mail->Password = 'ysgz keis ebza cgda'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('your-email@gmail.com', 'Master Admin');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Your OTP for Password Reset";
            $mail->Body = "Your OTP code is <b>$otp</b>. Enter this code to reset your password.";

            if ($mail->send()) {
                echo json_encode(['status' => '200', 'message' => 'OTP sent successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not found']);
    }
}
?>
