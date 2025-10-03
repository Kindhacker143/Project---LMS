<?php
$servername = "localhost";
$username = "root"; // Change as needed
$password = "root"; // Change as needed
$dbname = "rms"; // Adjust database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert attendance record if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];
    $attendance_date = $_POST['attendance_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO attendance (staff_id, attendance_date, status) VALUES ('$staff_id', '$attendance_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to view_attendance.php on success
        header("Location: view_attendance.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
    }
}

// Fetch staff for the dropdown
$staff_sql = "SELECT id, full_name FROM staff";
$staff_result = $conn->query($staff_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Attendance Form</title>
    <style>
        /* Basic styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: maroon;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: maroon;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #800000;
        }
        @media(max-width: 768px) {
            .container {
                width: 90%;
            }
        }

        nav {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 20px;
            padding-top: 30px; 
            display: flex;
            align-items: center;
            justify-content: space-between; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            height: 30px;
        }

        nav .brand {
            font-size: 25px;
            color: white;
            text-decoration: none;
            padding-left: 200px;
            padding-bottom: 20px;
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
            padding-right: 200px;
            padding-bottom: 20px;
        }

        nav .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav .nav-links a:hover {
            color: #ffcc00; /* Gold color on hover */
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
<br><br><br><br>

<div class="form-container">
    <h2>Record Attendance</h2>
    <form method="POST">
        <label for="staff_id">Staff Name:</label>
        <select id="staff_id" name="staff_id" required>
            <option value="">Select Staff</option>
            <?php if ($staff_result && $staff_result->num_rows > 0): ?>
                <?php while ($row = $staff_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['full_name']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <label for="attendance_date">Date:</label>
        <input type="date" id="attendance_date" name="attendance_date" required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>

        <input type="submit" value="Submit Attendance">
    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>