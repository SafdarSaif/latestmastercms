<?php
include '../../includes/db-config.php';
session_start();

$typeFilter = isset($_POST['typeFilter']) ? $_POST['typeFilter'] : '';

$query = "SELECT ID, Name, Email, Mobile, Address, Type, Created_At FROM leads";
if ($typeFilter != '') {
    $query .= " WHERE Type = '" . mysqli_real_escape_string($conn, $typeFilter) . "'";
}
$query .= " ORDER BY ID DESC";

$results = mysqli_query($conn, $query);
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
        "Created_At" => $row["Created_At"],
    );
}

echo json_encode(['data' => $data]);
?>
