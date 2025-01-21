<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    // Collect form data
    $video_link = mysqli_real_escape_string($conn, $_POST['video_links']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    // Validate position
    $valid_positions = ['left', 'right'];
    if (!in_array($position, $valid_positions)) {
        echo json_encode(['status' => 400, 'message' => 'Invalid position selected!']);
        exit;
    }

    // Set default filename (for the case no video file is uploaded)
    $filename = "/admin-assets/img/default-program.jpg";

    // If a video file is uploaded, upload it and get the filename
    if ($_FILES["video_file"]["name"]) {
        $filename = uploadVideo($conn, "video_file", "gallery_videos");
    }

    // Insert data into the database
    $add = $conn->query("INSERT INTO gallery_video (video_link, video, position) 
                         VALUES ('$video_link', '$filename', '$position')");
    if ($add) {
        echo json_encode(['status' => 200, 'message' => 'Gallery Video added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Database insert failed!']);
    }
}
?>
