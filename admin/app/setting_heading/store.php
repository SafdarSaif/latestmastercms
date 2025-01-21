<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name);
    // $category = mysqli_real_escape_string($conn, $_POST['category']);
    // $date = mysqli_real_escape_string($conn, $_POST['date']);
    // $media_type = mysqli_real_escape_string($conn, $_POST['media_type']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_key = mysqli_real_escape_string($conn, $_POST['meta_key']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $position = intval($_POST['position']);

    // File handling
    // $filename = '';
    // if ($media_type === 'upload' && isset($_FILES['media_file'])) {
    //     $filename = uploadImage($conn, "media_file", "wings");
    // } elseif ($media_type === 'link' && isset($_POST['media_link'])) {
    //     $filename = mysqli_real_escape_string($conn, $_POST['media_link']);
    // }

    // Validate mandatory fields
    if (empty($name)   || empty($content) || empty($position)) {
        echo json_encode(['status' => 403, 'message' => 'All required fields must be filled out!']);
        exit();
    }

    $checkQuery = $conn->query("SELECT ID FROM setting_headings WHERE Name = '$name'");
    if ($checkQuery !== false && $checkQuery->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    $query = "INSERT INTO setting_headings 
              (`Name`, `Slug`, `Content`, `Meta_Title`, `Meta_Key`, `Meta_Description`, `Position`, `Created_At`) 
              VALUES ('$name', '$slug', '$content', '$meta_title', '$meta_key', '$meta_description', '$position', NOW())";

    if ($conn->query($query)) {
        echo json_encode(['status' => 200, 'message' => $name . ' added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Failed to add ' . $name . '!']);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Invalid request method!']);

    
}
