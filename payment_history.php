<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: rgb(0, 0, 0);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            margin-bottom: 20px;
            display: flex; /* Use flexbox for alignment */
            justify-content: flex-end; /* Align the items to the right */
        }
        input[type="text"] {
            padding: 10px;
            width: 70%;
            max-width: 400px; /* Optional: limit the width for larger screens */
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: rgb(69, 70, 69);
        }
        .payment-table {
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
<br><br>
<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'root', 'rms');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query if submitted
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Create the search form
echo '<form method="POST" action="balance.php">
        <input type="text" name="search" value="' . htmlspecialchars($search) . '" placeholder="Search by name..." required>
        <button type="submit">Search</button>
      </form>';

// Modify the query to search students by name
$sql = "SELECT id, name_with_initials, course_fee, balance FROM admission WHERE name_with_initials LIKE '%$search%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Total Fee</th>
                <th>Balance</th>
                <th>Payment History</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['name_with_initials']) . "</td>
                <td>" . htmlspecialchars($row['course_fee']) . "</td>
                <td>" . htmlspecialchars($row['balance']) . "</td>
                <td>";

        // Fetch payment history for the student
        $student_id = $row['id'];
        $payment_sql = "SELECT amount, payment_date FROM payments WHERE student_id = $student_id ORDER BY payment_date DESC";
        $payment_result = $conn->query($payment_sql);

        if ($payment_result->num_rows > 0) {
            echo "<table class='payment-table'>
                    <tr>
                        <th>Amount</th>
                        <th>Payment Date</th>
                    </tr>";
            while ($payment_row = $payment_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($payment_row['amount']) . "</td>
                        <td>" . htmlspecialchars($payment_row['payment_date']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No payments recorded.";
        }

        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No students found.";
}

$conn->close();
?>

</body>
</html>