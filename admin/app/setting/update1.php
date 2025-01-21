<?php
require '../../includes/db-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $editID = intval($_POST['id']); 
    $heading_setting_id = intval($_POST['heading_setting_id']);
    $dependency_parent_id = intval($_POST['dependency_parent_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dependency_setting_id = isset($_POST['dependency_setting_id']) ? intval($_POST['dependency_setting_id']) : null;
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $position = intval($_POST['position']);

    // Validate required fields
    if (empty($name) || empty($content) || empty($position)) {
        echo json_encode(['status' => 400, 'message' => 'All required fields must be filled out.']);
        exit;
    }

    // Check if the ID exists
    $checkQuery = "SELECT ID FROM setting_data WHERE ID = $editID";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
        echo json_encode(['status' => 404, 'message' => 'Setting not found.']);
        exit;
    }

    // Update query
    $query = "UPDATE setting_data 
              SET 
                Name = '$name', 
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
?>
