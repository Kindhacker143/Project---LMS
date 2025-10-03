<?php
include 'db.php'; // Include your database connection file

$stmt = $pdo->query("SELECT results.result_id, results.student_name, results.score, exams.exam_name 
                      FROM results 
                      JOIN exams ON results.exam_id = exams.exam_id");
                      
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
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
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: maroon;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        th {
            background-color: #800000;
            color: #f1f1f1;
        }
        .table th, .table td {
            text-align: center;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1; /* Light gray background on hover */
        }
        .btn-primary {
            width: 200px;
            background-color: maroon;
            border-color: maroon;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #8B0000; /* Darker maroon on hover */
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media(max-width: 768px) {
            .container {
                width: 90%;
            }

            nav .nav-links {
                flex-direction: column;
                gap: 10px;
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
        .btn-secondary{
            background-color: #800000;
        }
        .btn-secondary:hover{
            background-color:rgb(107, 9, 9);
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
        <h1>Exam Results</h1>
        <a href="add_result.php" class="btn btn-primary btn-block">Add New Result</a>
        <br>

        <!-- Search Bar with Button -->
        <div class="search-bar mb-3">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Student Name or Exam Name">
                <div class="input-group-append">
                    <button type="button" class="btn btn-secondary" onclick="searchResults()">Search</button>
                </div>
            </div>
        </div>

        <table class="table table-hover" id="resultsTable">
            <thead class="thead-custom">
                <tr>
                    <th>ID</th>
                    <th>Exam Name</th>
                    <th>Student Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['result_id']); ?></td>
                        <td><?php echo htmlspecialchars($result['exam_name']); ?></td>
                        <td><?php echo htmlspecialchars($result['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($result['score']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function searchResults() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('resultsTable');
            const trs = table.getElementsByTagName('tr');

            for (let i = 1; i < trs.length; i++) { // Start from 1 to skip the header row
                const tds = trs[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < tds.length; j++) {
                    const td = tds[j];
                    if (td) {
                        const txtValue = td.textContent || td.innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break; // No need to continue checking if a match is found
                        }
                    }
                }

                trs[i].style.display = found ? "" : "none"; // Show or hide the row
            }
        }
    </script>
</body>
</html>