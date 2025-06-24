<?php
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

// Process admin login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminUsername = $_POST["username"];
    $adminPassword = $_POST["password"];

    // Retrieve admin data from the database based on the entered username
    $sql = "SELECT * FROM Admin WHERE Username = '$adminUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the entered password against the stored password
        if ($adminPassword == $row["Password"]) {
            // Start a session (if not already started)
            session_start();

            // Store admin information in the session for future use
            $_SESSION['admin_id'] = $row['AdminID'];
            $_SESSION['admin_username'] = $row['Username'];

            // Redirect to the admin dashboard page
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Admin not found";
    }
}

// Close the database connection
$conn->close();
?>
