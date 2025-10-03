<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #800000; /* Maroon */
            margin: 20px 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 95%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-bar button {
            padding: 10px 15px;
            background-color: #800000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-bar button:hover {
            background-color: #660000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            transition: background-color 0.3s ease;
        }

        th {
            background-color: #800000; /* Maroon */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e8e8e8; /* Light grey on hover */
        }

        a {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #800000; /* Maroon */
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            border: 2px solid #800000; /* Maroon border */
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        a:hover {
            background-color: #800000; /* Maroon hover */
            color: white; /* White text on hover */
        }

        nav {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            height: 65px;
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

        @media(max-width: 768px) {
            .container {
                width: 90%;
            }

            nav .nav-links {
                flex-direction: column;
                gap: 10px;
            }
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
<br><br><br><br>

<div class="container">
    <h2>Library Records</h2>
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by Name, Course Name, or Book Name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Search</button>
    </form>
    <br>
    <a href="index.php">Add New Record</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Course Name</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Book Name</th>
            <th>Book Author</th>
        </tr>
        <?php
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

        $sql = "SELECT * FROM library";
        if (!empty($search)) {
            $sql .= " WHERE full_name LIKE '%$search%' 
                      OR course_name LIKE '%$search%' 
                      OR book_name LIKE '%$search%'";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['course_name']}</td>
                        <td>{$row['phone_number']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['book_name']}</td>
                        <td>{$row['book_author']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found.</td></tr>";
        }

        mysqli_close($conn);
        ?>
    </table>
</div>
</body>
</html>
