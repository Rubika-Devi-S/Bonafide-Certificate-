<?php
session_start();
include 'db.php';

$student_id = $_SESSION['student_id']; // Student must be logged in
$request_id = intval($_GET['request_id']);

// Fetch the certificate request
$sql = "SELECT c.*, s.name, s.course 
        FROM certificate_requests c
        JOIN students s ON c.student_id = s.id
        WHERE c.id=$request_id AND c.student_id=$student_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Invalid request.");
}

$request = $result->fetch_assoc();

if ($request['status'] !== 'approved') {
    die("Your certificate request has not been approved yet.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bonafide Certificate</title>
<style>
    body { font-family: 'Times New Roman', serif; text-align: center; padding: 50px; }
    .certificate { 
        border: 10px solid #000; 
        padding: 50px; 
        width: 700px; 
        margin: auto; 
        position: relative;
    }
    .certificate h1 { font-size: 36px; text-decoration: underline; }
    .certificate p { font-size: 18px; line-height: 1.5; }
    .signature { margin-top: 50px; text-align: right; font-weight: bold; }
</style>
</head>
<body>
<div class="certificate">
    <h1>Bonafide Certificate</h1>
    <p>This is to certify that <strong><?php echo $request['name']; ?></strong></p>
    <p>is a student of <strong><?php echo $request['course']; ?></strong></p>
    <p>and has requested this certificate for official purposes.</p>
    <div class="signature">
        Principal<br>
        Don Bosco College, Dharmapuri
    </div>
</div>
<br>
<button onclick="window.print()">Download PDF</button>
</body>
</html>
