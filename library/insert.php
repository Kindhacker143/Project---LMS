<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $course_name = $_POST['course_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $book_name = $_POST['book_name'];
    $book_author = $_POST['book_author'];

    $sql = "INSERT INTO library (full_name, course_name, phone_number, address, book_name, book_author) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $course_name, $phone_number, $address, $book_name, $book_author);

    if (mysqli_stmt_execute($stmt)) {
        echo "New record created successfully!";
        header("Location: view.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>