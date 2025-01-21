<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $id = intval($_POST['id']);
    $gallery_id = intval($_POST['gallery_id']);
    $existing_images = isset($_POST['existing_images']) ? $_POST['existing_images'] : [];

    // Fetch current images from the database
    $query = $conn->query("SELECT image_url FROM gallery_image WHERE id = $id");
    $result = $query->fetch_assoc();
    $current_images = explode(', ', $result['image_url']);

    // Arrays to manage image URLs
    $updated_image_urls = [];
    $new_image_urls = [];

    // Process new images
    if (isset($_FILES['new_images'])) {
        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
            if (!empty($tmp_name) && is_uploaded_file($tmp_name)) {
                $target_dir = "../../uploads/";
                $unique_name = time() . '_' . $key . '_' . basename($_FILES['new_images']['name'][$key]);
                $target_file = $target_dir . $unique_name;

                // Move uploaded file to the target directory
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $new_image_urls[] = "/uploads/" . $unique_name;
                } else {
                    echo json_encode(['status' => 400, 'message' => 'Failed to upload one or more images!']);
                    exit();
                }
            }
        }
    }

    // Process existing images
    foreach ($existing_images as $index => $existing_image) {
        if (!empty($existing_image)) {
            if (isset($_FILES['new_images']['tmp_name'][$index]) && is_uploaded_file($_FILES['new_images']['tmp_name'][$index])) {
                // Remove the old image
                $image_path = $_SERVER['DOCUMENT_ROOT'] . $existing_image;
                if (file_exists($image_path) && $existing_image !== "/admin-assets/img/default-program.jpg") {
                    unlink($image_path);
                }

                // Add the corresponding new image URL
                $updated_image_urls[] = $new_image_urls[$index] ?? '';
                unset($new_image_urls[$index]);
            } else {
                $updated_image_urls[] = $existing_image;
            }
        }
    }

    // Append any remaining new images
    $all_image_urls = array_merge($updated_image_urls, $new_image_urls);

    // Identify and delete removed images
    $removed_images = array_diff($current_images, $all_image_urls);
    foreach ($removed_images as $removed_image) {
        $image_path = $_SERVER['DOCUMENT_ROOT'] . $removed_image;
        if (file_exists($image_path) && $removed_image !== "/admin-assets/img/default-program.jpg") {
            unlink($image_path);
        }
    }

    // Update database with new image URLs
    $image_urls_str = implode(', ', $all_image_urls);
    $image_urls_str = mysqli_real_escape_string($conn, $image_urls_str);

    $update_query = "UPDATE gallery_image SET gallery_id = $gallery_id, image_url = '$image_urls_str' WHERE id = $id";
    if ($conn->query($update_query)) {
        echo json_encode(['status' => 200, 'message' => 'Gallery updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Failed to update gallery!']);
    }
}
?>
