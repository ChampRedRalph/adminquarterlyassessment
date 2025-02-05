<?php
// Include the database connection file
include 'roxcon.php';

// Fetch data from the subjects table
if (isset($_GET['s'])) {
    $subjectarea = $conn->real_escape_string($_SESSION["subjectarea"]); // Sanitize session input
    $query = "SELECT * FROM subjects WHERE `subject` LIKE '%$subjectarea%' ORDER BY quarter DESC, gradelevel ASC";
} else {
    $subjectarea = $conn->real_escape_string($_SESSION["subjectarea"]); // Sanitize session input
    $query = "SELECT * FROM subjects WHERE `subject` LIKE '%$subjectarea%' ORDER BY quarter DESC, gradelevel ASC";
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
<form method="get" action="index.php"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="hidden" name="pg" value="subj" >
                            <input name="s" type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <!-- <input type="submit"> -->
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
        
        
                    <?php if (isset($_SESSION["office"]) && $_SESSION["office"] === "Region"): ?>
                     <a href="index.php?pg=subjadd" class="btn btn-primary btn-sm">Add</a>
                    <?php endif; ?>
        Subjects</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Grade Level</th>
                    <th class="text-center">Subject</th>
                    <th class="text-center">Analysis</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo ++$row_number; ?></td>
                            <td  class="text-center"><?php echo htmlspecialchars($row['gradelevel']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td>
                                <!-- <a href="<?php echo "http://122.3.185.245:8081/RUQAanalysis/competencyperdivision.php?subject=" 
                                        . urlencode($row["file"]) 
                                        . "&division=" 
                                        . urlencode($_SESSION["office"]); ?>" 
                                    target="_blank" class="btn btn-info btn-sm">
                                    Analysis
                                </a> -->
                            </td>
                            <td>
                                <?php if ($row['file']): ?>
                                    <a href="<?php echo "questionaire/".htmlspecialchars($row['file']); ?>" target="_blank" class="btn btn-success btn-sm">View File</a>
                                <?php else: ?>
                                    <strong style="color: red;">
                                        <i class="fas fa-exclamation-triangle"></i> No File
                                    </strong>
                                <?php endif; ?>
                            </td>
                            <td>
                            <?php if (isset($_SESSION["office"]) && $_SESSION["office"] === "Region"): ?>
                                <a href="index.php?pg=subjedit&&id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                 <a href="delete_subject.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No records found</td>
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