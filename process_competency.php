<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare an insert statement
    $sql = "INSERT INTO tb_competencies (studname, gradelevel, subject, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, c21, c22, c23, c24, c25, c26, c27, c28, c29, c30, c31, c32, c33, c34, c35, c36, c37, c38, c39, c40, c41, c42, c43, c44, c45, c46, c47, c48, c49, c50) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssss", $studname, $gradelevel, $subject, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $c21, $c22, $c23, $c24, $c25, $c26, $c27, $c28, $c29, $c30, $c31, $c32, $c33, $c34, $c35, $c36, $c37, $c38, $c39, $c40, $c41, $c42, $c43, $c44, $c45, $c46, $c47, $c48, $c49, $c50);

        // Set parameters
        $studname = "Competency";
        $gradelevel = $_POST['gradelevel'];
        $subject = $_POST['subject'];
        for ($i = 1; $i <= 50; $i++) {
            ${"c$i"} = $_POST["c$i"];
        }

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Records created successfully. Redirect to landing page
            echo "Answers submitted successfully.";
            header("Location: index.php?pg=subj");
        exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}