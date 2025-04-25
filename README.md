## Description
The **Airplane Management System** is a web-based application designed to manage flight bookings, staff, passengers, and flight schedules. This system allows users to manage and interact with flight-related data, including booking, check-in, and viewing available flights. It’s designed for easy management of an airline's daily operations.

## Features
- **Flight Booking**: Allows passengers to book flights by selecting available routes.
- **Staff Management**: Admins can manage staff members and assign them to flights.
- **Passenger Information**: Manage passenger details, flight history, and check-in status.
- **Flight Schedule**: View and manage available flight schedules and routes.
- **Admin Dashboard**: A centralized control panel for managing staff, passengers, and flights.

## Software Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP (for server-side scripting)
- **Database**: MySQL (for storing passenger, flight, and staff data)
- **Multimedia**: Images and videos to enhance the user experience

## Setup Instructions

### Prerequisites
Before running this system, make sure you have the following installed on your machine:
1. **PHP**: Make sure PHP is installed and configured on your system. You can download it from [php.net](https://www.php.net/).
2. **MySQL**: You’ll need a MySQL server running. Download and install MySQL from [mysql.com](https://www.mysql.com/).
3. **XAMPP/WAMP** (optional): To make the setup easier, you can use software like XAMPP or WAMP that installs PHP, Apache, and MySQL together.

### Installation Steps
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/AbdulMoiz07/Airplane-Management-System.git
   ```

2. **Set Up the Database**:
   - Open **phpMyAdmin** (or MySQL CLI) and create a new database called `airplane_management`.
   - Run the SQL queries from the provided `db.sql` file to set up the tables and initial data.

3. **Configure Your Application**:
   - Inside the `bruh/` folder, configure the `db.php` file with your database credentials (host, username, password, and database name).
   - Example:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "airplane_management";
     ```

4. **Start Your Server**:
   - If you're using **XAMPP/WAMP**, simply start the Apache and MySQL services.
   - If you're using your own server setup, make sure both Apache and MySQL are running.

5. **Access the Application**:
   - Open your browser and go to `http://localhost/airplane-management-system/` (or the folder path where you placed the project).

## Usage
Once you have the system set up, you can start:
- Registering new passengers
- Booking flights for passengers
- Managing flight schedules
- Adding new staff members and assigning them to flights

## Contributing
Feel free to fork the repository and contribute to the development of the project. If you find bugs or want to add new features, please create a pull request. Contributions are always welcome!

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

-
