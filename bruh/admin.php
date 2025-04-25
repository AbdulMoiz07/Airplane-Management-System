<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Connect to the database
$mysqli = new mysqli("localhost", "username", "password", "database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle add/edit/delete operations for flights, passengers, and staff
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add_flight') {
            // Add flight
            $flightNumber = $_POST['flightNumber'];
            $origin = $_POST['origin'];
            $destination = $_POST['destination'];
            $status = 'On Time';
            $stmt = $mysqli->prepare("INSERT INTO flights (flightNumber, origin, destination, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $flightNumber, $origin, $destination, $status);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'edit_flight') {
            // Edit flight
            $id = $_POST['id'];
            $flightNumber = $_POST['flightNumber'];
            $origin = $_POST['origin'];
            $destination = $_POST['destination'];
            $stmt = $mysqli->prepare("UPDATE flights SET flightNumber=?, origin=?, destination=? WHERE id=?");
            $stmt->bind_param("sssi", $flightNumber, $origin, $destination, $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'delete_flight') {
            // Delete flight
            $id = $_POST['id'];
            $stmt = $mysqli->prepare("DELETE FROM flights WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'add_passenger') {
            // Add passenger
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $flightNumber = $_POST['flightNumber'];
            $seatNumber = $_POST['seatNumber'];
            $stmt = $mysqli->prepare("INSERT INTO passengers (name, email, phone, flightNumber, seatNumber) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $flightNumber, $seatNumber);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'edit_passenger') {
            // Edit passenger
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $flightNumber = $_POST['flightNumber'];
            $seatNumber = $_POST['seatNumber'];
            $stmt = $mysqli->prepare("UPDATE passengers SET name=?, email=?, phone=?, flightNumber=?, seatNumber=? WHERE id=?");
            $stmt->bind_param("sssssi", $name, $email, $phone, $flightNumber, $seatNumber, $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'delete_passenger') {
            // Delete passenger
            $id = $_POST['id'];
            $stmt = $mysqli->prepare("DELETE FROM passengers WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'add_staff') {
            // Add staff
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $position = $_POST['position'];
            $department = $_POST['department'];
            $stmt = $mysqli->prepare("INSERT INTO staff (name, email, phone, position, department) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $position, $department);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'edit_staff') {
            // Edit staff
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $position = $_POST['position'];
            $department = $_POST['department'];
            $stmt = $mysqli->prepare("UPDATE staff SET name=?, email=?, phone=?, position=?, department=? WHERE id=?");
            $stmt->bind_param("sssssi", $name, $email, $phone, $position, $department, $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'delete_staff') {
            // Delete staff
            $id = $_POST['id'];
            $stmt = $mysqli->prepare("DELETE FROM staff WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch records for display
$flights = $mysqli->query("SELECT * FROM flights")->fetch_all(MYSQLI_ASSOC);
$passengers = $mysqli->query("SELECT * FROM passengers")->fetch_all(MYSQLI_ASSOC);
$staff = $mysqli->query("SELECT * FROM staff")->fetch_all(MYSQLI_ASSOC);

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .blur-background {
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <div id="flights" class="mt-4">
        <h2>Manage Flights</h2>
        <form method="POST" id="flightForm" class="blur-background p-3">
            <input type="hidden" name="action" id="flightAction" value="add_flight">
            <input type="hidden" name="id" id="flightId">
            <div class="form-group">
                <label for="flightNumber">Flight Number</label>
                <input type="text" class="form-control" id="flightNumber" name="flightNumber">
            </div>
            <div class="form-group">
                <label for="origin">Origin</label>
                <input type="text" class="form-control" id="origin" name="origin">
            </div>
            <div class="form-group">
                <label for="destination">Destination</label>
                <input type="text" class="form-control" id="destination" name="destination">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>Flight Number</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($flights as $flight): ?>
                <tr>
                    <td><?php echo $flight['flightNumber']; ?></td>
                    <td><?php echo $flight['origin']; ?></td>
                    <td><?php echo $flight['destination']; ?></td>
                    <td><?php echo $flight['status']; ?></td>
                    <td>
                        <button class="btn btn-warning" onclick="editFlight(<?php echo $flight['id']; ?>)">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete_flight">
                            <input type="hidden" name="id" value="<?php echo $flight['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="passengers" class="mt-4">
        <h2>Manage Passengers</h2>
        <form method="POST" id="passengerForm" class="blur-background p-3">
            <input type="hidden" name="action" id="passengerAction" value="add_passenger">
            <input type="hidden" name="id" id="passengerId">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="flightNumber">Flight Number</label>
                <input type="text" class="form-control" id="flightNumber" name="flightNumber">
            </div>
            <div class="form-group">
                <label for="seatNumber">Seat Number</label>
                <input type="text" class="form-control" id="seatNumber" name="seatNumber">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Flight Number</th>
                <th>Seat Number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($passengers as $passenger): ?>
                <tr>
                    <td><?php echo $passenger['name']; ?></td>
                    <td><?php echo $passenger['email']; ?></td>
                    <td><?php echo $passenger['phone']; ?></td>
                    <td><?php echo $passenger['flightNumber']; ?></td>
                    <td><?php echo $passenger['seatNumber']; ?></td>
                    <td>
                        <button class="btn btn-warning" onclick="editPassenger(<?php echo $passenger['id']; ?>)">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete_passenger">
                            <input type="hidden" name="id" value="<?php echo $passenger['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="staff" class="mt-4">
        <h2>Manage Staff</h2>
        <form method="POST" id="staffForm" class="blur-background p-3">
            <input type="hidden" name="action" id="staffAction" value="add_staff">
            <input type="hidden" name="id" id="staffId">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" class="form-control" id="position" name="position">
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" id="department" name="department">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($staff as $staff_member): ?>
                <tr>
                    <td><?php echo $staff_member['name']; ?></td>
                    <td><?php echo $staff_member['email']; ?></td>
                    <td><?php echo $staff_member['phone']; ?></td>
                    <td><?php echo $staff_member['position']; ?></td>
                    <td><?php echo $staff_member['department']; ?></td>
                    <td>
                        <button class="btn btn-warning" onclick="editStaff(<?php echo $staff_member['id']; ?>)">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete_staff">
                            <input type="hidden" name="id" value="<?php echo $staff_member['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
function editFlight(id) {
    // Get flight details and populate the form
    var flight = <?php echo json_encode($flights); ?>.find(f => f.id == id);
    document.getElementById('flightId').value = flight.id;
    document.getElementById('flightNumber').value = flight.flightNumber;
    document.getElementById('origin').value = flight.origin;
    document.getElementById('destination').value = flight.destination;
    document.getElementById('flightAction').value = 'edit_flight';
}

function editPassenger(id) {
    // Get passenger details and populate the form
    var passenger = <?php echo json_encode($passengers); ?>.find(p => p.id == id);
    document.getElementById('passengerId').value = passenger.id;
    document.getElementById('name').value = passenger.name;
    document.getElementById('email').value = passenger.email;
    document.getElementById('phone').value = passenger.phone;
    document.getElementById('flightNumber').value = passenger.flightNumber;
    document.getElementById('seatNumber').value = passenger.seatNumber;
    document.getElementById('passengerAction').value = 'edit_passenger';
}

function editStaff(id) {
    // Get staff details and populate the form
    var staff = <?php echo json_encode($staff); ?>.find(s => s.id == id);
    document.getElementById('staffId').value = staff.id;
    document.getElementById('name').value = staff.name;
    document.getElementById('email').value = staff.email;
    document.getElementById('phone').value = staff.phone;
    document.getElementById('position').value = staff.position;
    document.getElementById('department').value = staff.department;
    document.getElementById('staffAction').value = 'edit_staff';
}
</script>
</body>
</html>
