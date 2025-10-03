<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Balance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Roboto', sans-serif;
            opacity: 0; /* Set initial opacity for fade-in */
            animation: fadeIn 1s forwards; /* Fade-in animation */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .navbar {
            background-color: maroon;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white;
        }

        .navbar-nav li {
            margin-left: 20px;
        }

        .navbar-nav li:hover {
            color: white;
        }

        .alert {
            background-color: #f0f0f0;
            color: maroon;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            transition: background-color 0.3s; /* Hover transition */
        }

        th {
            background-color: maroon;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e0e0e0; /* Highlight on hover */
        }

        .button {
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .button a {
            text-decoration: none;
        }

        .button a:hover {
            color: maroon;
        }

        .card {
            background-color: #f2f2f2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-maroon shadow-sm">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Refresh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html" style="color: white;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white;">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white;">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5 p-5" style="background-color: #f2f2f2; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1)">

        <h1 class="text-center mb-4" style="color: maroon;">Student Balance</h1>

        <!-- Search Form -->
        <form method="POST" action="balance.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Name, ID, or Email..." value="<?= htmlspecialchars($search ?? '') ?>" required style="border: 1px solid maroon;">
                <button type="submit" class="btn" style="background-color: maroon; color: white;">Search</button>
            </div>
        </form>

        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', 'root', 'student_db');

        if ($conn->connect_error) {
            die("<div class='alert alert-danger' style='background-color: #f0f0f0;'>Connection failed: " . $conn->connect_error . "</div>");
        }

        // Get the search query if submitted
        $search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';

        // Query to fetch students
        $sql = "SELECT id, name_with_initial, email, course_fee, balance FROM students";
        if (!empty($search)) {
            $sql .= " WHERE name_with_initial LIKE '%$search%' OR id LIKE '%$search%' OR email LIKE '%$search%'";
        }

        // Execute query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div id='students-container'>";
            echo "<table class='table table-bordered mt-4' style='background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1)'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name with Initial</th>
                            <th>Email</th>
                            <th>Total Fee</th>
                            <th>Balance</th>
                            <th>Payment History</th>
                        </tr>
                    </thead>
                    <tbody>";
        
            while ($row = $result->fetch_assoc()) {
                $student_id = $row['id'];
                $course_fee = $row['course_fee'];

                // Fetch payment history and calculate total payments
                $payment_sql = "SELECT SUM(amount) AS total_paid FROM payments WHERE student_id = $student_id";
                $payment_result = $conn->query($payment_sql);
                $total_paid = 0;
                if ($payment_result->num_rows > 0) {
                    $payment_row = $payment_result->fetch_assoc();
                    $total_paid = $payment_row['total_paid'];
                }

                // Calculate the balance
                $balance = $course_fee - $total_paid;

                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['name_with_initial']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($course_fee) . "</td>
                        <td>" . htmlspecialchars($balance) . "</td>
                        <td>";

                // Fetch detailed payment history
                $payment_sql = "SELECT amount, bill_no, received_by, payment_date FROM payments WHERE student_id = $student_id ORDER BY payment_date DESC";
                $payment_result = $conn->query($payment_sql);

                if ($payment_result->num_rows > 0) {
                    echo "<table class='table table-sm mt-3' style='background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Bill No</th>
                                    <th>Received By</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($payment_row = $payment_result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($payment_row['amount']) . "</td>
                                <td>" . htmlspecialchars($payment_row['bill_no']) . "</td>
                                <td>" . htmlspecialchars($payment_row['received_by']) . "</td>
                                <td>" . htmlspecialchars($payment_row['payment_date']) . "</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<span class='text-muted mt-3'>No payments recorded.</span>";
                }

                echo "</td></tr>";
            }

            echo "</tbody></table>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning my-5' style='background-color: #f0f0f0;'>No students found.</div>";
        }

        $conn->close();
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>