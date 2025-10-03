<?php
session_start();

// Database configuration
$host = 'localhost';  // Replace with your database host
$dbname = 'your_database_name';  // Replace with your database name
$dbuser = 'your_database_username';  // Replace with your database username
$dbpass = 'your_database_password';  // Replace with your database password

try {
    // Create a PDO instance (PHP Data Objects)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there is an error with the connection
    die("Connection failed: " . $e->getMessage());
}

$error = '';

// Handle the login logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Get and sanitize user inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables if credentials are correct
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];

        // Redirect to homepage
        header("Location: index.html");
        exit;
    } else {
        // If login fails
        $error = "Invalid username or password";
    }
}

// Handle the signup logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Get and sanitize user inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL statement to insert the user data into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

        // Redirect to login page after successful signup
        header("Location: login-signup.php");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Register Form</title>
    <!--Boxicons CDN-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

:root{
    --white: #fff;
    --black: #000; 
    --lightBulue: #17a;
}

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.wrapper{
    position: relative;
    width: 750px;
    height: 450px;
    background: var(--white);
    border: 2px solid var(--black);
    border-radius: 10px;
    box-shadow: 0 0 20px var(--black);
    overflow: hidden;
}

.wrapper .form-box{
    position: absolute;
    top: 0;
    width: 50%;
    height: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
}

.wrapper .form-box.login{
    left: 0;
    padding: 0 60px 0 40px;
}

.form-box h2{
    margin-bottom: 10px;
    position: relative;
    font-size: 32px;
    color: var(--black);
    text-align: center;
}

.form-box h2::after{
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 4px;
    background: var(--black);
}

.form-box .input-box{
    position: relative;
    width: 100%;
    height: 50px;
    margin: 25px 0;
}

.input-box input{
    width: 100%;
    height: 100%;
    background: transparent;
    color: var(--black);
    font-size: 16px;
    font-weight: 500;
    border: none;
    outline: none;
    border-bottom: 2px solid var(--black);
    transition: .5s;
    padding-right: 23px;
}

.input-box input:focus,
.input-box input:valid{
    border-bottom-color: var(--Black);
}

.input-box label{
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    font-size: 16px;
    color: var(--black);
    pointer-events: none;
    transition: 0.5s;
}

.input-box input:focus~label,
.input-box input:valid~label{
    top: -5px;
    color: var(--Black);
}

.input-box i{
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    font-size: 18px;
    transition: 0.5s;
}

.input-box input:focus~i,
.input-box input:valid~i{
    color: var(--Black);
}

form button{
    width: 100%;
    height: 45px;
    background-color: var(--black);
    color: var(--white);
    border: none;
    outline: none;
    border-radius: 40px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: .3s;
}

form button:hover{
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
}

form .linkTxt{
    font-size: 14px;
    color: var(--black);
    text-align: center;
    margin: 20px 0 10px;
}

.linkTxt p a{
    color: black;
    text-decoration: none;
    font-weight: 600;
}

</style>
<body>
    <div class="wrapper">
        <span class="rotate-bg"></span>
        <span class="rotate-bg2"></span>

        <!-- Login Form -->
        <div class="form-box login">
            <h2 class="title animation" style="--i:0; --j:21">Login</h2>
            <form action="login-signup.php" method="POST">
                <div class="input-box animation" style="--i:1; --j:22">
                    <input type="text" name="username" required>
                    <label for="">Username</label>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box animation" style="--i:2; --j:23">
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <button type="submit" name="login" class="btn animation" style="--i:3; --j:24">Login</button>

                <div class="linkTxt animation" style="--i:5; --j:25">
                    <p>Don't have an account? <a href="login-signup.php#signup" class="register-link">Sign Up</a></p>
                </div>

                <?php if (isset($error) && $error !== ''): ?>
                    <div class="error-message" style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="form-box register" id="signup">
            <h2 class="title animation" style="--i:17; --j:0">Sign Up</h2>
            <form action="login-signup.php" method="POST">
                <div class="input-box animation" style="--i:18; --j:1">
                    <input type="text" name="username" required>
                    <label for="">Username</label>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box animation" style="--i:19; --j:2">
                    <input type="email" name="email" required>
                    <label for="">Email</label>
                    <i class='bx bxs-envelope' ></i>
                </div>

                <div class="input-box animation" style="--i:20; --j:3">
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                    <i class='bx bxs-lock-alt' ></i>
                </div>

                <button type="submit" name="signup" class="btn animation" style="--i:21;--j:4">Sign Up</button>

                <div class="linkTxt animation" style="--i:22; --j:5">
                    <p>Already have an account? <a href="login-signup.php" class="login-link">Login</a></p>
                </div>
            </form>
        </div>

    </div>

<script src="app.js"></script>
</body>
</html>
