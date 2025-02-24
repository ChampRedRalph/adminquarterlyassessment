<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

// Fetch data from the tb_answers table
$schoolid = isset($_SESSION["schoolid"]) ? $_SESSION["schoolid"] : '';

if (isset($_GET['s'])) {
    $search = preg_replace('/[^a-zA-Z0-9\s.,]/', '', $_GET['s']);
    if (!empty($schoolid)) {
        $query = "SELECT schoolid, studname, gradelevel, `subject`, a51 
                  FROM tb_answers 
                  WHERE schoolid != 101010 AND schoolid = '$schoolid'
                  ORDER BY studname DESC";
    } else {
        $query = "SELECT schoolid, studname, gradelevel, `subject`, a51 
                  FROM tb_answers 
                  WHERE schoolid != 101010 AND schoolid = '$schoolid'
                  ORDER BY studname DESC";
    }
} else {
    if (!empty($schoolid)) {
        $query = "SELECT schoolid, studname, gradelevel, `subject`, a51 
                  FROM tb_answers 
                  WHERE schoolid != 101010";
    } else {
        $query = "SELECT schoolid, studname, gradelevel, `subject`, a51 
                  FROM tb_answers 
                  WHERE schoolid != 101010";
    }
}

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Set the headers to force download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=student_scores.csv');

// Open the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('SchooldID','Student Name', 'Grade Level', 'Subject', 'Score'));

// Fetch and output the data rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>