// Predefined user credentials (example)
const users = [
    { username: "testuser", password: "password123" },
    { username: "admin", password: "admin123" }
];

// Login button event listener
document.getElementById("login-btn").addEventListener("click", function () {
    const username = document.getElementById("login-username").value;
    const password = document.getElementById("login-password").value;

    // Check credentials
    const user = users.find(user => user.username === username && user.password === password);

    if (user) {
        alert("Login successful!");
        // Redirect to homepage
        window.location.href = "index.html";
    } else {
        alert("Invalid username or password. Please try again.");
    }
});
