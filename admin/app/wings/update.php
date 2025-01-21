<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $id = intval($_POST['id']);
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
  $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

  $filename = $updated_file;

  if ($media_type === 'upload' && isset($_FILES['media_file']['name']) && $_FILES['media_file']['name'] !== '') {
    $uploadedFile = uploadImage($conn, "media_file", "wings");
    if ($uploadedFile) {
      $filename = $uploadedFile;
      if (!empty($updated_file) && file_exists("../../" . ltrim($updated_file, "/"))) {
        unlink("../../" . ltrim($updated_file, "/"));
      }
    } else {
      echo json_encode(['status' => 400, 'message' => 'Failed to upload media file.']);
      exit();
    }
  } elseif ($media_type === 'link' && isset($_POST['media_link'])) {
    $filename = mysqli_real_escape_string($conn, $_POST['media_link']);
  }

  if (empty($id) || empty($name) || empty($category) || empty($date) || empty($media_type) || empty($content) || empty($position)) {
    echo json_encode(['status' => 403, 'message' => 'All required fields must be filled out!']);
    exit();
  }

  $checkQuery = $conn->query("SELECT ID FROM wings WHERE Name = '$name' AND ID != $id");
  if ($checkQuery !== false && $checkQuery->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }


  $updateQuery = "UPDATE wings SET 
                        `Name` = '$name',
                        `Slug` = '$slug',
                        `Wing_Heading_ID` = '$category',
                        `Date` = '$date',
                        `Media_Type` = '$media_type',
                        `Media_File` = '$filename',
                        `Content` = '$content',
                        `Meta_Title` = '$meta_title',
                        `Meta_Key` = '$meta_key',
                        `Meta_Description` = '$meta_description',
                        `Position` = '$position',
                        `Updated_At` = NOW()
                        WHERE `ID` = $id";

  if ($conn->query($updateQuery)) {
    echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Failed to update ' . $name . '!']);
  }
} else {
  echo json_encode(['status' => 405, 'message' => 'Invalid request method!']);
}
