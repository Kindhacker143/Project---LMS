<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "student_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query if submitted
$search = isset($_POST['search']) ? $conn->real_escape_string(trim($_POST['search'])) : '';

// Fetch students based on search query
$sql = "SELECT * FROM students"; // Default query
if (!empty($search)) {
    $sql .= " WHERE full_name LIKE '%$search%' OR id LIKE '%$search%'"; // Add conditions for search
}

$students = $conn->query($sql);

// Uncomment the line below to debug the SQL query being executed
// echo "<pre>$sql</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
        }
        .navbar {
            background-color: #800000; /* Maroon */
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important; 
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffd700 !important; /* Gold on hover */
        }
        .container {
            margin-top: 20px;
        }
        h1 {
            color: #800000; /* Maroon */
            transition: color 0.3s ease;
        }
        h1:hover {
            color: #ffd700; /* Gold on hover */
        }
        .btn-secondary {
            background-color: #700000; /* Darker maroon */
            border-color: #700000; 
        }
        .btn-secondary:hover {
            background-color: #600000; /* Even darker on hover */
            border-color: #600000; 
        }
        .table {
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .table th {
            background-color: #800000; 
            color: white;
        }
        .table tr:hover {
            background-color: #f2d1d1; /* Light maroon hover effect */
        }
        img {
            transition: transform 0.2s; /* Animation for image */
        }
        img:hover {
            transform: scale(1.1); /* Scale up on hover */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Refresh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">View Students</h1>
        <a href="add_student.php" class="btn btn-secondary mb-3">Add Student</a>
        
        <!-- Search Form -->
        <form method="POST" action="view_students.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Name, ID..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>

        <!-- Students Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students && $students->num_rows > 0): ?>
                    <?php while ($row = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td>
                            <?php if (!empty($row['image_data'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($row['image_data']) ?>" alt="Image" width="50">
                            <?php else: ?>
                                <img src="default-image.jpg" alt="Default Image" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="view_student.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm">View</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No students found for your search</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>