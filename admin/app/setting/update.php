<?php
if (isset($_POST['name']) && isset($_POST['id'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';

    session_start();

    $editID = intval($_POST['id']);
    $heading_setting_id = intval($_POST['heading_setting_id']);
    $dependency_parent_id = intval($_POST['dependency_parent_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name);
    $dependency_setting_id = isset($_POST['dependency_setting_id']) ? intval($_POST['dependency_setting_id']) : 0;
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $position = intval($_POST['position']);
    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

    if(isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"]!=''){ 
      $photo = uploadImage($conn,"photo","settingdata");
    }else{
      $photo = $updated_file;
    }

    if (empty($name) || empty($content) || empty($position)) {
        echo json_encode(['status' => 400, 'message' => 'All required fields must be filled out.']);
        exit;
    }

    $checkQuery = "SELECT ID FROM setting_data WHERE ID = $editID";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
        echo json_encode(['status' => 404, 'message' => 'Setting not found.']);
        exit;
    }

    $query = "UPDATE setting_data 
                SET 
                Name = '$name',
                Slug = '$slug',
                Photo ='$photo', 
                Dependency_Setting_ID = " . ($dependency_setting_id !== null ? $dependency_setting_id : "NULL") . ", 
                Dependency_Parent_ID = $dependency_parent_id, 
                Content = '$content', 
                Position = $position, 
                Updated_At = NOW() 
                WHERE ID = $editID AND Heading_Setting_ID = $heading_setting_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Setting updated successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Failed to update setting. ' . mysqli_error($conn)]);
    }
    exit;
}
