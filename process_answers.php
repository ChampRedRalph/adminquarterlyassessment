<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gradelevel = $_POST['gradelevel'];
    $subject = $_POST['subject'];
    $answers = [];
    for ($i = 1; $i <= 50; $i++) {
        $answers[] = $_POST["a$i"];
    }

    $sql = "INSERT INTO tb_answers (schoolid, division, studname, gradelevel, subject, " . implode(", ", array_map(function($i) { return "a$i"; }, range(1, 75))) . ") VALUES (101010, NULL, 'Answer_Key', ?, ?, " . implode(", ", array_fill(0, 50, "?")) . ", " . implode(", ", array_fill(0, 25, "NULL")) . ")";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(str_repeat('s', 2 + 50), $gradelevel, $subject, ...$answers);
        if ($stmt->execute()) {
            echo "Answers submitted successfully.";
            header("Location: index.php?pg=subj");
        exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}