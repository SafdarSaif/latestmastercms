<?php
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $database = "knowledge_nest";
// $conn = mysqli_connect("$hostname", "$username", "$password", "$database");
// include('config.php');


// Master CMS
// $host = $_SERVER['HTTP_HOST'];
// // print_r($host);
// $domainParts = explode('.', $host);
// // print_r($domainParts);

// $subdomain = isset($domainParts[0]) ? $domainParts[0] : '';

// // print_r($subdomain);

// $subdomain = "rudraeducation";

$subdomain = "";    

// Default database credentials.
$hostname = "localhost";



if ($subdomain) {
  if ($subdomain === 'rudradigital') {
    $username = "root";
    $password = "";
    $database = "rudra_db";
  } elseif ($subdomain === 'rudraeducation') {
    $username = "root";
    $password = "";
    $database = "hims_db";
  }
} else {
  $username = "root";
  $password = "";
  $database = "master_new_db";
}

$conn = mysqli_connect($hostname, $username, $password, $database);



include('config.php');
