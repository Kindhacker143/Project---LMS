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

// Initialize search term
$searchTerm = '';
if (isset($_POST['search'])) {
    // Escape input to prevent SQL injection
    $searchTerm = $conn->real_escape_string($_POST['search']);
}

// Query to select staff with search capability
$sql = "SELECT * FROM staff";
if ($searchTerm) {
    $sql .= " WHERE full_name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' OR phone LIKE '%$searchTerm%' OR position LIKE '%$searchTerm%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 1250px;
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

        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 1150px; /* Set the width of the search input */
        }

        .search-container input[type="submit"] {
            padding: 10px 20px;
            margin-left: 10px;
            background-color: maroon;
            color: white;
            border: none;
            cursor: pointer;
        }

        .search-container input[type="submit"]:hover {
            background-color:rgb(94, 10, 10); /* Darker color on hover */
            color: white;
        }

        .add-record-container {
            text-align: center;
            margin-bottom: 20px;
            padding-right: 1105px;
        }

        .add-record-button {
            padding: 10px 20px;
            background-color: maroon;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-record-button:hover {
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
            padding: 20px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        nav .brand {
            font-size: 25px;
            color: white;
            text-decoration: none;
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
          
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
    <h2>View Staff</h2>

    <!-- Add New Staff Button -->
    <div class="add-record-container">
        <a href="add_staff.php">
            <button class="add-record-button">Add New Staff</button>
        </a>
    </div>

    <form method="POST" class="search-container">
        <input type="text" name="search" placeholder="Search by name, email, phone, or position" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <input type="submit" value="Search">
    </form>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Record Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['position']); ?></td>
                        <td><?php echo htmlspecialchars($row['salary']); ?></td>
                        <td><?php echo htmlspecialchars($row['record_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No staff found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>