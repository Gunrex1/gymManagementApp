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

<a href="admin_dashboard.php">Back</a>

<section class="dashboard-content">
        <h2>Registered Trainers</h2>
        <!-- Display Trainer Data -->
        <table border="1">
            <tr>
                <th>Trainer ID</th>
                <th>Trainer Name</th>
                <th>Trainer Skills</th>
                <th>Action</th>
            </tr>
            <?php
            // Display trainer data in the table
            while ($row = $trainerResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['TrainerID'] . "</td>";
                echo "<td>" . $row['TrainerName'] . "</td>";
                echo "<td>" . $row['TrainerSkills'] . "</td>";
                echo "<td><form method='post'><input type='hidden' name='trainer_id_to_delete' value='" . $row['TrainerID'] . "'><input type='submit' name='delete_trainer' value='Delete'></form></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <br>


        <div>
            <h2>Add New Trainers</h2>
            <!-- Add New Trainer Form -->
            <form method="post">
                <label for="new_trainer_name">Trainer Name:</label>
                <input type="text" name="new_trainer_name" required>
                <br>

                <label for="new_trainer_skills">Trainer Skills:</label>
                <input type="text" name="new_trainer_skills" required>
                <br>

                <input type="submit" name="add_trainer" value="Add Trainer">
            </form>
        </div>
        <br>
        <br>
        <!-- Add a logout link -->
<a href="admin_logout.php">Logout</a>

    </section>
</div>



<style>
    div {
        background: rgba(129, 128, 128, 0.8);
        padding: 20px;
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
