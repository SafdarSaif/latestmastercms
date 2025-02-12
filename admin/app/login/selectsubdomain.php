<?php
session_start();

if (isset($_POST['subdomain'])) {
    $_SESSION['selected_database'] = $_POST['subdomain'];

    echo "Database selected successfully.";
} else {
    echo "No database selected.";
}
?>