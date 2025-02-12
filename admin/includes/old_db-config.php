<?php
ini_set('display_errors', 1);

// Master CMS
$host = $_SERVER['HTTP_HOST'];
$domainParts = explode('.', $host);

$subdomain = isset($domainParts[0]) ? $domainParts[0] : '';

// print_r($subdomain);

// $subdomain = "newtheme";

// $subdomain = "";

$hostname = "localhost";



if ($subdomain) {
  if ($subdomain == 'newtheme') {
    $username = "root";
    $password = "";
    $database = "master_new_db";
  } elseif ($subdomain == 'oldtheme') {
    $username = "root";
    $password = "";
    $database = "prakriti_db";
  }
} else {
  $username = "root";
  $password = "";
  $database = "master_db";
}

$conn = mysqli_connect($hostname, $username, $password, $database);



include('config.php');

