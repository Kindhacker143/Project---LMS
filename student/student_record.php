<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #218838;
        }
        #attendanceList {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Student Attendance</h2>
        <form id="attendanceForm">
            <label for="studentID">Student ID:</label>
            <input type="text" id="studentID" required>

            <label for="studentName">Student Name:</label>
            <input type="text" id="studentName" required>

            <label for="courseName">Course Name:</label>
            <input type="text" id="courseName" required>

            <label for="inTime">In Time:</label>
            <input type="time" id="inTime" required>

            <label for="outTime">Out Time:</label>
            <input type="time" id="outTime" required>

            <button type="button" onclick="submitAttendance()">Submit</button>
        </form>

        <div id="attendanceList">
            <h3>Attendance Records</h3>
            <table id="recordTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                    </tr>
                </thead>
                <tbody id="recordBody">
                    <!-- Records will appear here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function submitAttendance() {
            var id = document.getElementById("studentID").value;
            var name = document.getElementById("studentName").value;
            var course = document.getElementById("courseName").value;
            var inTime = document.getElementById("inTime").value;
            var outTime = document.getElementById("outTime").value;

            if (id === "" || name === "" || course === "" || inTime === "" || outTime === "") {
                alert("Please fill all fields.");
                return;
            }

            var table = document.getElementById("recordBody");
            var row = table.insertRow();
            row.insertCell(0).innerText = id;
            row.insertCell(1).innerText = name;
            row.insertCell(2).innerText = course;
            row.insertCell(3).innerText = inTime;
            row.insertCell(4).innerText = outTime;

            document.getElementById("attendanceForm").reset();
        }
    </script>

</body>
</html>