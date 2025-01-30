<?php
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Include the database configuration
include '../../includes/db-config.php';

$typeFilter = isset($_GET['typeFilter']) ? $_GET['typeFilter'] : '';

$query = "SELECT ID, Name, Email, Mobile, Created_At FROM leads";

if (!empty($typeFilter)) {
    $query .= " WHERE Type = '" . mysqli_real_escape_string($conn, $typeFilter) . "'";
}

$query .= " ORDER BY ID ASC";

$results = mysqli_query($conn, $query);

if (!$results) {
    die('Error executing query: ' . mysqli_error($conn));
}

$data = array();
$i = 1; 

while ($row = mysqli_fetch_assoc($results)) {
    $data[] = array(
        "No" => $i++, 
        "Name" => $row["Name"],
        "Phone" => $row["Mobile"],
        "Email" => $row['Email'],
        "Created_At" => $row["Created_At"]
    );
}

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers for the spreadsheet
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('C1', 'Name');
$sheet->setCellValue('D1', 'Phone');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'Created At');

// Set column widths
$sheet->getColumnDimension('A')->setWidth(5); 
$sheet->getColumnDimension('C')->setWidth(20); 
$sheet->getColumnDimension('D')->setWidth(15); 
$sheet->getColumnDimension('E')->setWidth(25); 
$sheet->getColumnDimension('F')->setWidth(20); 

// Populate data into the spreadsheet
$rowNum = 2; 
foreach ($data as $item) {
    $sheet->setCellValue('A' . $rowNum, $item['No']);
    $sheet->setCellValue('C' . $rowNum, $item['Name']);
    $sheet->setCellValue('D' . $rowNum, $item['Phone']);
    $sheet->setCellValue('E' . $rowNum, $item['Email']);
    $sheet->setCellValue('F' . $rowNum, $item['Created_At']);
    $rowNum++;
}

// Set filename for the downloaded file
$filename = 'leads_' . date('Y-m-d_H-i-s') . '.xlsx';

// Set headers to prompt the browser to download the file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write the spreadsheet to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
mysqli_close($conn);
exit();
?>
