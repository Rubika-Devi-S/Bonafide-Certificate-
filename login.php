<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . "/db.php"; // ✅ ensure correct db.php is included

if (!isset($conn) || !$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roll = isset($_POST['roll']) ? trim($_POST['roll']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($roll === '' || $password === '') {
        echo "<script>alert('Please enter Register Number and Password'); window.location='login.php';</script>";
        exit();
    }

    // ✅ Prepared statement
    $stmt = $conn->prepare("SELECT roll, name, password, status FROM students WHERE TRIM(roll) = ? LIMIT 1");
    if (!$stmt) {
        die("❌ SQL prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $roll);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // ✅ Allow both hashed and plain-text passwords
        $valid = password_verify($password, $row['password']) || $password === $row['password'];

        if ($valid) {
            // 🔹 Status check
            if ($row['status'] === 'approved') {
                $_SESSION['student'] = $row['roll'];
                $_SESSION['student_name'] = $row['name'];

                // ✅ Redirect to dashboard
                header("Location: student_dashboard.php");
                exit();
            } elseif ($row['status'] === 'pending') {
                echo "<script>alert('⏳ Your registration is still pending admin approval. Please wait.'); window.location='login.php';</script>";
                exit();
            } elseif ($row['status'] === 'rejected') {
                echo "<script>alert('❌ Your registration has been rejected by admin. Contact college administration.'); window.location='login.php';</script>";
                exit();
            } else {
                echo "<script>alert('⚠ Unknown status. Contact admin.'); window.location='login.php';</script>";
                exit();
            }
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
      /* Body background */
      /* Body background */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f3e7ff, #e1d4f7); /* light purple gradient */
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    overflow: hidden;
}

/* Login box */
.login-box {
    background: #fff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 350px;
    text-align: center;
    transform: translateY(20px);
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
}

/* Heading */
.login-box h1 {
    margin-bottom: 25px;
    color: #6a0dad; /* deep purple */
    font-weight: 600;
}

/* Input groups */
.input-group {
    margin-bottom: 20px;
    text-align: left;
}

.input-group label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    color: #555;
}

.input-group input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    transition: 0.3s ease;
}

.input-group input:focus {
    border-color: #a64ee6;
    box-shadow: 0 0 6px rgba(166, 78, 230, 0.4);
    outline: none;
}

/* Button */
.button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #a64ee6, #7b2cbf);
    border: none;
    color: #fff;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s ease, background 0.3s ease;
}

.button:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #7b2cbf, #5a189a);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

  </style>
</head>
<body>
  <div class="login-box">
    <h1>Student Login</h1>
    <form action="login.php" method="POST">
      <div class="input-group">
        <label for="roll">Register Number</label>
        <input type="text" name="roll" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="button">Login</button>
    </form>
  </div>
</body>
</html>
