<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>

</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add Subject Form</h2>
        <form action="addsubjectprocess.php" method="POST" enctype="multipart/form-data">
           <div class="form-group">
                <label for="gradelevel">Grade Level</label>
                <input type="number" class="form-control" id="gradelevel" name="gradelevel" min="1" max="99">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <textarea class="form-control" id="subject" name="subject" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="quarter">Quarter</label>
                <select class="form-control" id="quarter" name="quarter">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 - CBRAT</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>
</html>
