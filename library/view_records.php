<?php
include 'db_connection.php';

// Initialize search variable
$search_key = isset($_POST['search_key']) ? $_POST['search_key'] : '';

// Prepare SQL query to search for records based on search input
if ($search_key) {
    $sql = "SELECT * FROM books WHERE title LIKE '%$search_key%' OR author LIKE '%$search_key%' OR borrower_name LIKE '%$search_key%'";
} else {
    $sql = "SELECT * FROM books";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: External CSS file -->
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
    }

    .container {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .title {
        color: #800000; /* maroon */
        text-align: center;
        margin-bottom: 20px;
    }

    .search-box {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
    }

    .search-box input[type="search"] {
        width: calc(110% - 120px); /* Adjust width minus button width */
        height: 40px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .search-box button {
        background-color: #800000; /* maroon */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .search-box button:hover {
        background-color: #600000; /* darker maroon */
    }

    .get-book-btn {
        background-color: #800000; /* maroon */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 150px;
        margin-bottom: 10px;
    }

    .get-book-btn:hover {
        background-color: #600000; /* darker maroon */
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 18px;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 10px;
        border: 1px solid #800000; /* maroon border */
    }

    .styled-table th {
        background-color: #800000; /* maroon header */
        color: white;
    }

    .styled-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .styled-table tbody tr:hover {
        background-color: #f2e0e0; /* lighter maroon on hover */
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
<br><br><br><br>
<br><br>
<div class="container">
    <h1 class="title">View Book Records</h1>

    <a href="get_book.php"><button class="get-book-btn">Get a book</button></a>

    <!-- Search box -->
    <form class="search-box" action="" method="POST">
        <input type="search" name="search_key" value="<?php echo htmlspecialchars($search_key); ?>" placeholder="Search by title, author, or name...">
        <button type="submit">Search</button>
    </form>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Borrower Name</th>
                <th>Borrowed Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['author']}</td>
                            <td>{$row['borrower_name']}</td>
                            <td>{$row['borrowed_date']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
    
</body>
</html>

<?php
$conn->close();
?>