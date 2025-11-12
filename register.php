<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

$success = "";
$error = "";

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $roll = strtoupper(trim($_POST['roll'])); // convert to uppercase
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate register number format
    if (!preg_match("/^C\d{2}[A-Z]{2}\d{3}[A-Z]{3}\d{3}$/", $roll)) {
        $error = "❌ Invalid Register Number format. Example: C23UG155CAP001";
    } else {
        // Insert into students table
        $sql = "INSERT INTO students (name, roll, password, course, year, created_at, status) 
                VALUES ('$name', '$roll', '$hashed_password', '$course', '$year', NOW(), 'pending')";

        if ($conn->query($sql) === TRUE) {
            $success = "✅ Registration successful! Please wait for admin approval before you can login.";
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        .register-box h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #444;
        }
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .button {
            background: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background: #45a049;
        }
        .success {
            margin-top: 15px;
            color: green;
            font-weight: bold;
        }
        .error {
            margin-top: 15px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h1>Student Registration</h1>

        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="input-group">
                <label for="roll">Register Number</label>
                <input type="text" name="roll" placeholder="C23UG155CAP000" required>
            </div>
            <div class="input-group">
                <label for="course">Course</label>
                <input type="text" name="course" required>
            </div>
            <div class="input-group">
                <label for="year">Year</label>
                <select name="year" required>
                    <option value="">Select Year</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                </select>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="button">Register</button>
        </form>
    </div>
</body>
</html>
