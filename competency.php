<?php
// Include the database connection file
include 'roxcon.php';

// Check connection and display a message if the connection fails
if ($conn->connect_error) {
    die("<div class='alert alert-danger text-center'>Database connection failed: " . $conn->connect_error . "</div>");
}

// Fetch subjects for the dropdown
$subjects = [];
$sql = "SELECT * FROM subjects ORDER BY subject ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competencies Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .table thead {
            background-color: #333333;
            color: #ffffff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #1f1f1f;
        }
        .table tbody tr:nth-child(even) {
            background-color: #2a2a2a;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: #000000;">Search Competencies</h1>

        <div class="alert alert-success text-center">
            Database connected successfully!
        </div>

        <?php
        // Initialize variables
        $selectedSubject = "";
        $results = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
            $selectedSubject = $conn->real_escape_string($_POST['file']);
            $sql = "SELECT *
                    FROM tb_competencies 
                    WHERE subject = '$selectedSubject'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            }
        }
        ?>

         <form method="POST" class="mb-4">
            <div class="input-group">
                <select name="file" class="form-select" required>
                    <option value="" disabled selected>Select a subject and grade level</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo htmlspecialchars($subject['file']); ?>">
                            <?php echo htmlspecialchars($subject['subject'] . " " . $subject['gradelevel']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </div>
        </form>


        <?php if (!empty($results)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Competency</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td>Grade Level</td>
                                <td><?php echo htmlspecialchars($row['gradelevel']); ?></td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            </tr>
                            <?php for ($i = 1; $i <= 50; $i++): ?>
                                <tr>
                                    <td>C<?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row["c$i"]); ?></td>
                                </tr>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="alert alert-warning text-center">
                No results found for "<?php echo htmlspecialchars($selectedSubject); ?>"
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
