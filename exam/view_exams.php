<?php
include 'db.php'; // Include your database connection file

$stmt = $pdo->query("SELECT * FROM exams ORDER BY exam_date ASC"); // Fetch exams, ordered by date
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Exams</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            animation: fadeIn 1s ease-in;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: maroon;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .btn {
            background-color: #800000;
            border: #800000;
        }
        .btn:hover {
            background-color: rgb(87, 4, 4);
        }
        th {
            background-color: #800000;
            color: #f8f9fa;
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
            height: 80px;
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
<br><br><br>
<div class="container">
    <h1>Exams List</h1>

    <a href="add_exam.php" class="btn btn-primary mb-3">Add New Exam</a> <!-- Make space below button -->
    
    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <input type="search" id="searchInput" class="form-control" placeholder="Search by Exam Name or Any Attribute" aria-label="Search" aria-describedby="button-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="searchExams()">Search</button>
                </div>
            </div>
        </div>
    </div>

    <?php if (count($exams) > 0): ?>
        <table class="table table-bordered mt-3" id="examsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Exam Name</th>
                    <th>Exam Date</th>
                    <th>Exam Time</th>
                    <th>Exam Location</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exams as $exam): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exam['exam_id']); ?></td>
                        <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                        <td><?php echo htmlspecialchars($exam['exam_date']); ?></td>
                        <td><?php echo htmlspecialchars($exam['exam_time']); ?></td>
                        <td><?php echo htmlspecialchars($exam['exam_location']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info" role="alert">No exams found.</div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function searchExams() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('examsTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
            const tds = rows[i].getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < tds.length; j++) {
                const td = tds.item(j);
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break; // No need to continue checking if a match is found
                    }
                }
            }

            rows[i].style.display = found ? "" : "none"; // Show or hide the row
        }
    }
</script>
</body>
</html>