<?php
## Database configuration
include '../../includes/db-config.php';
session_start();

$ID = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : 0;


## Fetch records
$result_record = "SELECT ID, Name, Heading_Setting_ID, Dependency_Setting_ID, Dependency_Parent_ID, Photo, Status, Created_At FROM setting_data
                  WHERE Heading_Setting_ID = $ID
                  ORDER BY ID ASC ";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;


//   fetch setting heading
  $heading_setting = $row['Heading_Setting_ID'];
  $heading_settingQuery = $conn->query("SELECT Name FROM setting_headings WHERE ID = $heading_setting");
  $heading_settingArr = $heading_settingQuery->fetch_assoc();
  $heading_setting_name = $heading_settingArr ? $heading_settingArr["Name"] : 'Unknown';


  //   fetch setting dependency data 
  $dependency_id = $row['Dependency_Setting_ID'];
  $dependencyQuery = $conn->query("SELECT Name FROM setting_data WHERE ID = $dependency_id");
  $dependencyArr = $dependencyQuery->fetch_assoc();

  $dependency_name = $dependencyArr ? $dependencyArr["Name"] : 'Does not Depend';

  $heading_setting = $row['Heading_Setting_ID'];
  $heading_settingQuery = $conn->query("SELECT Name FROM setting_headings WHERE ID = $heading_setting");
  $heading_settingArr = $heading_settingQuery->fetch_assoc();
  $heading_setting_name = $heading_settingArr ? $heading_settingArr["Name"] : 'Unknown';

  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Name" => $row['Name'],
    "Module_Name" => $heading_setting_name,
    "Dependency_Name" => $dependency_name,
    "Parent_Name" => $row["Dependency_Parent_ID"],
    "Photo" => $row["Photo"],
    "Status" => $row["Status"],
    "Created_At" => $row["Created_At"],
  );
}

// echo "<pre>";
// print_r($data);
// echo "</pre>";

// Output the data as JSON
echo json_encode(['data' => $data]);
?>
