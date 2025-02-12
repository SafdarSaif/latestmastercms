<?php
session_start();

include '../../includes/db-config.php';
// header('Content-Type: application/json');

$countSql = "SELECT COUNT(*) AS total_leads FROM leads";
$countResult = mysqli_query($conn, $countSql);
$countData = mysqli_fetch_assoc($countResult);
$totalLeads = $countData['total_leads'];

// Get the latest 5 leads
$sql = "SELECT Name, Email, Status, Created_At AS Date FROM leads ORDER BY ID DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

$leads = [];
while ($row = mysqli_fetch_assoc($result)) {
    $leads[] = $row;
}

$response = [
    'total_leads' => $totalLeads,
    'leads' => $leads
];

echo json_encode($response);
?>
