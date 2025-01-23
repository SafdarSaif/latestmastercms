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

    // function for fetching blogs
    public function getBlogs()
    {
        $response = [];
        $query = "SELECT ID, Name, Status, Created_At, Photo, Description FROM blogs ORDER BY ID DESC";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $blogData = [];
            while ($row = mysqli_fetch_assoc($result)) {

                $blogData[] = [
                    "ID" => $row['ID'],
                    "Name" => $row['Name'],
                    "Description" => $row['Description'],
                    "Photo" => $row['Photo'],
                    "Status" => $row["Status"]
                ];
            }
            $response = ['status' => 'success', 'data' => $blogData];
        } else {
            $response = ['status' => 'error', 'message' => mysqli_error($this->conn)];
        }
        echo json_encode($response);
    }


    // function for galleryimages
    public function getGalleryImages()
    {
        $response = [];
        $query = "SELECT * FROM gallery WHERE Status = 1 ORDER BY ID ASC";
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


    
    
}
