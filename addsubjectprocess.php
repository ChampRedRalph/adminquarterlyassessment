<?php
// Include the database connection file
include 'roxcon.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $gradelevel = isset($_POST['gradelevel']) ? intval($_POST['gradelevel']) : null;
    $subject = isset($_POST['subject']) ? $_POST['subject'] : null;
    $quarter = isset($_POST['quarter']) ? $_POST['quarter'] : null;

    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO subjects (gradelevel, subject, quarter) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $gradelevel, $subject, $quarter);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        header("Location: index.php?pg=subj");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
