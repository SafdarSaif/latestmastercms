<?php
// String Encryption
ini_set('display_errors', 1);








function getsettingHeadingFunc($conn)
{
    $settingHeadingArr = array();
    $settingHeadingQuery = $conn->query("SELECT ID, Name FROM setting_headings WHERE Status=1 ORDER BY ID ASC");
    while ($row = $settingHeadingQuery->fetch_assoc()) {
        $settingHeadingArr[] = $row;
    }
    return $settingHeadingArr;
}

function getwingHeadingFunc($conn)
{
    $wingHeadingArr = array();
    $wingHeadingQuery = $conn->query("SELECT ID, Name FROM wings_heading WHERE Status=1 ORDER BY ID ASC");
    while ($row = $wingHeadingQuery->fetch_assoc()) {
        $wingHeadingArr[] = $row;
    }
    return $wingHeadingArr;
}



function getcategoryFunc($conn)
{
    $categoryArr = array();
    $categoryQuery = $conn->query("SELECT ID, Name FROM category WHERE Status=1 ORDER BY ID ASC");
    while ($row = $categoryQuery->fetch_assoc()) {
        $categoryArr[] = $row;
    }
    return $categoryArr;
}

function getblogFunc($conn)
{
    $blogArr = array();
    $blogQuery = $conn->query("SELECT ID, Name FROM blogs WHERE Status=1 ORDER BY ID ASC");
    while ($row = $blogQuery->fetch_assoc()) {
        $blogArr[] = $row;
    }
    return $blogArr;
}

function getCenterFunc($conn)
{

    $centerArr = array();
    $centerQuery = $conn->query("SELECT ID, CONCAT(Name, '(', Code,')') as Name, Code FROM Users WHERE Status=1 AND Role ='Center' ORDER BY ID DESC");
    while ($row = $centerQuery->fetch_assoc()) {
        $centerArr[] = $row;
    }
    return $centerArr;
}

function getStreamFunc($conn)
{
    $streamArr = array();
    $streamQuery = $conn->query("SELECT ID, Name FROM streams WHERE Status=1 ORDER BY Position ASC");
    while ($row = $streamQuery->fetch_assoc()) {
        $streamArr[] = $row;
    }
    return $streamArr;
}
function getDepartmentFunc($conn)
{
    $deparmentArr = array();
    $departmentQuery = $conn->query("SELECT ID, Name FROM menus WHERE Status=1 ORDER BY ID DESC");
    while ($row = $departmentQuery->fetch_assoc()) {
        $deparmentArr[] = $row;
    }
    return $deparmentArr;
}

function getMenuFunc($conn)
{
    $menuArr = array();
    $menuQuery = $conn->query("SELECT ID, Name FROM menus WHERE Status=1 ORDER BY ID DESC");
    while ($row = $menuQuery->fetch_assoc()) {
        $menuArr[] = $row;
    }
    return $menuArr;
}


function getProgramFunc($conn)
{
    $programArr = array();
    $programQuery = $conn->query("SELECT ID, Name FROM programs WHERE Status=1 ORDER BY ID DESC");
    while ($row = $programQuery->fetch_assoc()) {
        $programArr[] = $row;
    }
    return $programArr;
}


function getgalleryFunc($conn)
{
    $galleryArr = array();
    $galleryQuery = $conn->query("SELECT id, image_name FROM gallery WHERE Status=1 ORDER BY ID ASC");
    while ($row = $galleryQuery->fetch_assoc()) {
        $galleryArr[] = $row;
    }
    return $galleryArr;
}

// function getCourseFunc($conn)
// {
//     $courseArr = array();
//     $courseQuery = $conn->query("SELECT ID, Name FROM courses WHERE Status=1 ORDER BY ID ASC");
//     while ($row = $courseQuery->fetch_assoc()) {
//         $courseArr[] = $row;
//     }
//     return $courseArr;
// }


function getCountry($conn)
{
    $cuntriesArr = array();
    $cuntriesQuery = $conn->query("SELECT ID, Name FROM Cuntries ORDER BY ID ASC");
    while ($row = $cuntriesQuery->fetch_assoc()) {
        $cuntriesArr[] = $row;
    }
    return $cuntriesArr;
}

