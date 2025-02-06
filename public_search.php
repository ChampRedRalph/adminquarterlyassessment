<?php
// Include the database connection file
include 'roxcon.php';

// Fetch data from the subjects table

if(isset($_GET['s'])){
    $search = preg_replace('/[^a-zA-Z0-9\s.,]/', '', $_GET['s']);
    $query = "SELECT ID,schoolid, studname,a51, gradelevel, `subject`, created_at  FROM tb_answers  where schoolid!= 101010 and (`schoolid` like '%$search%' or `studname` like '%$search%') limit 20";
}else{
    $query = "SELECT ID,schoolid, studname,a51,gradelevel, `subject`, created_at  FROM tb_answers WHERE 1=0";
}
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Examinees</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
<form method="get" action="public_search.php"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="hidden" name="pg" value="subj" >
                            <input name="s" type="text" class="form-control bg-light border-0 small" placeholder="Student Name"
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <!-- <input type="submit"> -->
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    Display Examinees</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>School ID</th>
                    <th>Student Name</th>
                    <th>Grade Level</th>
                    <th>Subject Taken</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php
                    $i=1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row['schoolid']); ?></td>
                            <td><?php echo htmlspecialchars($row['studname']); ?></td>
                            <td><?php echo htmlspecialchars($row['gradelevel']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']);?></td>
                        </tr>
                        <?php $i++; // Increment $i for each row ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
