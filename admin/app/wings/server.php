<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Wing_Heading_ID, Media_File, Status, Created_At FROM wings ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;

  $categories_id = $row['Wing_Heading_ID'];
  $categoryQuery = $conn->query("SELECT Name FROM wings_heading WHERE ID = $categories_id");
  $categoryArr = $categoryQuery->fetch_assoc();
  


  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Category" => $categoryArr["Name"],
    "Name" => $row["Name"],
    "Photo"=>$row['Media_File'],
    "Status" => $row["Status"],
    "Created_At" => $row["Created_At"],
  );
}
// echo "<pre>";
// print_r($data);
// echo "</pre>";

echo json_encode(['data' => $data]);
?>