// function getProgramFunc($conn)
// {
//     $programArr = array();
//     $programQuery = $conn->query("SELECT ID, Name FROM Courses WHERE Status=1 ORDER BY ID DESC");
//     while ($row = $programQuery->fetch_assoc()) {
//         $programArr[] = $row;
//     }
//     return $programArr;
// }

// function getProgramsByStream($conn, $stream_id) {
//     $programArr = array();
//     $programQuery = $conn->query("SELECT ID, Name FROM Courses WHERE Status=1 AND StreamID=$stream_id ORDER BY ID DESC");
//     while ($row = $programQuery->fetch_assoc()) {
//         $programArr[] = $row;
//     }
//     return $programArr;
// }

// if (isset($_POST['stream_id'])) {
//     $stream_id = intval($_POST['stream_id']);
//     $programs = getProgramsByStream($conn, $stream_id);
//     echo json_encode($programs);
//     exit;
// }




function getSpecializationFunc($conn)
{
    $specializationArr = array();
    $specializationQuery = $conn->query("SELECT ID,CONCAT(Sub_Courses.Name, ' (', Sub_Courses.Short_Name, ')') as Name FROM Sub_Courses WHERE Status=1 ORDER BY ID DESC");
    while ($row = $specializationQuery->fetch_assoc()) {
        $specializationArr[] = $row;
    }
    return $specializationArr;
}

// $modeArr = array("0" => "Month", "1" => "Semester");
$programArr = array("0" => "Part Time", "1" => "Full Time");
$categoryArr =array("0"=>"Category 1", "1"=>"Category 2" ,"2"=>"Category 3","3"=>"Category 4");

$last_qulifications_Arr = array("Last Qulifications" => "Last Qulifications", "Intermediate" => "Intermediate", "Intermediate (Science)" => "Intermediate (Science)", "High School" => "High School", "Graduate" => "Graduate", "Diploma" => "Diploma");
$durationArr = array("1 Month" => "1 Month", "3 Months" => "3 Months", "6 Months" => "6 Months", "12 Months" => "12 Months", "1 Years" => "1 Years", "2 Years" => "2 Years");
$programTypeArr = array("certification" => "Certification", "certified" => "Certified Diploma", "advance_diploma" => "Advance Diploma");


// function uploadImage($conn, $image, $folder, $width = null, $height = null)
// {
//     $temp = explode(".", $_FILES[$image]["name"]);
//     $filename = round(microtime(true)) . '.' . end($temp);
//     $tempname = $_FILES[$image]["tmp_name"];
//     $uploaded_folder = "../../admin-assets/img/" . $folder . "/" . $filename;
//     if (move_uploaded_file($tempname, $uploaded_folder)) {
//         $filename = "/admin-assets/img/" . $folder . "/" . $filename;
//         return  $filename;
//     } else {
//         echo json_encode(['status' => 400, 'message' => 'Unable to save photo!']);
//         exit();
//     }
// }

// function uploadImage($conn, $image, $folder, $width = null, $height = null)
// {
//     $temp = explode(".", $_FILES[$image]["name"]);
//     $filename = round(microtime(true)) . '.' . end($temp);
//     $tempname = $_FILES[$image]["tmp_name"];
//     $uploaded_folder = "../../admin-assets/img/" . $folder;

//     // Create the folder if it does not exist
//     if (!is_dir($uploaded_folder)) {
//         mkdir($uploaded_folder, 0777, true);
//     }

//     $uploaded_file = $uploaded_folder . "/" . $filename;

//     if (move_uploaded_file($tempname, $uploaded_file)) {
//         $filename = "/admin-assets/img/" . $folder . "/" . $filename;
//         return  $filename;
//     } else {
//         echo json_encode(['status' => 400, 'message' => 'Unable to save photo!']);
//         exit();
//     }
// }
function uploadImage($conn, $image, $folder, $oldImagePath = null, $width = null, $height = null)
{
    // Check and delete the old image if provided
    if ($oldImagePath && file_exists("../../" . ltrim($oldImagePath, "/"))) {
        unlink("../../" . ltrim($oldImagePath, "/"));
    }

    $temp = explode(".", $_FILES[$image]["name"]);
    $filename = round(microtime(true)) . '.' . end($temp);
    $tempname = $_FILES[$image]["tmp_name"];
    $uploaded_folder = "../../admin-assets/img/" . $folder;

    // Create the folder if it does not exist
    if (!is_dir($uploaded_folder)) {
        mkdir($uploaded_folder, 0777, true);
    }

    $uploaded_file = $uploaded_folder . "/" . $filename;

    if (move_uploaded_file($tempname, $uploaded_file)) {
        $filename = "/admin-assets/img/" . $folder . "/" . $filename;
        return $filename;
    } else {
        echo json_encode(['status' => 400, 'message' => 'Unable to save photo!']);
        exit();
    }
}



