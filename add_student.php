<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            color: #4c0000;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #800000;
        }
        .navbar .nav-link {
            color: #fff !important;
            transition: color 0.3s ease;
        }
        .navbar .nav-link:hover {
            color: #ffd700 !important;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        button {
            background-color: #800000;
            color: #fff;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        button:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }
        button:active {
            transform: scale(0.95);
        }
        .btn-secondary {
            background-color: #800000 !important;
            border-color: #800000 !important;
        }
        .btn-secondary:hover {
            background-color: #660000 !important;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
<div class="container mt-4">
    <h1 class="text-center">Add Student</h1>
    <form action="add_student.php" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="row mb-3">
            <div class="col-md-6"><input type="text" class="form-control" name="full_name" placeholder="Full Name" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="name_with_initial" placeholder="Name with Initial" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><select class="form-control" name="gender" required>
                <option value="">Select Gender</option><option value="Male">Male</option><option value="Female">Female</option></select>
            </div>
            <div class="col-md-6"><input type="date" class="form-control" name="dob" required></div>
        </div>
        <div class="mb-3"><textarea class="form-control" name="address" placeholder="Address" rows="2" required></textarea></div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="email" class="form-control" name="email" placeholder="Email" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="phone" placeholder="Phone" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="text" class="form-control" name="course" placeholder="Course" required></div>
            <div class="col-md-6"><input type="number" class="form-control" name="year_of_admission" placeholder="Year of Admission" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="text" class="form-control" name="father_name" placeholder="Father's Name" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="nationality" placeholder="Nationality" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="number" class="form-control" name="course_fee" placeholder="Course Fee" step="0.01" required></div>
        </div>
        <div class="mb-3"><input type="file" class="form-control" name="image" accept="image/*" required></div>
        <button type="submit" class="btn btn-secondary">Add Student</button>
        <a href="view_students.php" class="btn btn-secondary">View Students</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
