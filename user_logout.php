<?php
// Start the session (if not already started)
session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page after logout
header("Location: login.html");
exit();
?>
