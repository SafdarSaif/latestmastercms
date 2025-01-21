<?php
// if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id'])) {
//   require '../../includes/db-config.php';
//   session_start();

//   $id = mysqli_real_escape_string($conn, $_GET['id']);

//   $check = $conn->query("SELECT ID FROM blogs WHERE ID = $id");
//   if ($check->num_rows > 0) {
//     $delete = $conn->query("DELETE FROM blogs WHERE ID = $id");
//     if ($delete) {
//       echo json_encode(['status' => 200, 'message' => 'Blogs deleted successfully!']);
//     } else {
//       echo json_encode(['status' => 302, 'message' => 'Something went wrong!']);
//     }
//   } else {
//     echo json_encode(['status' => 302, 'message' => 'Blogs not exists!']);
//   }
// }
if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id']) && is_numeric($_GET['id'])) {
  require '../../includes/db-config.php';
  session_start();

  $id = intval($_GET['id']); 

  $check = $conn->query("SELECT ID FROM theme_settings WHERE ID = $id");
  if ($check->num_rows > 0) {
    $delete = $conn->query("DELETE FROM theme_settings WHERE ID = $id");
    if ($delete) {
      echo json_encode(['status' => 200, 'message' => 'Theme Setting deleted successfully!']);
    } else {
      echo json_encode(['status' => 302, 'message' => 'Something went wrong!']);
    }
  } else {
    echo json_encode(['status' => 302, 'message' => 'Theme Setting does not exist!']);
  }
} else {
  echo json_encode(['status' => 400, 'message' => 'Invalid request!']);
}
