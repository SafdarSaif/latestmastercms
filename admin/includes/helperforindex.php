<?php
function getTotalActiveUsers($conn) {
    $sql = "SELECT COUNT(*) as total FROM users WHERE status = 1";
    return fetchSingleValue($conn, $sql);
}

function getTotalPages($conn) {
    $sql = "SELECT COUNT(*) as total FROM pages";
    return fetchSingleValue($conn, $sql);
}

function getStorageUsed($conn) {
    $sql = "SELECT SUM(size) as total FROM gallery_video";
    return fetchSingleValue($conn, $sql) . ' MB';
}

function getRecentLeads($conn) {
    $sql = "SELECT COUNT(*) as total FROM leads WHERE created_at >= NOW() - INTERVAL 7 DAY";
    return fetchSingleValue($conn, $sql);
}

function getRecentActivities($conn) {
    $sql = "SELECT description, type, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 5";
    return fetchMultipleRows($conn, $sql);
}

function getTrafficData($conn) {
    $sql = "SELECT visits FROM traffic_stats WHERE date >= NOW() - INTERVAL 7 DAY ORDER BY date";
    return fetchColumnArray($conn, $sql);
}

function getTrafficDates($conn) {
    $sql = "SELECT DATE_FORMAT(date, '%Y-%m-%d') FROM traffic_stats WHERE date >= NOW() - INTERVAL 7 DAY ORDER BY date";
    return fetchColumnArray($conn, $sql);
}

/**
 * Generic function to fetch a single value from the database.
 */
function fetchSingleValue($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row['total'] : 0;
}

/**
 * Generic function to fetch multiple rows from the database.
 */
function fetchMultipleRows($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

/**
 * Generic function to fetch a column as an array.
 */
function fetchColumnArray($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_row($result)) {
        $data[] = $row[0];
    }
    return $data;
}
?>
