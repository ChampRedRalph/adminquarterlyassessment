<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

// Initialize the session
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the status of the RUQA exam from the form
    $ruqa_exam_status = isset($_POST['ruqa_exam']) ? 1 : 0;

    // Get the status of the CBRAT exam from the form
    $cbrat_exam_status = isset($_POST['cbrat_exam']) ? 1 : 0;

    // Update the status of the RUQA exam in the database
    $sql_update_ruqa = "UPDATE tb_settings SET status = ? WHERE id = 2";
    $stmt_ruqa = $conn->prepare($sql_update_ruqa);
    $stmt_ruqa->bind_param("i", $ruqa_exam_status);
    if (!$stmt_ruqa->execute()) {
        die("Error updating RUQA exam status: " . $stmt_ruqa->error);
    }
    $stmt_ruqa->close();

    // Update the status of the CBRAT exam in the database
    $sql_update_cbrat = "UPDATE tb_settings SET status = ? WHERE id = 1";
    $stmt_cbrat = $conn->prepare($sql_update_cbrat);
    $stmt_cbrat->bind_param("i", $cbrat_exam_status);
    if (!$stmt_cbrat->execute()) {
        die("Error updating CBRAT exam status: " . $stmt_cbrat->error);
    }
    $stmt_cbrat->close();

    // Redirect back to the dashboard with a success message
    header("Location: index.php?message=Exam settings updated successfully");
    exit();
} else {
    // If the form was not submitted, redirect back to the dashboard
    header("Location: index.php");
    exit();
}

// Close the database connection
$conn->close();
?>