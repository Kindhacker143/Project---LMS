<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $amount = floatval($_POST['amount']);

    // Fetch student details
    $result = $conn->query("SELECT * FROM admission WHERE id = $student_id");
    $student = $result->fetch_assoc();

    if (!$student) {
        die("Student not found.");
    }

    // Update balance and record payment
    if ($amount > 0 && $amount <= $student['balance']) {
        // Record payment
        $conn->query("INSERT INTO payments (name_with_initial, amount) VALUES ($name, $amount)");
        
        // Update student balance
        $new_balance = $student['balance'] - $amount;
        $conn->query("UPDATE admission SET balance = $new_balance WHERE id = $student_id");

        // Display success message in a table format
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Confirmation</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 30px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                h2 {
                    text-align: center;
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #28a745;
                    color: white;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
            </style>
        </head>
        <body>
        <div class="container">
            <h2>Payment Confirmation</h2>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Paid Amount</th>
                    <th>New Balance</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($student['name_with_initial']); ?></td>
                    <td>$<?php echo number_format($amount, 2); ?></td>
                    <td>$<?php echo number_format($new_balance, 2); ?></td>
                </tr>
            </table>
            <br>
            <p><a href="payment_history.php">View Payment History</a></p>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "Invalid payment amount.";
    }
}
?>