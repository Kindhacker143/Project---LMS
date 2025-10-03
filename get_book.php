<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $borrower_name = $_POST['borrower_name'];
    $borrowed_date = date('Y-m-d');

    $sql = "INSERT INTO books (title, author, borrower_name, borrowed_date)
            VALUES ('$title', '$author', '$borrower_name', '$borrowed_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Book record added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Get a Book</title>
</head>
<body>
    <h1>Get a Book</h1>
    <form method="POST" action="">
        <label for="title">Book Title:</label>
        <input type="text" name="title" required><br><br>
        <label for="author">Author:</label>
        <input type="text" name="author" required><br><br>
        <label for="borrower_name">Borrower's Name:</label>
        <input type="text" name="borrower_name" required><br><br>
        <button type="submit">Borrow Book</button>
    </form>
</body>
</html>
