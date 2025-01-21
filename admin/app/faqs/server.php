<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Question, Answer, Status, Created_At FROM faqs ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;


  if(strlen($row['Question']) > 20){
    $questiontext = substr($row['Question'], 0, 20) . "...";
  }else{
    $destext = $row['Question'];
  }
  if(strlen($row['Answer']) > 20){
    $destext = substr($row['Answer'], 0, 20) . "...";
  }else{
    $destext = $row['Answer'];
  }

 
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['ID'],
        "Questions"=> $questiontext,
        "Answers"=>  $destext,
        // "Images"=>$imageUrls,
        "Status" => $row["Status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

