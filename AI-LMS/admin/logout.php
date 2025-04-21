<?php
// Start the session
session_start();

// Clear all session data
session_unset();
session_destroy();

// Redirect using a relative path
$redirectPage = 'index.php'; // Adjust as needed
header("Location: $redirectPage");
exit();
?>
