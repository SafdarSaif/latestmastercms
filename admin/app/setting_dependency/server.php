<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Parent_ID, Child_ID,  Status, Created_At FROM setting_dependency ORDER BY ID ASC ";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;

  $parent_id = $row['Parent_ID'];
  $parentQuery = $conn->query("SELECT Name FROM setting_headings WHERE ID = $parent_id");
  $parentArr = $parentQuery->fetch_assoc();

  $child_id = $row['Child_ID'];
  $childQuery = $conn->query("SELECT Name FROM setting_headings WHERE ID = $child_id");
  $childArr = $childQuery->fetch_assoc();
  


  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Parent_Name" => $parentArr["Name"],
    "Child_Name" => $childArr["Name"],
    // "Description"=> $destext,
    // "Photo"=>$row['Media_File'],
    "Status" => $row["Status"],
    "Created_At" => $row["Created_At"],
  );
}
// echo "<pre>";
// print_r($data);
// echo "</pre>";

echo json_encode(['data' => $data]);
?>