<?php
// Include the database connection file
include 'roxcon.php'; // Change this to the correct path of your connection file

// Initialize the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Competency</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Submit Competency</h2>
                <form action="process_competency.php" method="post">
                    <div class="form-group">
                        <label for="gradelevel">Grade Level</label>
                        <input type="text" class="form-control" id="gradelevel" name="gradelevel" value="<?php echo htmlspecialchars($_GET['grade']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($_GET['subject']); ?>" readonly>
                    </div>
                    <?php for ($i = 1; $i <= 50; $i++): ?>
                        <div class="form-group">
                            <label for="c<?php echo $i; ?>">Item <?php echo $i; ?></label>
                            <input type="text" class="form-control" id="c<?php echo $i; ?>" name="c<?php echo $i; ?>">
                        </div>
                    <?php endfor; ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
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