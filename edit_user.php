<?php
// Include the database connection
include 'roxcon.php'; // Adjust the path to your database connection file

// Define variables and initialize with empty values
$username = $email = $password = $office = $subjectarea = $schoolid = "";
$username_err = $email_err = $password_err = "";

// Check if the user ID exists
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    // Fetch the user data based on ID
    $sql = "SELECT * FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = $id;

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $username = $row["username"];
                $email = $row["email"];
                $office = $row["office"];
                $subjectarea = $row["subjectarea"];
                $schoolid = $row["schoolid"];
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
} else {
    header("location: error.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $office = trim($_POST["office"]);
    $subjectarea = trim($_POST["subjectarea"]);
    $schoolid = trim($_POST["schoolid"]);

    if (!empty(trim($_POST["password"]))) {
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    }

    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        if (!empty($password)) {
            $sql = "UPDATE users SET username = ?, email = ?, password = ?, office = ?, subjectarea = ?, schoolid = ?, updated_at = ? WHERE id = ?";
        } else {
            $sql = "UPDATE users SET username = ?, email = ?, office = ?, subjectarea = ?, schoolid = ?, updated_at = ? WHERE id = ?";
        }

        if ($stmt = $conn->prepare($sql)) {
            $param_updated_at = date("Y-m-d H:i:s");
            if (!empty($password)) {
                $stmt->bind_param("sssssisi", $username, $email, $password, $office, $subjectarea, $schoolid, $param_updated_at, $id);
            } else {
                $stmt->bind_param("ssssisi", $username, $email, $office, $subjectarea, $schoolid, $param_updated_at, $id);
            }

            if ($stmt->execute()) {
                header("location: index.php?pg=user&&message=Record updated successfully");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit User</h2>
        <form action="edit_user.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="form-group">
                <label>Office</label>
                <select name="office" class="form-control">
                    <?php
                    $offices = ["Region", "BUK", "CDO", "CAM", "ELSAL", "GNG", "ILI", "LDN", "MALAY", "MISOCC", "MISOR", "ORO", "OZA", "TAN", "VAL"];
                    foreach ($offices as $value) {
                        echo '<option value="' . $value . '"' . ($office === $value ? ' selected' : '') . '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Subject Area</label>
                <select name="subjectarea" class="form-control">
                <?php
                    // Add a blank option
                    echo '<option value=""' . ($subjectarea === '' ? ' selected' : '') . '> </option>';

                    $subject_query = "SELECT DISTINCT subject FROM subjects";
                    if ($subject_result = $conn->query($subject_query)) {
                        while ($subject_row = $subject_result->fetch_assoc()) {
                            $subject_value = $subject_row["subject"];
                            echo '<option value="' . $subject_value . '"' . ($subjectarea === $subject_value ? ' selected' : '') . '>' . $subject_value . '</option>';
                        }
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>School ID</label>
                <input type="text" name="schoolid" class="form-control" value="<?php echo htmlspecialchars($schoolid); ?>">
            </div>
            <div class="form-group">
                <label>Password (Leave blank if not changing)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php?pg=user" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>