<?php
// Include the database connection file
include 'roxcon.php';

// Fetch data from the subjects table

if(isset($_GET['s'])){
    $search = preg_replace('/[^a-zA-Z0-9\s.,]/', '', $_GET['s']);
    $query = "SELECT ID,schoolid, studname,a51, gradelevel, `subject`, created_at    FROM tb_answers  where schoolid!= 101010 and (`schoolid` like '%$search%' or `studname` like '%$search%') limit 20";
}else{
    $query = "SELECT ID,schoolid, studname,a51,gradelevel, `subject`, created_at   FROM tb_answers where schoolid != 101010 order by `ID` desc limit 20";
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
<form method="get" action="index.php"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="hidden" name="pg" value="search" >
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
        Student Scores</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>School ID</th>
                    <th>Student Name</th>
                    <th>SCORE</th>
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
                                <?php 
                                if(isset($row['a51'])){
                            echo "<td>".htmlspecialchars($row['a51'])."</td>";
                                }else{
                            set_time_limit(200);
                            $checkquery="SELECT	( 
                                        IF ( learner.a1 = answer_key.a1, 1, 0 ) +
                                    	IF ( learner.a2 = answer_key.a2, 1, 0 ) +
                                    	IF ( learner.a3 = answer_key.a3, 1, 0 ) +
                                    	IF ( learner.a4 = answer_key.a4, 1, 0 ) +
                                    	IF ( learner.a5 = answer_key.a5, 1, 0 ) +
                                    	IF ( learner.a6 = answer_key.a6, 1, 0 ) +
                                    	IF ( learner.a7 = answer_key.a7, 1, 0 ) +
                                    	IF ( learner.a8 = answer_key.a8, 1, 0 ) +
                                    	IF ( learner.a9 = answer_key.a9, 1, 0 ) +
                                    	IF ( learner.a10 = answer_key.a10, 1, 0 ) +
                                    	IF ( learner.a11 = answer_key.a11, 1, 0 ) +
                                    	IF ( learner.a12 = answer_key.a12, 1, 0 ) +
                                    	IF ( learner.a13 = answer_key.a13, 1, 0 ) +
                                    	IF ( learner.a14 = answer_key.a14, 1, 0 ) +
                                    	IF ( learner.a15 = answer_key.a15, 1, 0 ) +
                                    	IF ( learner.a16 = answer_key.a16, 1, 0 ) +
                                    	IF ( learner.a17 = answer_key.a17, 1, 0 ) +
                                    	IF ( learner.a18 = answer_key.a18, 1, 0 ) +
                                    	IF ( learner.a19 = answer_key.a19, 1, 0 ) +
                                    	IF ( learner.a20 = answer_key.a20, 1, 0 ) +
                                    	IF ( learner.a21 = answer_key.a21, 1, 0 ) +
                                    	IF ( learner.a22 = answer_key.a22, 1, 0 ) +
                                    	IF ( learner.a23 = answer_key.a23, 1, 0 ) +
                                    	IF ( learner.a24 = answer_key.a24, 1, 0 ) +
                                    	IF ( learner.a25 = answer_key.a25, 1, 0 ) +
                                    	IF ( learner.a26 = answer_key.a26, 1, 0 ) +
                                    	IF ( learner.a27 = answer_key.a27, 1, 0 ) +
                                    	IF ( learner.a28 = answer_key.a28, 1, 0 ) +
                                    	IF ( learner.a29 = answer_key.a29, 1, 0 ) +
                                    	IF ( learner.a30 = answer_key.a30, 1, 0 ) +
                                    	IF ( learner.a31 = answer_key.a31, 1, 0 ) +
                                    	IF ( learner.a32 = answer_key.a32, 1, 0 ) +
                                    	IF ( learner.a33 = answer_key.a33, 1, 0 ) +
                                    	IF ( learner.a34 = answer_key.a34, 1, 0 ) +
                                    	IF ( learner.a35 = answer_key.a35, 1, 0 )+
                                    	IF ( learner.a36 = answer_key.a36, 1, 0 )+
                                    	IF ( learner.a37 = answer_key.a37, 1, 0 )+
                                    	IF ( learner.a38 = answer_key.a38, 1, 0 )+
                                    	IF ( learner.a39 = answer_key.a39, 1, 0 )+
                                    	IF ( learner.a40 = answer_key.a40, 1, 0 )+
                                    	IF ( learner.a41 = answer_key.a41, 1, 0 )+
                                    	IF ( learner.a42 = answer_key.a42, 1, 0 )+
                                    	IF ( learner.a43 = answer_key.a43, 1, 0 )+
                                    	IF ( learner.a44 = answer_key.a44, 1, 0 )+
                                    	IF ( learner.a45 = answer_key.a45, 1, 0 )+
                                    	IF ( learner.a46 = answer_key.a46, 1, 0 )+
                                    	IF ( learner.a47 = answer_key.a47, 1, 0 )+
                                    	IF ( learner.a48 = answer_key.a48, 1, 0 )+
                                    	IF ( learner.a49 = answer_key.a49, 1, 0 )+
                                    	IF ( learner.a50 = answer_key.a50, 1, 0 )
                                    	) AS total_correct 
                                    FROM tb_answers AS learner JOIN tb_answers AS answer_key ON learner.SUBJECT = answer_key.SUBJECT AND answer_key.schoolid = 101010 WHERE	learner.ID =".$row['ID'];
                            $resultcheck = $conn->query($checkquery);
                            while ($rowcheck = $resultcheck->fetch_assoc()){
                                $score=$rowcheck['total_correct'];
                                echo "<td>".$score."</td>";
                            }
                            $queryupdate="update tb_answers set a51='".$score."' where ID =".$row['ID'];
                            $resultupdate=$conn->query($queryupdate);
                                }
                                $i++;
                                ?>
                            <td><?php echo htmlspecialchars($row['gradelevel']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']);?></td>
                            <td><?php echo htmlspecialchars($row['created_at']);?></td>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
