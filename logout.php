<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("includes/db.php"); // Ensure database connection is included
include("functions/functions.php"); // Include functions to use getUserIP()

try {
    // Check if the user is logged in (session has 'cust_id')
    if (isset($_SESSION['cust_id'])) {
        // If the user is logged in, clear the cart using the cust_id
        $cust_id = $_SESSION['cust_id'];

        // Prepare and execute SQL query to clear the cart for the logged-in user
        $stmt = $con->prepare("DELETE FROM cart WHERE cust_id = ?");
        if ($stmt === false) {
            throw new Exception("Failed to prepare the SQL statement: " . $con->error);
        }

        $stmt->bind_param("i", $cust_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute the query for logged-in user: " . $stmt->error);
        }

        $stmt->close(); // Close the statement
    } else {
        // If the user is a guest, clear the cart using the user's IP address
        $ip_add = getUserIP(); // Fetch user IP address using the getUserIP() function from functions.php

        // Prepare and execute SQL query to clear the cart for guest user
        $stmt = $con->prepare("DELETE FROM cart WHERE ip_add = ?");
        if ($stmt === false) {
            throw new Exception("Failed to prepare the SQL statement for guest user: " . $con->error);
        }

        $stmt->bind_param("s", $ip_add);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute the query for guest user: " . $stmt->error);
        }

        $stmt->close(); // Close the statement
    }

    // Destroy session to log out the user
    session_destroy();

    // Redirect to the home page after logging out
    echo "<script>alert('You are logged out!');</script>";
    echo "<script>window.open('index.php', '_self');</script>";

} catch (Exception $e) {
    // Catch and handle any exceptions
    error_log("Error: " . $e->getMessage()); // Log the error for debugging
    echo "<p class='text-danger'>An unexpected error occurred. Please try again later.</p>"; // User-friendly message
}
?>
