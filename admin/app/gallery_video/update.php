<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';

    $id = intval($_POST['id']);
    $videoLink = isset($_POST['video_links']) ? $conn->real_escape_string(trim($_POST['video_links'])) : null;
    $videoFile = isset($_FILES['video_file']) ? $_FILES['video_file'] : null;

    // Validate and sanitize position input
    $validPositions = ['left', 'right'];
    $position = isset($_POST['position']) ? strtolower(trim($_POST['position'])) : null;
    if (!in_array($position, $validPositions)) {
        $position = 'left'; 
    }

    // Fetch current record
    $galleryVideoQuery = $conn->query("SELECT * FROM gallery_video WHERE id = $id");
    if (!$galleryVideoQuery || $galleryVideoQuery->num_rows === 0) {
        echo json_encode([
            'status' => 404,
            'message' => 'Gallery video not found.'
        ]);
        exit;
    }

    $galleryVideoArr = $galleryVideoQuery->fetch_assoc();
    $newVideo = $galleryVideoArr['video'];
    $newVideoLink = $galleryVideoArr['video_link'];

    // Process video file upload or video link
    if ($videoFile && $videoFile['error'] === UPLOAD_ERR_OK) {
        if (!empty($galleryVideoArr['video'])) {
            $oldVideoPath = '../../admin/' . $galleryVideoArr['video'];
            if (file_exists($oldVideoPath)) {
                unlink($oldVideoPath);
            }
        }
        // Upload new video file
        $uploadedVideoPath = uploadVideo($conn, "video_file", "gallery_videos");
        if ($uploadedVideoPath) {
            $newVideo = $conn->real_escape_string($uploadedVideoPath);
            $newVideoLink = null; 
        } else {
            echo json_encode([
                'status' => 500,
                'message' => 'Failed to upload video file.'
            ]);
            exit;
        }
    } elseif ($videoLink) {
        if (!empty($galleryVideoArr['video'])) {
            $oldVideoPath = '../../admin/' . $galleryVideoArr['video'];
            if (file_exists($oldVideoPath)) {
                unlink($oldVideoPath);
            }
        }
        $newVideoLink = $videoLink;
        $newVideo = null; 
    }

    // Construct the SQL query
    $newVideo = $newVideo !== null ? "'$newVideo'" : "NULL";
    $newVideoLink = $newVideoLink !== null ? "'$newVideoLink'" : "NULL";
    $updateQuery = "UPDATE gallery_video 
                    SET video_link = $newVideoLink, video = $newVideo, position = '$position' 
                    WHERE id = $id";

    if ($conn->query($updateQuery)) {
        echo json_encode([
            'status' => 200,
            'message' => 'Gallery video updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 500,
            'message' => 'Failed to update gallery video.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 400,
        'message' => 'Invalid request.'
    ]);
}
?>
