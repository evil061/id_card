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
<button class="register-button" onclick="location.href='index.php'">register</button>
<!-- verify.php -->

<?php
  if (isset($_POST['rollno']) && isset($_POST['dob'])) {
    $rollno = $_POST['rollno'];
    $dob = $_POST['dob'];
    // You can add validation logic here to check if the input is valid
    // For now, let's just redirect to students/index.php
    header('Location: students/index.php');
    exit;
  } else {
    echo "Error: Please enter both roll number and date of birth.";
  }
?>