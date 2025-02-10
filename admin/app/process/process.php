<?php

class Process
{

    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // function for fetching testimonials
    public function getTestimonials()
    {
        $response = [];
        $query = "SELECT * FROM testimonials WHERE Status = 1 ORDER BY ID DESC";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $testimonialData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $testimonialData[] = [
                    'ID' => $row['ID'],
                    'Name' => $row['Name'],
                    'Testimonial' => $row['Testimonial'],
                    'Image' => $row['Image'],
                    'Profile' => $row['Profile']
                ];
            }
            $response = ['status' => 'success', 'data' => $testimonialData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }



    // function for galleryimages
    public function getGalleryImages()
    {
        $response = [];
        $query = "SELECT * FROM gallery WHERE status = 1 ORDER BY ID DESC";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $galleryData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $galleryData[] = [
                    'ID' => $row['id'],
                    'Name' => $row['image_name'],
                    'Images' => $row['image_link'],
                    'Status' => $row['status']
                ];
            }
            $response = ['status' => 'success', 'data' => $galleryData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }


    // function for fetching wings and wings data 
    // public function getWings()
    // {
    //     $response = [];
    //     $query = "SELECT wings_heading.ID, wings_heading.Name, wings.* FROM wings_heading LEFT JOIN wings ON wings_heading.ID = wings.Wing_Heading_ID WHERE wings_heading.Name LIKE '%Events and Function%'";

    //     $result = mysqli_query($this->conn, $query);
    //     if ($result) {
    //         $wingsData = [];
    //         while ($row = mysqli_fetch_assoc($result)) {
    //             $wingsData[] = [
    //                 'ID' => $row['ID'],
    //                 'Name' => $row['Name'],
    //                 'Description' => $row['Description'],
    //                 'Photo' => $row['Photo'],
    //                 'Status' => $row['Status']
    //             ];
    //         }
    //         $response = ['status' => 'success', 'data' => $wingsData];
    //     } else {
    //         $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
    //     }
    //     echo json_encode($response);
    // }


    // Function to fetch wings and wings data
    public function getEvents()
    {
        $response = [];
        $query = "SELECT wings_heading.ID, wings_heading.Name, wings.* FROM wings_heading LEFT JOIN wings ON wings_heading.ID = wings.Wing_Heading_ID WHERE wings_heading.Name LIKE '%Events and Function%' AND wings.Status = 1 
        ORDER BY wings.ID DESC";

        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $eventsData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $eventsData[] = [
                    'ID' => $row['ID'],
                    'Name' => $row['Name'],
                    'Content' => $row['Content'],
                    'Photo' => $row['Media_File'],
                    'Slug' => $row['Slug'],
                    'Date' => $row['Date'],
                    'Status' => $row['Status']
                ];
            }
            $response = ['status' => 'success', 'data' => $eventsData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }


    // // Function to fetch event details based on slug
    // public function getEventDetails($slug)
    // {
    //     $response = [];
    //     $query = "SELECT wings_heading.ID, wings_heading.Name, wings.* 
    //           FROM wings_heading 
    //           LEFT JOIN wings ON wings_heading.ID = wings.Wing_Heading_ID 
    //           WHERE wings.Slug = '$slug'";

    //     $result = mysqli_query($this->conn, $query);

    //     if ($result && mysqli_num_rows($result) > 0) {
    //         $event = mysqli_fetch_assoc($result);
    //         $response = [
    //             'status' => 'success',
    //             'data' => $event
    //         ];
    //     } else {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Event not found'
    //         ];
    //     }

    //     return $response;
    // }


    // Function to fetch Notices & Announcements data
    public function getAnnouncement()
    {
        $response = [];
        $query = "SELECT wings_heading.ID, wings_heading.Name, wings.* FROM wings_heading LEFT JOIN wings ON wings_heading.ID = wings.Wing_Heading_ID WHERE wings_heading.Name LIKE '%Notice and Announcements%' AND wings.Status = 1 
        ORDER BY wings.ID DESC";

        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $eventsData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $eventsData[] = [
                    'ID' => $row['ID'],
                    'Name' => $row['Name'],
                    'Content' => $row['Content'],
                    'Photo' => $row['Media_File'],
                    'Slug' => $row['Slug'],
                    'Date' => $row['Date'],
                    'Status' => $row['Status']
                ];
            }
            $response = ['status' => 'success', 'data' => $eventsData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }







    // Function to store leads
    // public function storeLeads()
    // {
    //     $response = [];

    //     $name = mysqli_real_escape_string($this->conn, $_POST['con_name'] ?? '');
    //     $email = mysqli_real_escape_string($this->conn, $_POST['con_email'] ?? '');
    //     $subject = mysqli_real_escape_string($this->conn, $_POST['subject'] ?? '');
    //     $mobile = mysqli_real_escape_string($this->conn, $_POST['phone'] ?? '');
    //     $message = mysqli_real_escape_string($this->conn, $_POST['con_message'] ?? '');
    //     $address = mysqli_real_escape_string($this->conn, $_POST['con_address'] ?? '');
    //     $type = mysqli_real_escape_string($this->conn, $_POST['form_type'] ?? '');

