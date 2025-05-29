<?php
// Error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// session_start();

$host = $_SERVER['HTTP_HOST'];
$domainParts = explode('.', $host);
$subdomain = isset($domainParts[0]) ? $domainParts[0] : '';

$subdomains = [
  "newtheme" => [
    "username" => "root",
    "password" => "",
    "database" => "master_new_db",
    "label" => "Edtech CMS"
  ],
  "oldtheme" => [
    "username" => "root",
    "password" => "",
    "database" => "arni",
    "label" => "Old Theme CMS"
  ],
  "jvnscms" => [
    "username" => "root",
    "password" => "",
    "database" => "jvns_db",
    "label" => "JVN CMS"
  ],
  "prakriticms" => [
    "username" => "root",
    "password" => "",
    "database" => "prakriti_db",
    "label" => "Prakriti CMS"
  ]
];

// Default connection details
$username = "root";
$password = "";
$database = "master_db";
// Check if a subdomain is selected in session
if (isset($_SESSION['selected_database']) && !empty($_SESSION['selected_database'])) {


  if (array_key_exists('selected_database', $_SESSION)) {
    $selectedDatabase = $_SESSION['selected_database'];
    $username = $subdomains[$selectedDatabase]["username"];
    $password = $subdomains[$selectedDatabase]["password"];
    $database = $subdomains[$selectedDatabase]["database"];
    
  } else {
    if ($subdomain && isset($subdomains[$subdomain])) {
      $username = $subdomains[$subdomain]["username"];
      $password = $subdomains[$subdomain]["password"];
      $database = $subdomains[$subdomain]["database"];
    }
  }
} else {
  // Default connection for the root domain or if no session is selected
  if ($subdomain && isset($subdomains[$subdomain])) {
    $username = $subdomains[$subdomain]["username"];
    $password = $subdomains[$subdomain]["password"];
    $database = $subdomains[$subdomain]["database"];
  }
}

$hostname = "localhost";
$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

include('config.php');
