<?php
// Start the session (if not already started)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
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

// Fetch available trainers
$trainersSql = "SELECT * FROM Trainers";
$trainersResult = $conn->query($trainersSql);

// Handle trainer selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["select_trainer"])) {
    $selectedTrainerID = $_POST["trainer_id"];

    // Insert booking information into the database
    $userID = $_SESSION['user_id'];
    $bookingSql = "INSERT INTO Bookings (UserID, TrainerID) VALUES ($userID, $selectedTrainerID)";
    $conn->query($bookingSql);

    // Optionally, you can display a success message or redirect the user to another page
}

// Handle leaving a trainer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["leave_trainer"])) {
    $userID = $_SESSION['user_id'];

    // Delete booking information from the database for the logged-in user
    $leaveSql = "DELETE FROM Bookings WHERE UserID = $userID";
    $conn->query($leaveSql);

    // Optionally, you can display a success message or refresh the page
}

// Display the user dashboard content
include 'header.php';
?>


<!-- User Dashboard Content -->
<section>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <?php
    // Check if the user has already booked a trainer
    $userID = $_SESSION['user_id'];
    $checkBookingSql = "SELECT * FROM Bookings WHERE UserID = $userID";
    $checkBookingResult = $conn->query($checkBookingSql);

    if ($checkBookingResult->num_rows > 0) {
        // Display information about the booked trainer
        $bookingRow = $checkBookingResult->fetch_assoc();
        $bookedTrainerID = $bookingRow['TrainerID'];

        // Fetch details of the booked trainer
        $trainerDetailsSql = "SELECT TrainerName, TrainerSkills FROM Trainers WHERE TrainerID = $bookedTrainerID";
        $trainerDetailsResult = $conn->query($trainerDetailsSql);

        if ($trainerDetailsResult->num_rows > 0) {
            $trainerDetails = $trainerDetailsResult->fetch_assoc();
            $bookedTrainerName = $trainerDetails['TrainerName'];
            $bookedTrainerSkills = $trainerDetails['TrainerSkills'];

            echo "<p>You have booked Trainer: $bookedTrainerName</p>";
            echo "<p>Trainer Skills: $bookedTrainerSkills</p>";
            echo "<form method='post'><input type='submit' name='leave_trainer' value='Leave Trainer'></form>";
        } else {
            echo "<p>Error fetching trainer details</p>";
        }
    } else {
        // Display the form to select a trainer if not booked
        echo "<p>Select a Trainer:</p>";
        echo "<form method='post'>";
        echo "<select name='trainer_id' required>";
        while ($row = $trainersResult->fetch_assoc()) {
            echo "<option value='" . $row['TrainerID'] . "'>" . $row['TrainerName'] . "</option>";
        }
        echo "</select>";
        echo "<br>";
        echo "<input type='submit' name='select_trainer' value='Select Trainer'>";
        echo "</form>";

        // Display the table of available trainers and their skills
        echo "<p>Available Trainers:</p>";
        echo "<table border='1'>";
        echo "<tr><th>Trainer Name</th><th>Trainer Skills</th></tr>";

        $availableTrainersSql = "SELECT * FROM Trainers";
        $availableTrainersResult = $conn->query($availableTrainersSql);

        while ($row = $availableTrainersResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['TrainerName'] . "</td>";
            echo "<td>" . $row['TrainerSkills'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
</section>
<br>
<!-- Add a logout link -->
<a href="logout.php">Logout</a>

<style>
    a {
        background: rgba(129, 128, 128, 0.8);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        filter: blur(0.2px);
        color: blanchedalmond;
    }

    form {
        background: rgba(129, 128, 128, 0.8);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        filter: blur(0.2px);
        color: blanchedalmond;
    }

    table {
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
