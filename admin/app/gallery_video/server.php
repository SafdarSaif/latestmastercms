<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT id, video_link, video,position, status, Created_At FROM gallery_video ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['id'],
        "Video" => $row["video_link"],
        "Upload_Video" => $row["video"],
        "Position" => $row["position"], 
        "Status" => $row["status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

