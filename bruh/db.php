<?php
// Create connection
$conn = mysqli_connect("localhost","root","nanatsu#12468","airplane_management");

// Check connection
if (!$conn) {
    // If the connection fails, display an error message and stop the script
    die(mysqli_error($conn));
}
?>
