<!-- index.php -->

<html>
  <head>
    <title>Student Login</title>
  </head>
  <body>
    <h1>Student Login</h1>
    <form action="verify.php" method="post">
      <label for="rollno">Roll Number:</label>
      <input type="text" id="rollno" name="rollno"><br><br>
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob"><br><br>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>

<!-- verify.php -->

<?php
   include("includes/db_connect.php");

  if (isset($_POST['rollno']) && isset($_POST['dob'])) {
    $rollno = $_POST['rollno'];
    $dob = $_POST['dob'];

    // Check if the roll number exists in the database
    $query = "SELECT * FROM students WHERE roll_no = '$rollno'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      // Roll number exists, redirect to students/index.php
      header('Location: student/index.php?roll_no=' . $rollno);
      exit;
    } else {
      // Roll number does not exist, alert the user and redirect to register page
      echo "<script>alert('No details found for this roll number. Please register first.');</script>";
      header('Location: register.php');
      exit;
    }
  } else {
    echo "Error: Please enter both roll number and date of birth.";
  }
?>