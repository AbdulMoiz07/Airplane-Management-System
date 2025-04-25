<?php
// Include the database connection file
include 'db.php';

// Check if the request method is POST (i.e., form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username, password, and role from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // SQL query to select the user from the users table
    $sql = "SELECT * FROM users WHERE username='$username' AND role='$role'";
    $result = $conn->query($sql);

    // Check if a user with the given username and role exists
    if ($result->num_rows > 0) {
        // Fetch the user details
        $row = $result->fetch_assoc();
        // Verify the submitted password against the stored hashed password
        if (password_verify($password, $row['password'])) {
            // If the password is correct, display a success message
            echo "Login successful.";
            // Redirect to the appropriate dashboard based on the user's role
            if ($role == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($role == 'passenger') {
                header("Location: passenger_dashboard.php");
            } elseif ($role == 'staff') {
                header("Location: staff_dashboard.php");
            }
        } else {
            // If the password is incorrect, display an error message
            echo "Invalid password.";
        }
    } else {
        // If no user with the given username and role is found, display an error message
        echo "No user found.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!-- HTML form for user login -->
<form method="post" action="login.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Role: 
    <select name="role">
        <option value="admin">Admin</option>
        <option value="passenger">Passenger</option>
        <option value="staff">Staff</option>
    </select><br>
    <input type="submit" value="Login">
</form>
