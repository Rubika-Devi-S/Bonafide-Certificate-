
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll = mysqli_real_escape_string($conn, $_POST['roll']);
    $password = $_POST['password'];

    $query = "SELECT * FROM students WHERE roll = '$roll' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // ✅ Check if DB password is hashed
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['student'] = $row['roll'];
            $_SESSION['student_name'] = $row['name'];

            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "<script>alert('❌ Wrong password'); window.location='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('❌ Register Number not found'); window.location='login.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>
<link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="dashboard-card">
    <h2>Welcome to Student Dashboard</h2>
    <p>You are approved! You can generate your bonafide certificate now.</p>
    <div class="buttons">
        <a href="generate_certificate.php" class="btn">Generate Certificate</a>
        <a href="logout.php" class="btn logout">Logout</a>
    </div>
</div>

</body>
</html>
