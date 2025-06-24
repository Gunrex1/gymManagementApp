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

// Handle deleting trainer


// Display the admin dashboard content
include 'header.php';
?>

<a href="admin_dashboard.php">Back</a>
        
    <!-- Right-side content area -->
    <section class="dashboard-content"><br>
        <h2>Registered Members</h2>
        <!-- Display User Data -->
        <table border="1">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Membership Type</th>
                <th>Action</th>
            </tr>
            <?php
            // Display user data in the table
            while ($row = $userResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['MembershipType'] . "</td>";
                echo "<td><form method='post'><input type='hidden' name='user_id_to_delete' value='" . $row['UserID'] . "'><input type='submit' name='delete_user' value='Delete'></form></td>";
                echo "</tr>";
            }
            ?>
        </table>
<br>

        <div>
            <h2>Add New Members</h2>
            <!-- Add New User Form -->
            <form method="post">
                <label for="new_username">Username:</label>
                <input type="text" name="new_username" required>
                <br>

                <label for="new_password">Password:</label>
                <input type="password" name="new_password" required>
                <br>

                <label for="new_membership_type">Membership Type:</label>
                <select name="new_membership_type" required>
                    <option value="Basic">Basic</option>
                    <option value="Premium">Premium</option>
                </select>
                <br>

                <input type="submit" name="add_user" value="Add User">
            </form>
        </div>


<br>
<br>
<!-- Add a logout link -->
<a href="admin_logout.php">Logout</a>

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
