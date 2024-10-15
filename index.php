<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <style>
        
        </style>
</head>
<body>
    <h2>Signup Page</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="roll_no">Roll no:</label>
        <input type="number" id="roll_no" name="roll_no" required><br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="birth">Birth:</label>
        <input type="date" id="birth" name="birth" required><br><br>

        <label for="personal_contact">Personal Contact:</label>
        <input type="text" id="personal_contact" name="personal_contact" required><br><br>

        <label for="guardian_contact">Guardian Contact:</label>
        <input type="text" id="guardian_contact" name="guardian_contact" required><br><br>

        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" required><br><br>

        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" required><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Connect to the database
    include("includes/db_connect.php");
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $name = $_POST['name'];
        $roll_no = $_POST['roll_no'];
        $course = $_POST['course'];
        $address = $_POST['address'];
        $birth = $_POST['birth'];
        $personal_contact = $_POST['personal_contact'];
        $guardian_contact = $_POST['guardian_contact'];
        $branch = $_POST['branch'];

        // Upload photo
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<p>Sorry, your file was not uploaded.</p>";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // Read the photo file contents
                $photoData = file_get_contents($target_file);

                // Insert data into database
                $sql = "INSERT INTO students (name, roll_no, course, address, birth, personal_contact, guardian_contact, branch, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sisssiiss", $name, $roll_no, $course, $address, $birth, $personal_contact, $guardian_contact, $branch, $photoData);

                if ($stmt->execute()) {
                    echo "<p>New record created successfully</p>";
                } else {
                    echo "<p>Error: " . $stmt->error . "</p>";
                }

                $stmt->close();
            } else {
                echo "<p>Sorry, there was an error uploading your file.</p>";
                echo error_log("Failed to upload file: " . error_get_last());
            }
        }
    }

    // Close connection
    $conn->close();
    ?>

<p> Already submitted the details <button class="register-button" onclick="location.href='download.php'">download</button></p>
</body>
</html>