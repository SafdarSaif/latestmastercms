<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $query = "SELECT * FROM setting_dependency WHERE Status = 1";
  $result = $conn->query($query);
  $existingDependencies = [];
  while ($row = $result->fetch_assoc()) {
    $existingDependencies[$row['Child_ID']] = $row['Parent_ID'];
  }

  $hierarchy = [];
  foreach ($_POST as $key => $value) {
    if (strpos($key, 'heading_') === 0 && !empty($value)) {
      $childID = str_replace('heading_', '', $key);
      $parentID = $value;
      $hierarchy[$childID] = $parentID;
    }
  }

  ksort($hierarchy);

  foreach ($hierarchy as $childID => $parentID) {
    if (isset($existingDependencies[$childID]) && $existingDependencies[$childID] != $parentID) {
      $updateQuery = "UPDATE setting_dependency 
                            SET Parent_ID = '" . mysqli_real_escape_string($conn, $parentID) . "', 
                                Updated_At = NOW() 
                            WHERE Child_ID = '" . mysqli_real_escape_string($conn, $childID) . "'";
      if (!$conn->query($updateQuery)) {
        echo json_encode(['status' => 500, 'message' => 'Failed to update dependencies!', 'error' => $conn->error]);
        exit();
      }
    }
  }

  echo json_encode(['status' => 200, 'message' => 'Dependencies updated successfully!']);
} else {
  echo json_encode(['status' => 405, 'message' => 'Invalid request method!']);
}
