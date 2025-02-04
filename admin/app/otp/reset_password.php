<?php
session_start();
include '../../includes/db-config.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    // print_r($_SESSION);  

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['password'])) {
            $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

            if (empty($newPassword)) {
                echo json_encode(["success" => false, "message" => "Password cannot be empty"]);
                exit();
            }

            $encryptionKey = '60ZpqkOnqn0UQQ2MYTlJ';
            $encryptedPassword = "AES_ENCRYPT('$newPassword', '$encryptionKey')";

            $query = "UPDATE users SET Password=$encryptedPassword WHERE Email='$email'";

            if (mysqli_query($conn, $query)) {
                echo json_encode(["status" => '200', "message" => "Password reset successfully"]);
            } else {
                echo json_encode(["status" => false, "message" => "Password reset failed"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Password is required"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
    }
} else {
    // If email is not found in session, show error
    echo json_encode(["success" => false, "message" => "User not logged in"]);
}