    //     if (empty($name) || empty($email) || empty($mobile)) {
    //         $response = ['status' => 'error', 'message' => 'Name, Email, and Mobile are required.'];
    //     } else {
    //         // Insert data into the leads table
    //         $query = "INSERT INTO leads (Name, Email, Subject, Mobile, Message, Address,Type) VALUES ('$name', '$email', '$subject', '$mobile', '$message', '$address', '$type')";
    //         $result = mysqli_query($this->conn, $query);

    //         if ($result) {
    //             $response = ['status' => 200, 'message' => 'Your details have been successfully added! Thank you for reaching out.'];
    //         } else {
    //             $response = ['status' => 400, 'message' => 'Something went wrong!' . mysqli_error($this->conn)];
    //         }
    //     }

    //     echo json_encode($response);
    // }

    // API for Prakriti Website 

    // function for fetching blogs
    public function getBlogs()
    {
        $response = [];
        $query = "SELECT ID, Name, Slug, Status, Created_At, Photo, Content, Description, Updated_At FROM blogs WHERE Status = 1 ORDER BY ID DESC";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $blogData = [];
            while ($row = mysqli_fetch_assoc($result)) {

                $blogData[] = [
                    "ID" => $row['ID'],
                    "Name" => $row['Name'],
                    "Slug" => $row['Slug'],
                    "Description" => $row['Description'],
                    "Photo" => $row['Photo'],
                    "Content" => $row['Content'],
                    "Status" => $row["Status"],
                    "Created_At" => $row["Updated_At"]
                ];
            }
            $response = ['status' => 'success', 'data' => $blogData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }


    public function getFaq()
    {
        $response = [];
        $query = "SELECT * FROM faqs WHERE Status = 1 ORDER BY ID DESC";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $faqData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $faqData[] = [
                    'ID' => $row['ID'],
                    'Question' => $row['Question'],
                    'Answer' => $row['Answer'],
                    'Status' => $row['Status']
                ];
            }
            $response = ['status' => 'success', 'data' => $faqData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }



    public function storeLeads()
    {
        $response = [];

        // Capture form data
        $name = mysqli_real_escape_string($this->conn, $_POST['con_name'] ?? '');
        $email = mysqli_real_escape_string($this->conn, $_POST['con_email'] ?? '');
        $subject = mysqli_real_escape_string($this->conn, $_POST['subject'] ?? '');
        $mobile = mysqli_real_escape_string($this->conn, $_POST['phone'] ?? '');
        $message = mysqli_real_escape_string($this->conn, $_POST['con_message'] ?? '');
        $address = mysqli_real_escape_string($this->conn, $_POST['con_address'] ?? '');
        $type = mysqli_real_escape_string($this->conn, $_POST['form_type'] ?? '');

        // Additional form fields
        $city = mysqli_real_escape_string($this->conn, $_POST['city'] ?? '');
        $room_no = mysqli_real_escape_string($this->conn, $_POST['room_no'] ?? '');
        $adults = mysqli_real_escape_string($this->conn, $_POST['adults'] ?? '');
        $children = mysqli_real_escape_string($this->conn, $_POST['children'] ?? '');
        $check_in_date = mysqli_real_escape_string($this->conn, $_POST['check_in_date'] ?? '');
        $check_out_date = mysqli_real_escape_string($this->conn, $_POST['check_out_date'] ?? '');

        // Validation for required fields
        if (empty($name) || empty($email) || empty($mobile)) {
            $response = ['status' => 'error', 'message' => 'Name, Email, and Mobile are required.'];
        } else {

            $content_data = [];

            if (!empty($address)) {
                $content_data['Address'] = $address;
            }
            if (!empty($city)) {
                $content_data['City'] = $city;
            }
            if (!empty($room_no)) {
                $content_data['Room Number'] = $room_no;
            }
            if (!empty($adults)) {
                $content_data['Adults'] = $adults;
            }
            if (!empty($children)) {
                $content_data['Children'] = $children;
            }
            if (!empty($check_in_date)) {
                $content_data['Check-in Date'] = $check_in_date;
            }
            if (!empty($check_out_date)) {
                $content_data['Check-out Date'] = $check_out_date;
            }

            $content_json = !empty($content_data) ? json_encode($content_data) : '';

            $query = "INSERT INTO leads (Name, Email, Subject, Mobile, Message, Address, Type, Content) 
                  VALUES ('$name', '$email', '$subject', '$mobile', '$message', '$address', '$type', '$content_json')";
            $result = mysqli_query($this->conn, $query);

            if ($result) {
                $response = ['status' => 200, 'message' => 'Your details have been successfully added! Thank you for reaching out.'];
            } else {
                $response = ['status' => 400, 'message' => 'Something went wrong!' . mysqli_error($this->conn)];
            }
        }

        echo json_encode($response);
    }



    public function getNearPlaces()
    {
        $response = [];
        $query = "SELECT wings_heading.ID, wings_heading.Name, wings.* FROM wings_heading LEFT JOIN wings ON wings_heading.ID = wings.Wing_Heading_ID WHERE wings_heading.Name LIKE '%Near Places%' AND wings.Status = 1 
        ORDER BY wings.ID DESC";

        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $nearPlaceData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $nearPlaceData[] = [
                    'ID' => $row['ID'],
                    'Name' => $row['Name'],
                    'Content' => $row['Content'],
                    'Photo' => $row['Media_File'],
                    'Slug' => $row['Slug'],
                    'Date' => $row['Date'],
                    'Status' => $row['Status']
                ];
            }
            $response = ['status' => 'success', 'data' => $nearPlaceData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }
}
