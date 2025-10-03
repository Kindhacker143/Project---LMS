<?php
include 'db.php'; // Ensure this connects to your database

// Fetch attendance records
$sql = "SELECT * FROM attendance_records";
$result = mysqli_query($conn, $sql);

// Check for query execution error
if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
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
            padding-bottom: 20px;
        }
        
        .navbar .nav-links {
            display: flex;
            align-items: center;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 20px; /* Adjusted margin for closer spacing */
            transition: background-color 0.3s;
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
            width: 70%;
            margin: 20px auto; /* Center the container and add margin */
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #800000;
            color: white;
        }
        .search-container {
            margin-bottom: 20px;
            text-align: center; /* Center the search bar */
        }
        .search-container input {
            padding: 10px;
            width: 93.5%; /* Adjust width as needed */
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: -5px; /* Overlap with button slightly */
        }
        .search-container button {
            padding: 10px;
            background-color: maroon;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: darkred;
        }
        .get-book-btn {
            background-color: #800000; /* maroon */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 150px;
            display: inline-block;
            margin: 20px auto; /* Center the button with top margin */
        }
        .get-book-btn:hover {
            background-color: #600000; /* darker maroon */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="../index.html" class="brand">Refresh</a>
    <div class="nav-links">
        <a href="../index.html">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
    </div>
</div>

<br><br><br><br>

<div class="container">
    <h2>Attendance Records</h2>
 <!-- Get a Book Button -->
 <a href="index.php"><button class="get-book-btn">Add New Record</button></a>

    <!-- Search Bar with Button -->
    <div class="search-container">
        <input type="text" id="search" placeholder="Search by Name...">
        <button id="search-btn">Search</button>
    </div>

   
    <table id="attendance-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>In Time</th>
                <th>Out Time</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["student_id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["student_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["course_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["in_time"]); ?></td>
                        <td><?php echo htmlspecialchars($row["out_time"]); ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No records found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
</div>

<!-- JavaScript to filter the table based on search input -->
<script>
    // Attach event listener to the input and button
    document.getElementById('search-btn').addEventListener('click', function() {
        var query = document.getElementById('search').value.toLowerCase();
        var rows = document.querySelectorAll('#attendance-table tbody tr');

        rows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            var name = cells[1].textContent.toLowerCase(); // Assuming "Name" is the second column

            if (name.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Optional: Allow pressing Enter key to trigger search
    document.getElementById('search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('search-btn').click();
        }
    });

</script>

<?php
mysqli_close($conn); // Close the connection
?>
</body>
</html>