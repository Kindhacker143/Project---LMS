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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $position = $_POST['position'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $record_date = $_POST['record_date'] ?? '';

    $sql = "INSERT INTO staff (full_name, email, phone, position, salary, record_date) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $name, $email, $phone, $position, $salary, $record_date);
        if ($stmt->execute()) {
            header('Location: view_staff.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: maroon;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: darkred;
        }

        .form-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: maroon;
        }

        form {
            margin-bottom: 20px;
        }

        form div {
            margin-bottom: 10px;
        }

        form label {
            font-weight: bold;
        }

        form input, form button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: maroon;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: darkred;
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
    <h2>Add New Staff</h2>
    <form method="POST" action="">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required placeholder="Enter the staff member's full name">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Enter a valid email address">
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="tel" name="phone" id="phone" required placeholder="Enter a valid phone number (e.g., 123-456-7890)">
        </div>
        <div>
            <label for="position">Position:</label>
            <input type="text" name="position" id="position" required placeholder="Enter the staff member's position (e.g., Manager)">
        </div>
        <div>
            <label for="salary">Salary:</label>
            <input type="number" name="salary" id="salary" required placeholder="Enter the salary amount (e.g., 50000)">
        </div>
        <div>
            <label for="record_date">Record Date:</label>
            <input type="date" name="record_date" id="record_date" required placeholder="Select the date">
        </div>
        <div>
            <button type="submit">Add Staff</button>
        </div>
    </form>
</div>


</body>
</html>

<?php
$conn->close();
?>