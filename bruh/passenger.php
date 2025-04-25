<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'passenger') {
    header("Location: login.php");
    exit();
}

// Connect to the database
$mysqli = new mysqli("localhost", "username", "password", "database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch passenger details
$email = $_SESSION['email'];
$stmt = $mysqli->prepare("SELECT * FROM passengers WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$passenger = $result->fetch_assoc();

$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .blur-background {
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
<div class="container mt-5 blur-background p-3">
    <h1>Passenger Dashboard</h1>
    <div class="mt-4">
        <h2>Your Details</h2>
        <table class="table">
            <tr>
                <th>Name</th>
                <td><?php echo $passenger['name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $passenger['email']; ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo $passenger['phone']; ?></td>
            </tr>
            <tr>
                <th>Flight Number</th>
                <td><?php echo $passenger['flightNumber']; ?></td>
            </tr>
            <tr>
                <th>Seat Number</th>
                <td><?php echo $passenger['seatNumber']; ?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
