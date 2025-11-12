<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(135deg, #232526, #414345);
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }
    .dashboard {
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
      backdrop-filter: blur(10px);
      width: 90%;
      max-width: 800px;
      text-align: center;
      color: #fff;
    }
    h1 { margin-bottom: 20px; }
    .button {
      display: inline-block;
      margin: 10px;
      padding: 12px 25px;
      border: none;
      border-radius: 25px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      background: linear-gradient(135deg, #2f4bffff, #2484ddff);
      color: #fff;
      text-decoration: none;
      transition: 0.3s;
    }
    .button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <h1>Welcome Admin 👨‍💼</h1>
    <p>Here you can manage student registrations and approve certificates.</p>
    <a href="view_students.php" class="button">View Students</a>
    <a href="approve.php" class="button">Approve Requests</a>
    <a href="logout.php" class="button">Logout</a>
  </div>
</body>
</html>
