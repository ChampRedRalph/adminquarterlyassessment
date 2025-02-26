<?php
// Include the database connection file
include 'roxcon.php';

// Initialize variables for the form
$id = $gradelevel = $subject = $quarter = $filePath = "";
$update = false;

// Check if the 'id' parameter is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the current record
    $stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $gradelevel = $row['gradelevel'];
        $subject = $row['subject'];
        $quarter = $row['quarter'];
        $filePath = $row['file'];
    } else {
        die("Record not found.");
    }
    
    // Close the statement
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $gradelevel = isset($_POST['gradelevel']) ? intval($_POST['gradelevel']) : null;
    $subject = isset($_POST['subject']) ? $_POST['subject'] : null;
    $quarter = isset($_POST['quarter']) ? intval($_POST['quarter']) : null;

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Delete the old file if it exists
        if ($filePath && file_exists($filePath)) {
            unlink($filePath);
        }

        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $fileName = 'G' . $gradelevel . '_' . $subject . '_Q' . $quarter . '.' . $fileExtension;
        $filePath = 'questionaire/' . $fileName;

        // Move the uploaded file to the specified directory
        if (!move_uploaded_file($fileTmpName, $filePath)) {
            die("Error moving uploaded file.");
        }
    } else {
        // If no new file is uploaded, keep the existing file path
        $fileName = $filePath;
    }

    // Prepare the update SQL statement
    $stmt = $conn->prepare("UPDATE subjects SET gradelevel = ?, subject = ?, quarter = ?, file = ? WHERE id = ?");
    $stmt->bind_param("isssi", $gradelevel, $subject, $quarter, $fileName, $id);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect to the display page with a success message
        header("Location: index.php?pg=subj&&message=Record updated successfully");
        exit();
    } else {
        // Redirect to the display page with an error message
        header("Location: index.php?pg=subj&&message=Error updating record: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Subject</h2>
        <form action="edit_subject.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="gradelevel">Grade Level</label>
                <input type="number" class="form-control" id="gradelevel" name="gradelevel" value="<?php echo htmlspecialchars($gradelevel); ?>" min="1" max="99" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <textarea class="form-control" id="subject" name="subject" rows="3" required><?php echo htmlspecialchars($subject); ?></textarea>
            </div>
            <div class="form-group">
                <label for="quarter">Quarter</label>
                <select class="form-control" id="quarter" name="quarter" required>
                    <option value="1" <?php echo $quarter == 1 ? 'selected' : ''; ?>>1</option> 
                    <option value="2" <?php echo $quarter == 2 ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo $quarter == 3 ? 'selected' : ''; ?>>3</option>
                    <option value="4" <?php echo $quarter == 4 ? 'selected' : ''; ?>>4</option>
                </select>
            </div>
            <div class="form-group">
                <label for="filePath">Current File</label>
                <input type="text" class="form-control" id="filePath" name="filePath" value="<?php echo htmlspecialchars($filePath); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="file">Upload New File</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php?pg=subj" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>
</body>
</html>