<?php
// Include the database connection file
include 'db.php';

// Check if the request method is POST (i.e., form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username, password, and role from the form
    $username = $_POST['username'];
    // Hash the password for security
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // SQL query to insert the user into the users table
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        // If successful, display a success message
        echo "Registration successful.";
    } else {
        // If there's an error, display the error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!-- HTML form for user registration -->
<form method="post" action="register.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Role: 
    <select name="role">
        <option value="admin">Admin</option>
        <option value="passenger">Passenger</option>
        <option value="staff">Staff</option>
    </select><br>
    <input type="submit" value="Register">
</form>
