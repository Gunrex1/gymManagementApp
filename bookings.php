<?php
// Start the session (if not already started)
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html"); // Redirect to admin login page if not logged in
    exit();
}

// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "databasepro";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the UserRegistration table
$userSql = "SELECT * FROM UserRegistration";
$userResult = $conn->query($userSql);

// Fetch trainer data from the Trainers table
$trainerSql = "SELECT * FROM Trainers";
$trainerResult = $conn->query($trainerSql);

// Fetch booking data from the Bookings table
$bookingSql = "SELECT Bookings.*, UserRegistration.Username AS MemberName, Trainers.TrainerName FROM Bookings
               JOIN UserRegistration ON Bookings.UserID = UserRegistration.UserID
               JOIN Trainers ON Bookings.TrainerID = Trainers.TrainerID";
$bookingResult = $conn->query($bookingSql);



// Display the admin dashboard content

?>


<a href="admin_dashboard.php">Back</a>
<!-- Navigation links -->
<br>
<section class="dashboard-content">

<div>
        <h2>Bookings</h2>
        <!-- Display Booking Data -->
        <table border="1">
            <tr>
                <th>Booking ID</th>
                <th>Member Name</th>
                <th>Trainer Name</th>
            </tr>
            <?php
            // Display booking data in the table
            while ($row = $bookingResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['BookingID'] . "</td>";
                echo "<td>" . $row['MemberName'] . "</td>";
                echo "<td>" . $row['TrainerName'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        </div>

        <br>
<br>
<!-- Add a logout link -->
<a href="admin_logout.php">Logout</a>

<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url(modern-home-gym-1024x576.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    position: relative;
}

    div {
    background: rgba(129, 128, 128, 0.8);
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    color: blanchedalmond;
}

a {
    background: rgba(129, 128, 128, 0.8);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        filter: blur(0.2px);
        color: blanchedalmond;
}

.dashboard-container {
    display: flex;
}

.dashboard-nav {
    width: 20%;
    padding: 20px;
    background: rgba(129, 128, 128, 0.8);
    border-radius: 10px;
    color: blanchedalmond;
}

.dashboard-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dashboard-nav li {
    margin-bottom: 10px;
}

.dashboard-content {
    background-color: rgba(255, 255, 255, 0.7); /* Adjust the alpha value (0.0 to 1.0) for transparency */
    
    height: 50%;
    padding: 20px;
    border-radius: 10px;
    color: #333; /* Adjust the text color as needed */
}

table {
    background-color: grey;
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
}
li{
        background: rgba(129, 128, 128, 0.8);
        padding: 20px;
    border-radius: 10px;
    text-align: center;
    filter: blur(0.2px);
       color: blanchedalmond; 
    }
</style>

<?php
// Close the database connection
$conn->close();
?>
