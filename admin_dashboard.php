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

// Calculate total members
$totalMembersSql = "SELECT COUNT(*) AS totalMembers FROM UserRegistration";
$totalMembersResult = $conn->query($totalMembersSql);
$totalMembersRow = $totalMembersResult->fetch_assoc();
$totalMembers = $totalMembersRow['totalMembers'];

// Calculate total trainers
$totalTrainersSql = "SELECT COUNT(*) AS totalTrainers FROM Trainers";
$totalTrainersResult = $conn->query($totalTrainersSql);
$totalTrainersRow = $totalTrainersResult->fetch_assoc();
$totalTrainers = $totalTrainersRow['totalTrainers'];

// Calculate total bookings
$totalBookingsSql = "SELECT COUNT(*) AS totalBookings FROM Bookings";
$totalBookingsResult = $conn->query($totalBookingsSql);
$totalBookingsRow = $totalBookingsResult->fetch_assoc();
$totalBookings = $totalBookingsRow['totalBookings'];

// Handle adding new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $newMembershipType = $_POST["new_membership_type"];

    // Hash the new password for security
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Insert new user data into the database
    $insertUserSql = "INSERT INTO UserRegistration (Username, Password, MembershipType) VALUES ('$newUsername', '$hashedPassword', '$newMembershipType')";
    $conn->query($insertUserSql);
    header("Location: admin_dashboard.php"); // Refresh the page after adding a new user
    exit();
}

// Handle deleting user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    $userIdToDelete = $_POST["user_id_to_delete"];

    // Delete user data from the database
    $deleteUserSql = "DELETE FROM UserRegistration WHERE UserID = $userIdToDelete";
    $conn->query($deleteUserSql);
    header("Location: admin_dashboard.php"); // Refresh the page after deleting a user
    exit();
}

// Handle adding new trainer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_trainer"])) {
    $newTrainerName = $_POST["new_trainer_name"];
    $newTrainerSkills = $_POST["new_trainer_skills"];

    // Insert new trainer data into the database
    $insertTrainerSql = "INSERT INTO Trainers (TrainerName, TrainerSkills) VALUES ('$newTrainerName', '$newTrainerSkills')";
    $conn->query($insertTrainerSql);
    header("Location: admin_dashboard.php"); // Refresh the page after adding a new trainer
    exit();
}

// Handle deleting trainer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_trainer"])) {
    $trainerIdToDelete = $_POST["trainer_id_to_delete"];

    // Delete trainer data from the database
    $deleteTrainerSql = "DELETE FROM Trainers WHERE TrainerID = $trainerIdToDelete";
    $conn->query($deleteTrainerSql);
    header("Location: admin_dashboard.php"); // Refresh the page after deleting a trainer
    exit();
}

// Display the admin dashboard content
include 'header.php';
?>

<!-- Admin Dashboard Content -->
<div class="dashboard-container">
    
    <!-- Left-side navigation menu -->
    <nav class="dashboard-nav">
    <h2>Admin Dashboard:</h2>

        <ul>
            <li><a href="members.php"> Members</a></li>
            <li><a href="trainers.php"> Trainers</a></li>
            <li><a href="bookings.php">See Bookings</a></li>
        </ul>
    </nav>
    
    <!-- Right-side content area -->
    <section class="dashboard-content">

    <h2>Registered Members</h2>
        <p>Total Members: <?php echo $totalMembers; ?></p>

        <h2>Registered Trainers</h2>
        <p>Total Trainers: <?php echo $totalTrainers; ?></p>

        <h2>Bookings of trainers by members</h2>
        <p>Total Bookings: <?php echo $totalBookings; ?></p>

        
    </section>
</div>

<br>
<!-- Add a logout link -->
<a href="admin_logout.php">Logout</a>

<style>
    div {
        background: rgba(129, 128, 128, 0.8);
        padding: 20px;
        width: 70%;
        height: 50%;
        border-radius: 10px;
        text-align: center;
        filter: blur(0.2px);
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
        filter: blur(0.2px);
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
        flex: 1;
        padding: 20px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        filter: blur(0.2px);
        color: #333; /* Adjust the text color as needed */
    }
</style>

<?php
// Close the database connection
$conn->close();
?>
