<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// Include database configuration
include '../../includes/db-config.php';
include 'process.php';

$Process = new Process($conn);
$method = $_GET['method'];

if ($method == 'getTestimonials') {
    $Process->getTestimonials();
}

if ($method == 'getBlogs') {
    $Process->getBlogs();
}

if ($method == 'getGalleryImages') {
    $Process->getGalleryImages();
}
if ($method == 'getevents') {
    $Process->getevents();
}
if ($method == 'getAnnouncement') {
    $Process->getAnnouncement();
}
if ($method == 'storeLeads') {
    $Process->storeLeads();
}
?>
