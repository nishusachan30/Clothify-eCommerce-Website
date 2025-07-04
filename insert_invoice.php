<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("includes/db.php"); // Include database connection

// Retrieve invoice number from session, default to 'N/A' if not set
$invoiceNo = isset($_SESSION['invoiceNo']) ? $_SESSION['invoiceNo'] : 'N/A';

try {
    // Check if invoice number is available
    if ($invoiceNo !== 'N/A') {
        // Prepare an SQL statement for insertion to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO customer_order (invoice_no) VALUES (?)");
        if ($stmt === false) {
            throw new Exception("Failed to prepare the SQL statement: " . $con->error);
        }

        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $invoiceNo);
        if ($stmt->execute()) {
            echo "<p class='text-success'>Invoice number inserted successfully.</p>"; // Success message
        } else {
            throw new Exception("Failed to execute the query: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        // If no invoice number is available, display a message
        echo "<p class='text-warning'>No invoice number available.</p>";
    }
} catch (Exception $e) {
    // Catch any exceptions and display a user-friendly error message
    echo "<p class='text-danger'>An error occurred: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
