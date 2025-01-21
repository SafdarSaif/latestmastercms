<?php

if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $footer_information = mysqli_real_escape_string($conn, $_POST['footer_information']);
  $meta_title = isset($_POST['meta_title']) ? mysqli_real_escape_string($conn, $_POST['meta_title']) : null;
  $meta_key = isset($_POST['meta_key']) ? mysqli_real_escape_string($conn, $_POST['meta_key']) : null;
  $meta_description = isset($_POST['meta_description']) ? mysqli_real_escape_string($conn, $_POST['meta_description']) : null;

  $logo_filename = "/admin-assets/img/default-logo.jpg";
  if (isset($_FILES['logo']) && $_FILES['logo']['name']) {
    $logo_filename = uploadImage($conn, "logo", "theme-settings");
  }

  $fav_icon_filename = "/admin-assets/img/default-favicon.ico";
  if (isset($_FILES['fav_icon']) && $_FILES['fav_icon']['name']) {
    $fav_icon_filename = uploadImage($conn, "fav_icon", "theme-settings");
  }

  if (empty($name)) {
    echo json_encode(['status' => 403, 'message' => 'Theme name is mandatory!']);
    exit();
  }

  if (empty($footer_information)) {
    echo json_encode(['status' => 403, 'message' => 'Footer information is mandatory!']);
    exit();
  }

  $check = $conn->query("SELECT ID FROM theme_settings WHERE Name LIKE '$name'");
  if ($check !== false && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => "$name already exists!"]);
    exit();
  }

  $add = $conn->query("
        INSERT INTO `theme_settings`(`Name`, `Logo`, `Fav_Icon`, `Footer_Information`, `Meta_Title`, `Meta_Key`, `Meta_Description`) 
        VALUES ('$name', '$logo_filename', '$fav_icon_filename', '$footer_information', '$meta_title', '$meta_key', '$meta_description')
    ");

  if ($add) {
    echo json_encode(['status' => 200, 'message' => "$name settings saved successfully!"]);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
