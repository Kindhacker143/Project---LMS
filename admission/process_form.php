<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root"; // Add your database username
    $password = "root"; // Add your database password
    $dbname = "rms"; // Change to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $name_with_initials = $conn->real_escape_string($_POST['name_with_initials']);
    $dob = $_POST['dob'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $year_of_admission = $_POST['year_of_admission'];
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $course = $conn->real_escape_string($_POST['course']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $course_fee = $_POST['course_fee'];

    // Handle Image Upload
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
    }

    $image = $_FILES['image'];
    $image_name = basename($image['name']);
    $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . "." . $image_type;

    // Validate image file
    $upload_ok = true;
    $error_message = "";

    // Check if file is an actual image
    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        $upload_ok = false;
        $error_message = "File is not an image.";
    }

    // Check file size (limit to 2MB)
    if ($image['size'] > 2 * 1024 * 1024) {
        $upload_ok = false;
        $error_message = "File size exceeds 2MB.";
    }

    // Allow only specific file types
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_type, $allowed_types)) {
        $upload_ok = false;
        $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // Check for upload errors
    if ($upload_ok && move_uploaded_file($image['tmp_name'], $target_file)) {
        // File uploaded successfully
    } else {
        $target_file = ""; // Set to empty if upload fails
        if (empty($error_message)) {
            $error_message = "File upload failed.";
        }
        echo "Error: " . $error_message;
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO admission (full_name, name_with_initials, dob, phone, year_of_admission, nationality, gender, address, email, course, father_name, course_fee, image) 
            VALUES ('$full_name', '$name_with_initials', '$dob', '$phone', '$year_of_admission', '$nationality', '$gender', '$address', '$email', '$course', '$father_name', '$course_fee', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