function uploadsImage($conn, $image, $folder, $width = null, $height = null)
{
    // Ensure that the destination folder exists
    $destinationFolder = "../../admin-assets/img/" . $folder . "/";
    if (!file_exists($destinationFolder) && !mkdir($destinationFolder, 0777, true)) {
        // Failed to create the directory
        echo json_encode(['status' => 400, 'message' => 'Unable to create directory!']);
        exit();
    }

    // Handle file upload for each file
    $filenames = [];
    foreach ($_FILES[$image]["name"] as $key => $name) {
        // Handle file upload
        $temp = explode(".", $name);
        if (!is_array($temp) || count($temp) < 2) {
            // Invalid file name format
            echo json_encode(['status' => 400, 'message' => 'Invalid file name format!']);
            exit();
        }

        $filename = round(microtime(true)) . '_' . $key . '.' . end($temp);
        $tempname = $_FILES[$image]["tmp_name"][$key];
        $uploaded_file = $destinationFolder . $filename;

        if (move_uploaded_file($tempname, $uploaded_file)) {
            $filename = "/admin-assets/img/" . $folder . "/" . $filename;
            $filenames[] = $filename; // Add filename to the list
        } else {
            // Failed to move the uploaded file
            echo json_encode(['status' => 400, 'message' => 'Unable to upload image!']);
            exit();
        }
    }

    return $filenames;
}


function uploadVideo($conn, $video, $folder)
{
    // Check if the video file is uploaded and there are no errors
    if (isset($_FILES[$video]) && $_FILES[$video]['error'] === UPLOAD_ERR_OK) {
        // Generate a unique filename
        $temp = explode(".", $_FILES[$video]["name"]);
        $filename = round(microtime(true)) . '.' . end($temp);
        $tempname = $_FILES[$video]["tmp_name"];

        // Set the folder where the video will be uploaded
        $uploaded_folder = "../../admin-assets/upload/" . $folder;

        // Create the folder if it does not exist
        if (!is_dir($uploaded_folder)) {
            if (!mkdir($uploaded_folder, 0777, true)) {
                echo json_encode(['status' => 400, 'message' => 'Failed to create upload directory.']);
                exit;
            }
        }

        // Set the target path for the video file
        $uploaded_file = $uploaded_folder . "/" . $filename;

        // Allowed video file types
        $allowed_types = ['video/mp4', 'video/mov', 'video/avi', 'video/mkv'];

        // Check if the uploaded file is one of the allowed video types
        if (!in_array($_FILES[$video]["type"], $allowed_types)) {
            echo json_encode(['status' => 400, 'message' => 'Invalid file type. Only video files are allowed.']);
            exit;
        }

        // Move the uploaded file to the target folder
        if (move_uploaded_file($tempname, $uploaded_file)) {
            // Return the relative path to the uploaded file
            return "/admin-assets/upload/" . $folder . "/" . $filename;
        } else {
            echo json_encode(['status' => 400, 'message' => 'Unable to save the video file.']);
            exit;
        }
    } else {
        // If no file was uploaded or there was an error
        echo json_encode(['status' => 400, 'message' => 'No video file uploaded or an error occurred.']);
        exit;
    }
}


function baseurl($vals)
{
    $vals = str_replace(" ", "-", trim(strtolower($vals)));
    $vals = str_replace("/", "-", $vals);
    $vals = str_replace("(", "-", $vals);
    $vals = str_replace(")", "-", $vals);
    $vals = str_replace("&", "-", $vals);
    $vals = str_replace("#", "-", $vals);
    $vals = str_replace("---", "-", $vals);
    $vals = str_replace("--", "-", $vals);
    $vals = str_replace(".", "-", $vals);
    $vals = str_replace("?", "-", $vals);
    return $vals;
}
