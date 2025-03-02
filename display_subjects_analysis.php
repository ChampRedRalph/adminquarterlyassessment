<?php
// Include the database connection file
include 'roxcon.php';

// Fetch data from the subjects table
if (isset($_GET['s'])) {
    $subjectarea = $conn->real_escape_string($_SESSION["subjectarea"]); // Sanitize session input
    $query = "SELECT * FROM subjects WHERE `subject` LIKE '%$subjectarea%' AND `quarter` = 2 ORDER BY `file` ASC, gradelevel ASC";
} else {
    $subjectarea = $conn->real_escape_string($_SESSION["subjectarea"]); // Sanitize session input
    // $query = "SELECT * FROM tbn WHERE `subject` LIKE '%$subjectarea%' AND `quarter` = 2  ORDER BY `file` ASC, gradelevel ASC";
    $query = "SELECT DISTINCT (SUBJECT) FROM `tb_analysis` WHERE `subject` LIKE '%$subjectarea%' ORDER BY SUBJECT ASC"; 
}
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}


// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Subjects</title>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php 
                                           if (!empty($_GET['message'])) {
                                           echo '<div class="alert alert-danger">' . $_GET['message'] . '</div>';
                                        }
                                        ?>    

    <div class="container mt-5">
        <h2 class="mb-4">
            
        <!-- Topbar Search -->

<!-- <form method="get" action="index.php"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="hidden" name="pg" value="subj" >
                            <input name="s" type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
        
                    <?php if (isset($_SESSION["office"]) && $_SESSION["office"] === "Region"): ?>
                    <?php endif; ?>
        Subjects</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Grade Level</th>
                    <th class="text-center">Subject</th>
                    <th class="text-center">Analysis</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo ++$row_number; ?></td>
                            <td  class="text-center"><?php echo htmlspecialchars($row['gradelevel']); ?></td>
                            <td><?php 
                            $newString = substr($row['SUBJECT'], 0, -4);
                            echo htmlspecialchars($newString); ?></td>
                            <td>
                                 <a href="<?php echo "/RUQAanalysis/competencyperdivisionv2.php?subject=" 
                                        . urlencode($row["SUBJECT"]) 
                                        . "&division=" 
                                        . urlencode($_SESSION["office"]); ?>" 
                                    target="_blank" class="btn btn-info btn-sm">
                                    Analysis
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>
</html>