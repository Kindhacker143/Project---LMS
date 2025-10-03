<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'root', 'student_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query if submitted
$search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';

// Fetch certificates with optional search
$sql = "SELECT 
            c.id AS certificate_id, 
            c.certificate_name, 
            c.issued_date, 
            s.id AS student_id, 
            s.name_with_initial, 
            s.course 
        FROM certificates c 
        INNER JOIN students s ON c.student_id = s.id";

if (!empty($search)) {
    $sql .= " WHERE s.id LIKE '%$search%' OR s.name_with_initial LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <!-- Navigation Bar -->
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
    <h1 class="text-center mb-4">Certificates</h1>

    <!-- Search Form -->
    <form method="POST" action="view_certificates.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" 
                   placeholder="Search by ID or Name with Initial..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Certificate ID</th>
                    <th>Student ID</th>
                    <th>Name with Initial</th>
                    <th>Course</th>
                    <th>Certificate Name</th>
                    <th>Issued Date</th>
                    <th>Subjects & Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['certificate_id']) ?></td>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['name_with_initial']) ?></td>
                        <td><?= htmlspecialchars($row['course']) ?></td>
                        <td><?= htmlspecialchars($row['certificate_name']) ?></td>
                        <td><?= htmlspecialchars($row['issued_date']) ?></td>
                        <td>
                            <?php
                            $certificate_id = $row['certificate_id'];
                            $subject_sql = "SELECT subject_name, marks FROM certificate_subjects WHERE certificate_id = $certificate_id";
                            $subject_result = $conn->query($subject_sql);

                            if ($subject_result->num_rows > 0) {
                                echo "<ul>";
                                while ($subject_row = $subject_result->fetch_assoc()) {
                                    echo "<li>" . htmlspecialchars($subject_row['subject_name']) . ": " . htmlspecialchars($subject_row['marks']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<span class='text-muted'>No subjects recorded.</span>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No certificates found.</div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
