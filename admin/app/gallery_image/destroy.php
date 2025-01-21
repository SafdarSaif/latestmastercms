<?php
// if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id'])) {
//   require '../../includes/db-config.php';
//   session_start();

//   $id = mysqli_real_escape_string($conn, $_GET['id']);

//   $check = $conn->query("SELECT id FROM gallery_image WHERE id = $id");
//   if ($check->num_rows > 0) {
//     $delete = $conn->query("DELETE FROM gallery_image WHERE id = $id");
//     if ($delete) {
//       echo json_encode(['status' => 200, 'message' => 'gallery image deleted successfully!']);
//     } else {
//       echo json_encode(['status' => 302, 'message' => 'Something went wrong!']);
//     }
//   } else {
//     echo json_encode(['status' => 302, 'message' => 'gallery not exists!']);
//   }
// }


if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id'])) {
  require '../../includes/db-config.php';
  session_start();

  // Sanitize the input ID
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // Fetch the image URL associated with the record
  $check = $conn->query("SELECT image_url FROM gallery_image WHERE id = $id");
  if ($check && $check->num_rows > 0) {
      $row = $check->fetch_assoc();
      $photoPaths = $row['image_url'];

      // Split the comma-separated image paths into an array
      $imagePaths = explode(', ', $photoPaths);

      // Delete the record from the database
      $delete = $conn->query("DELETE FROM gallery_image WHERE id = $id");
      if ($delete) {
          $allDeleted = true; // Track if all images are successfully deleted

          // Loop through each image path and delete the file
          foreach ($imagePaths as $path) {
              $fullPath = "../../" . ltrim($path, "/");
              if ($path && file_exists($fullPath)) {
                  if (!unlink($fullPath)) {
                      $allDeleted = false;
                      error_log("Failed to delete file: $fullPath");
                  }
              }
          }

          if ($allDeleted) {
              echo json_encode(['status' => 200, 'message' => 'Gallery image deleted successfully, and all associated photos removed!']);
          } else {
              echo json_encode(['status' => 200, 'message' => 'Gallery image deleted, but some photos could not be removed!']);
          }
      } else {
          echo json_encode(['status' => 302, 'message' => 'Something went wrong while deleting the record!']);
      }
  } else {
      echo json_encode(['status' => 302, 'message' => 'Gallery image does not exist!']);
  }
} else {
  echo json_encode(['status' => 400, 'message' => 'Invalid request!']);
}
