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

// Initialize search variable
$searchTerm = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Query to select attendance records with search functionality
$sql = "SELECT a.id, s.full_name, a.attendance_date, a.status 
        FROM attendance a 
        JOIN staff s ON a.staff_id = s.id 
        WHERE s.full_name LIKE ? 
        OR a.attendance_date LIKE ?
        ORDER BY a.attendance_date DESC";

$stmt = $conn->prepare($sql);
$likeSearchTerm = "%" . $searchTerm . "%";
$stmt->bind_param("ss", $likeSearchTerm, $likeSearchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dddddd;
        }
        th {
            background-color: maroon;
            color: white;
        }
        tr:hover td {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
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

        .search-container {
            margin: 20px 0;
            text-align: center;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 1100px; /* Adjusted width for better appearance */
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border 0.3s ease;
        }

        .search-container input[type="submit"] {
            padding: 10px 15px;
            border: none;
            background-color: maroon;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-container input[type="submit"]:hover {
            background-color: #800000;
        }

        .add-record-container {
            text-align: center;
            margin: 20px 0;
            padding-right: 1080px;
        }

        .add-record-button {
            padding: 10px 15px;
            
            border: none;
            background-color: maroon;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .add-record-button:hover {
            background-color: #800000;
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
    <h2>Attendance Records</h2>
    
    <!-- Add Record Button -->
    <div class="add-record-container">
        <a href="attendance_form.php">
            <button class="add-record-button">Add Record</button>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Staff Name or Date" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <input type="submit" value="Search">
        </form>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Staff Name</th>
                    <th>Attendance Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['attendance_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No attendance records found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>