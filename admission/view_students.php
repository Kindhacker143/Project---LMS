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
        $error_message = "File size exceeds 10MB.";
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
    $sql = "INSERT INTO admission (full_name, name_with_initials, gender, dob, address, email, phone, course, year_of_admission, father_name, nationality, course_fee, image) 
            VALUES ('$full_name', '$name_with_initials', '$gender', '$dob', '$address', '$email', '$phone', '$course', '$year_of_admission', '$father_name', '$nationality', '$course_fee', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        header('Location: form.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br]" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(58, 39, 224);
            color: #333;
            padding: 0;
            margin: 0;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            color: #800000;
            margin-bottom: 20px;
            padding-left: 10px;
        }

        .search-container {
            text-align: center;
            margin: 20px 0;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 1100px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .search-container button {
            padding: 10px 15px;
            background-color: #800000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-container button:hover {
            background-color:rgb(99, 8, 8);
            color: white;
        }

        table {
            width: 100%;
            border-collapse:separate;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 1rem;
        }

        th {
            background-color: #800000;
            color: #fff;
            font-weight: bold;
            
        }

        td {
            background-color: #f9f9f9;
            padding: 5px;
        }

        tr:hover td {
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.2);
        }

        .container {
            margin: 0 auto;
            width: 90%;
            max-width: 1200px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #555;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        table {
            animation: fadeIn 1.5s ease-out;
        }

        nav {
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav .brand {
            font-size: 25px;
            color: white;
            text-decoration: none;
            padding-left: 200px;
            padding-bottom: 5px;
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
            padding-right: 200px;
        }

        nav .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav .nav-links a:hover {
            color: #ffcc00;
        }

        .button {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            background-color: #800000;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color:rgb(99, 8, 8);
            color: white;
        }
        .btn-secondary {
    display: inline-block;
    padding: 8px 15px;
    text-decoration: none;
    background-color: #800000;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    border: 1px solid #800000;
    transition: background-color 0.3s ease, color 0.3s ease;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: rgb(99, 8, 8);
    color:rgb(255, 255, 255);
    border-color: rgb(99, 8, 8);
}
    </style>
</head>
<body>
<nav>
    <a href="../index.html" class="brand">Refresh</a>
    <div class="nav-links">
        <a href="../index.html">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
    </div>
</nav>
<br><br><br><br>

<div class="container">
    <h2>View Students</h2>
    <br><br><br>
    <a href="form.php" class="btn btn-secondary mb-3">Add New Student</a>
    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by Full Name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <table id="studentTable">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "rms";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

        $sql = "SELECT * FROM admission";
        if (!empty($search)) {
            $sql .= " WHERE full_name LIKE '%$search%'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['full_name'] . "</td>
                        <td><img src='" . $row['image'] . "' alt='Student Image'></td>
                        <td><a href='view.php?id=" . $row['id'] . "' class='button'>View</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>
</body>
</html>