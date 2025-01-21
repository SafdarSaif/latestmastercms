<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../includes/db-config.php';
require '../../../vendor/autoload.php';

session_start();

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $result = $conn->query("SELECT ID, Name, Short_Name FROM users WHERE Email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(20));
        $conn->query("UPDATE users SET reset_token = '$token', reset_requested_at = NOW() WHERE ID = " . $user['ID']);

        $resetLink = $_SERVER['HTTP_ORIGIN'] . "/admin/login-reset-password?token=$token";

        $subject = "Password Reset Request from {$user['Short_Name']}";
        $message = "
                  <!DOCTYPE html>
                  <html>
                  <head>
                  <style>
                     body {
                          font-family: Arial, sans-serif;
                          background-color: #ffffff;
                          margin: 0;
                          padding: 0;
                          color: #000000;
                          }
                         .email-container {
                          max-width: 600px;
                          margin: 20px auto;
                          background: #ffffff;
                          border: 1px solid #ddd;
                          border-radius: 8px;
                          overflow: hidden;
                          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                          }
                         .header {
                          background-color: #ffffff;
                          color: #000000;
                          padding: 20px;
                          text-align: center;
                          font-size: 24px;
                          font-weight: bold;
                         }
                        .content {
                         padding: 20px;
                         color: #000000;
                        }
                        .content p {
                        line-height: 1.6;
                        margin: 10px 0;
                        }
                       .button {
                        display: inline-block;
                        background-color: #ffffff;
                        color: #000000;
                        padding: 12px 20px;
                        text-decoration: none;
                        font-size: 16px;
                        border-radius: 4px;
                        margin-top: 20px;
                        }
                       .button:hover {
                       background-color: #444444;
                         }
                      .footer {
                       font-size: 12px;
                       color: #000000;
                       text-align: center;
                       padding: 10px 20px;
                       background-color: #ffffff;
                       border-top: 1px solid #ddd;
                        }
                     .footer a {
                      color: #000000;
                      text-decoration: underline;
                       }
           </style>
</head>
<body>
    <div class='email-container'>
        <div class='header'>
            Password Reset Request
        </div>
        <div class='content'>
            <p>Dear {$user['Name']},</p>
            <p>We received a request to reset your password for your account. To ensure the security of your account, we have generated a unique password reset link for you.</p>
            <p>Please click the button below to reset your password:</p>
            <p><a href='$resetLink' class='button'>Reset Password</a></p>
            <p>This link is valid for one use only and will expire in 1 hour. If you did not request a password reset, please ignore this email or contact us immediately at <a href='mailto:support@yourdomain.com'>support@yourdomain.com</a>.</p>
        </div>
        <div class='footer'>
            <p>This is a system-generated email. Please do not reply to this email.</p>
            <p>&copy; " . date('Y') . " YourDomain. All rights reserved.</p>
        </div>
    </div>
</body>
</html>";



        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'safdarali.cse@gmail.com';
            $mail->Password = 'ysgz keis ebza cgda';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('noreply@yourdomain.com', 'No Reply');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);

            $mail->send();
            echo json_encode(['status' => 200, 'message' => 'Password reset email sent.', 'url' => '/admin/login']);
        } catch (Exception $e) {
            echo json_encode(['status' => 500, 'message' => 'Failed to send email. Mailer Error: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status' => 404, 'message' => 'Email not found.']);
    }
} else {
    echo json_encode(['status' => 400, 'message' => 'Bad request.']);
}
