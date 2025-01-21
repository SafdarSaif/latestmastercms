<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    $hierarchy = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'heading_') === 0 && !empty($value)) {
            $childID = str_replace('heading_', '', $key);
            $parentID = $value;
            $hierarchy[$childID] = $parentID;
        }
    }

    ksort($hierarchy);

    $dependencies = [];
    $previousID = null;

    foreach ($hierarchy as $childID => $parentID) {
        if ($previousID !== null) {
            $dependencies[] = [
                'Parent_ID' => $previousID,
                'Child_ID' => $childID
            ];
        }
        $previousID = $childID;
    }

    if (empty($dependencies)) {
        echo json_encode(['status' => 400, 'message' => 'No valid dependencies selected!']);
        exit();
    }

    $insertQuery = "INSERT INTO setting_dependency (`Parent_ID`, `Child_ID`, `Status`, `Created_At`) VALUES ";
    $insertValues = [];

    foreach ($dependencies as $dependency) {
        $insertValues[] = "('" . mysqli_real_escape_string($conn, $dependency['Parent_ID']) . "', '" . mysqli_real_escape_string($conn, $dependency['Child_ID']) . "', 1, NOW())";
    }

    $insertQuery .= implode(', ', $insertValues);

    if ($conn->query($insertQuery)) {
        echo json_encode(['status' => 200, 'message' => 'Dependencies added successfully!']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Failed to add dependencies!', 'error' => $conn->error]);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Invalid request method!']);
}
