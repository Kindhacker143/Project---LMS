<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function addSubjectRow() {
            const subjectList = document.getElementById('subject-list');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3');
            newRow.innerHTML = `
                <div class="col-md-6">
                    <input type="text" name="subject[]" class="form-control" placeholder="Subject Name" required>
                </div>
                <div class="col-md-6">
                    <input type="number" name="marks[]" class="form-control" placeholder="Marks" required>
                </div>`;
            subjectList.appendChild(newRow);
        }
    </script>
    <style>
    body {
        background-color: #f8f0f0;
        font-family: Arial, sans-serif;
        padding-top: 0; /* Removed padding for top space to make navbar stick to the top */
    }
    .navbar {
        background-color: #800000; /* Maroon color */
        width: 100%; /* Ensure navbar covers full width */
        position: fixed; /* Make navbar fixed */
        top: 0; /* Position it at the top */
        left: 0; /* Position it at the left */
        right: 0; /* Make it full width */
        z-index: 1000; /* Ensure it is above other content */
        display: flex; /* Use flex for full-width container */
        justify-content: space-between; /* Distribute content evenly */
        align-items: center; /* Center content vertically */
    }
    .navbar-brand, 
    .nav-link {
        color: #fff !important; /* White text for better contrast */
    }
    .nav-link:hover {
        color: #ffe6e6 !important; /* Lightened color on hover */
    }
    .navbar-nav {
        margin-bottom: 0; /* Remove bottom margin to push buttons to the bottom */
    }
    .btn-secondary {
        background-color: #800000; /* Maroon color */
        border-color: #800000; /* Maroon color */
        transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #b30000; /* Lightened maroon color on hover */
        border-color: #b30000; /* Lightened maroon color on hover */
    }
    .btn-primary {
        background-color: #800000; /* Maroon color */
        border-color: #800000; /* Maroon color */
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #b30000; /* Lightened maroon color on hover */
        border-color: #b30000; /* Lightened maroon color on hover */
    }
    .alert {
        transition: opacity 0.5s ease;
    }
    /* Subject Row */
    .subject-row {
        transition: transform 0.3s ease;
    }
    .subject-row:hover {
        transform: scale(1.02);
    }
    form {
        border: 1px solid #800000; /* Maroon border for form container */
        border-radius: 10px; /* Rounded corners for form container */
        background-color: #f8f0f0; /* Light background for form container */
        padding: 20px; /* Add padding inside the form container */
    }
    .form-control {
        border: 1px solid #800000; /* Maroon border for input fields */
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus {
        border-color: #b30000; /* Lightened maroon border on focus */
        box-shadow: 0 0 0 0.2rem rgba(179, 0, 0, 0.25);
        outline: none;
    }
    h1 {
        color: #800000; /* Maroon color for heading */
    }
    </style>
</head>
<body class="container mt-5">
<nav class="navbar navbar-expand-lg">
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
    <br><br>
    <h1 class="text-center mb-4">Add Certificate</h1>
    <form action="add_certificate.php" method="POST" class="p-4 border rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID:</label>
            <input type="number" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
        </div>
        <div class="mb-3">
            <label for="certificate_name" class="form-label">Certificate Name:</label>
            <input type="text" class="form-control" id="certificate_name" name="certificate_name" placeholder="Enter Certificate Name" required>
        </div>
        <div class="mb-3">
            <label for="issued_date" class="form-label">Issued Date:</label>
            <input type="date" class="form-control" id="issued_date" name="issued_date" required>
        </div>
        <h5>Subjects and Marks</h5>
        <div id="subject-list">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="subject[]" class="form-control" placeholder="Subject Name" required>
                </div>
                <div class="col-md-6">
                    <input type="number" name="marks[]" class="form-control" placeholder="Marks" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" onclick="addSubjectRow()">Add More Subjects</button>
        <button type="submit" class="btn btn-primary w-100">Add Certificate</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>