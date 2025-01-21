<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  session_start();

  $id = intval($_POST['id']);
  $video = mysqli_real_escape_string($conn, $_POST['video_links']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);

  
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
  $update = $conn->query("UPDATE gallery_video SET video_link = '$video', video = '$filename', position = '$position' WHERE id = $id");
  if ($update) {
    echo json_encode(['status' => 200, 'message' => 'Gallery Video updated successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
?>
