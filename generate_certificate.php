<?php
session_start();
include("db.php");

if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit();
}

$studentRoll = $_SESSION['student'];
$query = "SELECT name, roll, course, year FROM students WHERE roll = '$studentRoll' LIMIT 1";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("❌ Student not found in database.");
}
$row = mysqli_fetch_assoc($result);
$studentName   = $row['name'];
$studentRoll   = $row['roll'];
$studentCourse = $row['course'];
$studentYear   = $row['year'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bonafide Certificate</title>
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background: #f2f2f2;
      padding: 50px;
      text-align: center;
    }
    .certificate {
      background: #fff;
      border: 5px solid #444;
      padding: 50px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .certificate h1 {
      font-size: 28px;
      margin-bottom: 10px;
      text-transform: uppercase;
    }
    .certificate h2 {
      font-size: 22px;
      margin: 20px 0;
      text-decoration: underline;
    }
    .certificate p {
      font-size: 18px;
      line-height: 1.6;
      text-align: justify;
    }
    .footer {
      margin-top: 50px;
      display: flex;
      justify-content: space-between;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <div class="certificate">
    <h1>DON BOSCO COLLEGE, DHARMAPURI</h1>
    <h2>BONAFIDE CERTIFICATE</h2>
    <p>
      This is to certify that Mr./Ms. <b><?php echo $studentName; ?></b>, 
      Register Number <b><?php echo $studentRoll; ?></b>, is a bonafide student of 
      Don Bosco College, Dharmapuri. He/She is currently studying in 
      <b><?php echo $studentYear; ?> year</b> of <b><?php echo $studentCourse; ?></b> course in this institution 
      and bears a good conduct.
    </p>
    <div class="footer">
      <div>Date: <?php echo date("d-m-Y"); ?></div>
      <div>Principal</div>
    </div>
  </div>
  <script>
    // Automatically open print dialog for PDF download
    window.print();
  </script>
</body>
</html>
