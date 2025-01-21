<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name); 
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $position = intval($_POST['position']);
    $heading_setting_id = intval($_POST['heading_setting_id']);
    
    $dependency_setting_id = isset($_POST['dependency_setting_id']) && !empty($_POST['dependency_setting_id']) 
        ? intval($_POST['dependency_setting_id']) 
        : 0;
        
    $dependency_parent_id = intval($_POST['dependency_parent_id']);
    $status = 1;

    if ($_FILES["photo"]["name"]) {
        $filename = uploadImage($conn, "photo", "settingdata");
    } else {
        $filename = "/admin-assets/img/default-program.jpg";
    }
    
    if (empty($name)) {
        echo json_encode(['status' => 403, 'message' => 'Name is mandatory!']);
        exit();
    }

    // $check = $conn->query("SELECT ID FROM setting_data WHERE (Name like '$name')");
    $check = $conn->query("SELECT ID FROM setting_data WHERE Name = '$name' AND Heading_Setting_ID = $heading_setting_id");

    
    if ($check !== false && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    $query = "INSERT INTO setting_data 
        (Heading_Setting_ID, Dependency_Setting_ID, Dependency_Parent_ID, Name, Content, Position, Status, Slug, Photo)
        VALUES (
            $heading_setting_id, 
            $dependency_setting_id, 
            $dependency_parent_id, 
            '$name', 
            '$content', 
            $position, 
            $status, 
            '$slug',  
            '$filename' 
        )";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Setting saved successfully!']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Failed to save the setting: ' . mysqli_error($conn)]);
    }
}
?>
