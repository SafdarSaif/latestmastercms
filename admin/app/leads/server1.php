<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Email, Mobile, Address,Type, Created_At FROM leads ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
 
   
  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Name" => $row["Name"],
    "Phone" => $row["Mobile"],
    "Email" => $row['Email'],
    "State" => $row['Address'],
    "Type" => $row['Type'],
    // "Sector" => $sectorArr['Name'],
    // "Course" => $courseArr['Name'],
    "Created_At" => $row["Created_At"],
  );
}

echo json_encode(['data' => $data]);
