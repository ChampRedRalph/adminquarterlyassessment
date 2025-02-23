<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$current_password = $new_password = $confirm_password = "";
$current_password_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate current password
    if (empty(trim($_POST["current_password"]))) {
        $current_password_err = "Please enter your current password.";
    } else {
        $current_password = trim($_POST["current_password"]);
    }

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter a new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have at least 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if (empty($current_password_err) && empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare a select statement
        $sql = "SELECT password FROM users WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if user exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($current_password, $hashed_password)) {
                            // Password is correct, so update the password
                            $sql = "UPDATE users SET password = ? WHERE id = ?";

                            if ($stmt = $conn->prepare($sql)) {
                                // Bind variables to the prepared statement as parameters
                                $stmt->bind_param("si", $param_password, $param_id);

                                // Set parameters
                                $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash

                                // Attempt to execute the prepared statement
                                if ($stmt->execute()) {
                                    // Password updated successfully. Destroy the session, and redirect to login page
                                    // session_destroy();
                                    header("location: index.php?message=Record updated successfully");
                                    exit();
                                } else {
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                            }
                        } else {
                            // Display an error message if current password is not valid
                            $current_password_err = "The current password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if user doesn't exist
                    echo "Oops! Something went wrong. Please try again later.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>