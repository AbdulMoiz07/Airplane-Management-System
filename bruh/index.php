<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airplane Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #000;
        }
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .container {
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            border: 2px solid rgba(255, 255, 255, 0.8);
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .content {
            display: none;
        }
        .content.active {
            display: block;
        }
        .admin-only {
            display: none;
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="video-background">
        <source src="3657467-hd_1920_1080_30fps.mp4" type="video/mp4">
    </video>
    <div class="container mt-5">
        <div id="home" class="content active">
            <h1>Welcome to the Airplane Management System</h1>
            <p>Please log in to access the system.</p>
            <form id="loginForm" action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="admin">Admin</option>
                        <option value="passenger">Passenger</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <button type="button" class="btn btn-secondary btn-block" onclick="showPage('register')">Register</button>
            </form>
        </div>

        <div id="register" class="content">
            <h1>Register</h1>
            <p>Please fill in the details to create an account.</p>
            <form id="registerForm" action="register.php" method="POST">
                <div class="form-group">
                    <label for="regUsername">Username</label>
                    <input type="text" class="form-control" id="regUsername" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="regPassword">Password</label>
                    <input type="password" class="form-control" id="regPassword" name="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="regRole">Role</label>
                    <select class="form-control" id="regRole" name="role">
                        <option value="passenger">Passenger</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <button type="button" class="btn btn-secondary btn-block" onclick="showPage('home')">Back to Login</button>
            </form>
        </div>

        <div id="dashboard" class="content">
            <h1>Dashboard</h1>
            <p>Welcome, <span id="currentRole"></span>!</p>
            <div id="adminOptions" style="display: none;">
                <button class="btn btn-primary btn-block" onclick="showPage('flights')">Manage Flights</button>
                <button class="btn btn-primary btn-block" onclick="showPage('passengers')">Manage Passengers</button>
                <button class="btn btn-primary btn-block" onclick="showPage('staff')">Manage Staff</button>
            </div>
            <div id="passengerOptions" style="display: none;">
                <button class="btn btn-primary btn-block" onclick="showPage('passengers')">Add Passenger Details</button>
            </div>
            <div id="staffOptions" style="display: none;">
                <button class="btn btn-primary btn-block" onclick="showPage('staff')">Add Staff Details</button>
            </div>
            <button class="btn btn-secondary btn-block" onclick="logout()">Logout</button>
        </div>

        <div id="flights" class="content">
            <h1>Manage Flights</h1>
            <form id="flightForm">
                <div class="form-group">
                    <label for="flightNumber">Flight Number</label>
                    <input type="text" class="form-control" id="flightNumber">
                </div>
                <div class="form-group">
                    <label for="origin">Origin</label>
                    <input type="text" class="form-control" id="origin">
                </div>
                <div class="form-group">
                    <label for="destination">Destination</label>
                    <input type="text" class="form-control" id="destination">
                </div>
                <input type="hidden" id="editFlightIndex">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </form>
            <button class="btn btn-secondary btn-block" onclick="showPage('dashboard')">Back to Dashboard</button>
            <table class="table mt-3 admin-only">
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="flightList"></tbody>
            </table>
        </div>

        <div id="passengers" class="content">
            <h1>Manage Passengers</h1>
            <form id="passengerForm">
                <div class="form-group">
                    <label for="passengerName">Name</label>
                    <input type="text" class="form-control" id="passengerName">
                </div>
                <div class="form-group">
                    <label for="passengerEmail">Email</label>
                    <input type="email" class="form-control" id="passengerEmail">
                </div>
                <div class="form-group">
                    <label for="passengerPhone">Phone</label>
                    <input type="text" class="form-control" id="passengerPhone">
                </div>
                <div class="form-group">
                    <label for="passengerFlight">Flight Number</label>
                    <input type="text" class="form-control" id="passengerFlight">
                </div>
                <div class="form-group">
                    <label for="passengerSeat">Seat Number</label>
                    <input type="text" class="form-control" id="passengerSeat">
                </div>
                <input type="hidden" id="editPassengerIndex">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </form>
            <button class="btn btn-secondary btn-block" onclick="showPage('dashboard')">Back to Dashboard</button>
            <table class="table mt-3 admin-only">
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
                <tbody id="passengerList"></tbody>
            </table>
        </div>

        <div id="staff" class="content">
            <h1>Manage Staff</h1>
            <form id="staffForm">
                <div class="form-group">
                    <label for="staffName">Name</label>
                    <input type="text" class="form-control" id="staffName">
                </div>
                <div class="form-group">
                    <label for="staffEmail">Email</label>
                    <input type="email" class="form-control" id="staffEmail">
                </div>
                <div class="form-group">
                    <label for="staffPhone">Phone</label>
                    <input type="text" class="form-control" id="staffPhone">
                </div>
                <div class="form-group">
                    <label for="staffRole">Role</label>
                    <input type="text" class="form-control" id="staffRole">
                </div>
                <input type="hidden" id="editStaffIndex">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </form>
            <button class="btn btn-secondary btn-block" onclick="showPage('dashboard')">Back to Dashboard</button>
            <table class="table mt-3 admin-only">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="staffList"></tbody>
            </table>
        </div>
    </div>

    <script>
        function showPage(page) {
            var pages = document.querySelectorAll('.content');
            pages.forEach(function(p) {
                p.classList.remove('active');
            });
            document.getElementById(page).classList.add('active');
        }

        function logout() {
            showPage('home');
        }

        // JavaScript code for handling the form submissions, editing, and deleting goes here

        // Display the appropriate options based on the role
        function showDashboard(role) {
            document.getElementById('currentRole').innerText = role;
            document.getElementById('adminOptions').style.display = (role === 'admin') ? 'block' : 'none';
            document.getElementById('passengerOptions').style.display = (role === 'passenger') ? 'block' : 'none';
            document.getElementById('staffOptions').style.display = (role === 'staff') ? 'block' : 'none';
        }
    </script>
</body>
</html>
