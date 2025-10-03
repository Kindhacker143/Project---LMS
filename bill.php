<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f0f0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #800000; /* Maroon */
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ffe6e6 !important; /* Light Maroon */
        }
        .form-control {
            border: 1px solid #800000; /* Maroon Border */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #b30000; /* Darker Maroon on focus */
            box-shadow: 0 0 0 0.2rem rgba(179, 0, 0, 0.25);
            outline: none; /* Remove default outline */
        }
        .btn-secondary {
            background-color: #800000; /* Maroon */
            border-color: #800000; /* Maroon */
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #b30000; /* Darker Maroon */
            border-color: #b30000;
        }
        .alert {
            animation: slideIn 0.5s ease-in-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animated-button {
            border: none;
            padding: 10px 20px;
            background-color: #800000; 
            color: white; 
            border-radius: 5px; 
            cursor: pointer; 
            position: relative; 
            overflow: hidden; 
            transition: background-color 0.4s; 
        }
        .animated-button::after {
            content: "";
            position: absolute; 
            left: 50%; 
            top: 50%; 
            width: 300%; 
            height: 300%; 
            background: rgba(128, 0, 0, 0.5); /* Adjusted to Maroon semi-transparent */
            border-radius: 50%; 
            transition: all 0.6s; 
            transform: translate(-50%, -50%) scale(0); 
            z-index: 0; 
        }
        .animated-button:hover {
            background-color: #b30000; /* Maroon on hover */
            color: white;
        }
        .animated-button:hover::after {
            transform: translate(-50%, -50%) scale(1); 
        }
        .animated-button span {
            position: relative; 
            z-index: 1; 
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
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
<div class="container mt-5">

    <h1 class="text-center mb-4">Add Payment</h1>

    <form method="POST" action="bill.php" class="p-4 border rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID:</label>
            <input type="number" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
        </div>
        <div class="mb-3">
            <label for="name_with_initial" class="form-label">Name with Initial:</label>
            <input type="text" class="form-control" id="name_with_initial" name="name_with_initial" placeholder="Enter Name with Initial" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Student Email" required>
        </div>
        <div class="mb-3">
            <label for="bill_no" class="form-label">Bill No:</label>
            <input type="text" class="form-control" id="bill_no" name="bill_no" placeholder="Enter Bill Number" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Payment Amount:</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" placeholder="Enter Payment Amount" required>
        </div>
        <div class="mb-3">
            <label for="received_by" class="form-label">Received By:</label>
            <input type="text" class="form-control" id="received_by" name="received_by" placeholder="Enter Receiver's Name" required>
        </div>
        <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date:</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
        </div>
        <button type="submit" name="submit" class="btn animated-button w-100"><span>Pay Now</span></button>
    </form>
    

    <?php
if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $name_with_initial = $_POST['name_with_initial'];
    $email = $_POST['email'];
    $bill_no = $_POST['bill_no'];
    $amount = $_POST['amount'];
    $received_by = $_POST['received_by'];
    $payment_date = $_POST['payment_date'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'student_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate Student ID, Name with Initial, and Email
    $check_student = "SELECT * FROM students WHERE id = $student_id AND name_with_initial = '$name_with_initial' AND email = '$email'";
    $result = $conn->query($check_student);

    if ($result->num_rows > 0) {
        // Insert payment (without email column)
        $sql = "INSERT INTO payments (student_id, name_with_initial, bill_no, amount, received_by, payment_date) 
                VALUES ('$student_id', '$name_with_initial', '$bill_no', '$amount', '$received_by', '$payment_date')";
        if ($conn->query($sql) === TRUE) {
            // Update balance
            $update_balance = "UPDATE students SET balance = balance - $amount WHERE id = $student_id";
            if ($conn->query($update_balance) === TRUE) {
                echo "<div class='alert alert-success mt-4'>Payment recorded and balance updated successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Error updating balance: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger mt-4'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning mt-4'>Invalid Student Details. Please check and try again.</div>";
    }

    $conn->close();
}
?>

    <a href="balance.php" class="btn btn-secondary mt-4">View Balance</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>