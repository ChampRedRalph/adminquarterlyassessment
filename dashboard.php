<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

// Initialize the session
session_start();

// Query to count the number of rows in the "answers" table
$sql = "SELECT COUNT(*) as total_answers FROM tb_answers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $total_answers = $row["total_answers"];
} else {
    $total_answers = 0;
}

// Query to count the number of rows in the "subjects" table where the "file" field is not null
$sql_subjects = "SELECT COUNT(*) as total_subjects FROM subjects WHERE file IS NOT NULL and subject LIKE '%" . $_SESSION["subjectarea"] . "%'";
$result_subjects = $conn->query($sql_subjects);

if ($result_subjects->num_rows > 0) {
    // Fetch the row
    $row_subjects = $result_subjects->fetch_assoc();
    $total_subjects = $row_subjects["total_subjects"];
} else {
    $total_subjects = 0;
}

// Query to count the number of rows in the "subjects" table where the "file" field is null
$sql_subjects_null = "SELECT COUNT(*) as total_subjects_null FROM subjects WHERE file IS NULL and subject LIKE '%" . $_SESSION["subjectarea"] . "%'";
$result_subjects_null = $conn->query($sql_subjects_null);

if ($result_subjects_null->num_rows > 0) {
    // Fetch the row
    $row_subjects_null = $result_subjects_null->fetch_assoc();
    $total_subjects_null = $row_subjects_null["total_subjects_null"];
} else {
    $total_subjects_null = 0;
}

// Query to count the number of unique schoolid in the "tb_answers" table
$sql_unique_schools = "SELECT COUNT(DISTINCT schoolid) as total_unique_schools FROM tb_answers";
$result_unique_schools = $conn->query($sql_unique_schools);

if ($result_unique_schools->num_rows > 0) {
    // Fetch the row
    $row_unique_schools = $result_unique_schools->fetch_assoc();
    $total_unique_schools = $row_unique_schools["total_unique_schools"];
} else {
    $total_unique_schools = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Answers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_answers; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Subjects with Questionaire</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_subjects; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Subjects with No Questionaire
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_subjects_null; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Schools Answered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_unique_schools; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Card -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Profile</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $username; ?></div>
                                <div class="text-xs font-weight-bold text-gray-800"><?php echo $_SESSION["subjectarea"]; ?></div>
                                <div class="text-xs font-weight-bold text-gray-800"><?php echo $_SESSION["office"]; ?></div>
                                <div class="text-xs font-weight-bold text-gray-800"><?php echo $_SESSION["schoolid"]; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Change Password</div>
                                <form action="change_password.php" method="post">
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Change Password</button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-key fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
            <div class="row">
                <!-- Exam Settings Card -->
                <?php if ($_SESSION["office"] == "Region" && $_SESSION["subjectarea"] == null): ?>
                                <div class="col-xl-6 col-md-6 mb-4">
                                    <div class="card border-left-secondary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                                Exam Settings</div>
                                                            <form action="save_exam_settings.php" method="post">
                                                                <div class="form-group">
                                                                    <label for="ruqa_exam" class="h5 font-weight-bold text-gray-800">RUQA Exam</label>
                                                                    <a href="https://ruqa.deped10.com" target="_blank">Visit RUQA Exam</a>
                                                                    <?php
                                                                    // Query to get the status of RUQA Exam from tb_settings where id = 2
                                                                    $sql_ruqa_status = "SELECT status FROM tb_settings WHERE id = 2";
                                                                    $result_ruqa_status = $conn->query($sql_ruqa_status);

                                                                    $ruqa_exam_checked = "";
                                                                    if ($result_ruqa_status->num_rows > 0) {
                                                                        $row_ruqa_status = $result_ruqa_status->fetch_assoc();
                                                                        if ($row_ruqa_status["status"] == 1) {
                                                                            $ruqa_exam_checked = "checked";
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="custom-control custom-switch custom-control-lg">
                                                                        <input type="checkbox" class="custom-control-input" id="ruqa_exam" name="ruqa_exam" <?php echo $ruqa_exam_checked; ?>>
                                                                        <label class="custom-control-label" for="ruqa_exam"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cbrat_exam" class="h5 font-weight-bold text-gray-800">CBRAT Exam</label>
                                                                    <a href="https://cbrat.deped10.com" target="_blank">Visit CBRAT Exam</a>
                                                                    <?php
                                                                    // Query to get the status of CBRAT Exam from tb_settings where id = 1
                                                                    $sql_cbrat_status = "SELECT status FROM tb_settings WHERE id = 1";
                                                                    $result_cbrat_status = $conn->query($sql_cbrat_status);

                                                                    $cbrat_exam_checked = "";
                                                                    if ($result_cbrat_status->num_rows > 0) {
                                                                        $row_cbrat_status = $result_cbrat_status->fetch_assoc();
                                                                        if ($row_cbrat_status["status"] == 1) {
                                                                            $cbrat_exam_checked = "checked";
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="custom-control custom-switch custom-control-lg">
                                                                        <input type="checkbox" class="custom-control-input" id="cbrat_exam" name="cbrat_exam" <?php echo $cbrat_exam_checked; ?>>
                                                                        <label class="custom-control-label" for="cbrat_exam"></label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-secondary">Save</button>
                                                            </form>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-cogs fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <?php endif; ?>
            </div>

</div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
