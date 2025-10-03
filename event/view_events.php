<?php
include 'db.php'; // Ensure this file properly establishes a database connection

// Initialize search variable
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']); // Use trim to avoid issues with leading/trailing spaces
}

try {
    // SQL query to filter by event name
    $stmt = $pdo->prepare("SELECT id, event_name, event_date, event_time, event_location FROM events WHERE event_name LIKE ?");
    $stmt->execute(['%' . $search . '%']);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching events: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
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
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: maroon;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: maroon;
            border: none;
        }

        .btn-primary:hover {
            background-color: rgb(110, 6, 6);
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            border: 1px solid #800000; /* Maroon border */
        }

        th {
            background-color: maroon;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .form-inline {
            width: 100%;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav .brand {
            font-size: 25px;
            color: white;
            text-decoration: none;
            padding-left: 200px;
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
            padding-right: 200px;
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
<br><br>
<br><br>
<br><br>


<div class="container">
    <h1>Event List</h1>
    <a href="add_event.php" class="btn btn-primary">Add New Event</a>

    <!-- Search Form -->
    <form method="GET" class="form-inline my-3">
        <input type="text" name="search" class="form-control" style="width: 91%;" placeholder="Search events..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary ml-2">Search</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Event Location</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['id']); ?></td>
                    <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                    <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                    <td><?php echo htmlspecialchars($event['event_time']); ?></td>
                    <td><?php echo htmlspecialchars($event['event_location']); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: gray;">No events found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>