<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    // Fetch and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name);
    $category = mysqli_real_escape_string($conn, $_POST['wing_heading']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $media_type = mysqli_real_escape_string($conn, $_POST['media_type']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_key = mysqli_real_escape_string($conn, $_POST['meta_key']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $position = intval($_POST['position']);

    // File handling
    $filename = '';
    if ($media_type === 'upload' && isset($_FILES['media_file'])) {
        $filename = uploadImage($conn, "media_file", "wings");
    } elseif ($media_type === 'link' && isset($_POST['media_link'])) {
        $filename = mysqli_real_escape_string($conn, $_POST['media_link']);
    }

    // Validate mandatory fields
    if (empty($name) || empty($category) || empty($date) || empty($media_type) || empty($content) || empty($position)) {
        echo json_encode(['status' => 403, 'message' => 'All required fields must be filled out!']);
        exit();
    }

    // Check if name already exists
    $checkQuery = $conn->query("SELECT ID FROM wings WHERE Name = '$name'");
    if ($checkQuery !== false && $checkQuery->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    // Insert into the database
    $query = "INSERT INTO wings 
              (`Name`, `Slug`, `Wing_Heading_ID`, `Date`, `Media_Type`, `Media_File`, `Content`, `Meta_Title`, `Meta_Key`, `Meta_Description`, `Position`, `Created_At`) 
              VALUES ('$name', '$slug', '$category', '$date', '$media_type', '$filename', '$content', '$meta_title', '$meta_key', '$meta_description', '$position', NOW())";

    if ($conn->query($query)) {
        echo json_encode(['status' => 200, 'message' => $name . ' added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Failed to add ' . $name . '!']);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Invalid request method!']);
}
