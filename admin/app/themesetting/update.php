<?php
if (isset($_POST['name']) && isset($_POST['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';

  session_start();

  $id = intval($_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $footer_information = mysqli_real_escape_string($conn, $_POST['footer_information']);
  $meta_title = isset($_POST['meta_title']) ? mysqli_real_escape_string($conn, $_POST['meta_title']) : null;
  $meta_key = isset($_POST['meta_key']) ? mysqli_real_escape_string($conn, $_POST['meta_key']) : null;
  $meta_description = isset($_POST['meta_description']) ? mysqli_real_escape_string($conn, $_POST['meta_description']) : null;
  $updated_logo = mysqli_real_escape_string($conn, $_POST['updated_logo']);
  $updated_fav_icon = mysqli_real_escape_string($conn, $_POST['updated_favicon']);

  // Handle Logo upload
  if (isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"] != '') {
    $logo = uploadImage($conn, "logo", "theme-settings");
  } else {
    $logo = $updated_logo;
  }

  // Handle Favicon upload
  if (isset($_FILES["fav_icon"]["name"]) && $_FILES["fav_icon"]["name"] != '') {
    $fav_icon = uploadImage($conn, "fav_icon", "theme-settings");
  } else {
    $fav_icon = $updated_fav_icon;
  }

  // Check for existing name (excluding current ID)
  $check = $conn->query("SELECT ID FROM theme_settings WHERE (Name LIKE '$name') AND ID <> $id");
  if ($check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }

  // Update the theme settings
  $update = $conn->query("
    UPDATE `theme_settings` 
    SET 
      `Name` = '$name',
      `Logo` = '$logo',
      `Fav_Icon` = '$fav_icon',
      `Footer_Information` = '$footer_information',
      `Meta_Title` = '$meta_title',
      `Meta_Key` = '$meta_key',
      `Meta_Description` = '$meta_description'
    WHERE ID = $id
  ");

  if ($update) {
    echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
