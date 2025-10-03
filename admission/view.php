<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "rms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is passed as a query parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch student details
    $sql = "SELECT * FROM admission WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No student found with the given ID.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .container {
            margin: 0 auto;
            width: 150%;
            max-width: 1200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #800000;
        }

        .student-details {
            margin-top: 20px;
        }

        .student-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .student-details table th, .student-details table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 1.1rem;
        }

        .student-details table th {
            background-color: #800000;
            color: white;
        }

        img {
            display: block;
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        a.back-btn, a.edit-btn, a.delete-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
        }

        a.back-btn {
            background-color: #800000;
            color: white;
            transition: background-color 0.3s ease;
        }

        a.edit-btn {
            background-color: rgb(128, 7, 7);
            color: white;
            
            transition: background-color 0.3s ease;
        }

        a.delete-btn {
            background-color: rgb(128, 7, 7);
            color: white;
            transition: background-color 0.3s ease;
        }

        a.back-btn:hover {
            background-color: rgb(128, 7, 7);
        }

        a.edit-btn:hover {
            background-color:rgb(128, 7, 7);
        }

        a.delete-btn:hover {
            background-color: rgb(128, 7, 7);
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
<div class="container">
    <h2>Student Details</h2>
    <div class="student-details">
        <table>
            <tr>
                <td>Full Name:</td>
                <td><?php echo $row['full_name']; ?></td>
            </tr>
            <tr>
                <td>Name with Initials:</td>
                <td><?php echo $row['name_with_initials']; ?></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><?php echo $row['gender']; ?></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><?php echo $row['dob']; ?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo $row['address']; ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $row['email']; ?></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><?php echo $row['phone']; ?></td>
            </tr>
            <tr>
                <td>Course:</td>
                <td><?php echo $row['course']; ?></td>
            </tr>
            <tr>
                <td>Year of Admission:</td>
                <td><?php echo $row['year_of_admission']; ?></td>
            </tr>
            <tr>
                <td>Father's Name:</td>
                <td><?php echo $row['father_name']; ?></td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td><?php echo $row['nationality']; ?></td>
            </tr>
            <tr>
                <td>Course Fee:</td>
                <td><?php echo $row['course_fee']; ?></td>
            </tr>
            <tr>
                <td>Balance:</td>
                <td><?php echo $row['balance']; ?></td>
            </tr>
            <tr>
                <td>Image:</td>
                <td><img src="<?php echo $row['image']; ?>" alt="Student Image"></td>
            </tr>
        </table>
    </div>
    <div>
        <a href="view_students.php" class="back-btn">Back</a>
        <a href="update_student.php" class="edit-btn">Edit</a>
        <a href="delete_student.php?id=<?php echo $id; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
    </div>
</div>
</body>
</html>