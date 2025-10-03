<?php
include 'db.php'; // Assuming this connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST["studentID"];
    $studentName = $_POST["studentName"];
    $courseName = $_POST["courseName"];
    $inTime = $_POST["inTime"];
    $outTime = $_POST["outTime"];

    // Prepare an SQL statement for security to guard against SQL injection
    $stmt = $conn->prepare("INSERT INTO attendance_records (student_id, student_name, course_name, in_time, out_time)
                             VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $studentID, $studentName, $courseName, $inTime, $outTime);

    if ($stmt->execute()) {
        echo "<script>alert('Attendance recorded successfully!'); window.location.href='records.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Navbar styles */
        .navbar {
            background-color: maroon;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            padding-left: 200px;
        }

        .navbar .nav-links a {
            color: white;
           
            text-decoration: none;
            margin: 0 10px; /* Adjusted margin for closer spacing */
            transition: background-color 0.3s;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .navbar .nav-links a:hover {
            background-color: darkred;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 50px auto;
        }

        h2 {
            text-align: center;
            color: maroon;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #800000;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: rgb(92, 3, 3);
        }
    </style>
</head>

<body>


<div class="container">
    <h2>Student Attendance</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Student ID:</label>
        <input type="text" name="studentID" placeholder="Enter Student ID" required>

        <label>Student Name:</label>
        <input type="text" name="studentName" placeholder="Enter Student Name" required>

        <label>Course Name:</label>
        <input type="text" name="courseName" placeholder="Enter Course Name" required>

        <label>In Time:</label>
        <input type="time" name="inTime" placeholder="HH:MM" required>

        <label>Out Time:</label>
        <input type="time" name="outTime" placeholder="HH:MM" required>

        <button type="submit">Submit</button>
    </form>
</div>

<?php
mysqli_close($conn); // Close the connection
?>
</body>
</html>