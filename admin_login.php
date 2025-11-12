<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Hardcoded admin credentials
    if ($user === "admin" && $pass === "admin123") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        /* Body background */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: ;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
}

/* Login box (matches student login) */
.admin {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.91); /* subtle shadow */
    width: 350px;
    text-align: center;
    border: 10px;
}

/* Heading inside box */
.admin h1 {
    margin-bottom: 25px;
    color: #222;
}

/* Error message */
.error {
    color: #dc3545;
    margin-bottom: 20px;
    font-size: 14px;
}

/* Input fields */
.admin input[type="text"],
.admin input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 20px;
    border: 1.5px solid #141313ff;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border 0.2s ease;
    
}

.admin input[type="text"]:focus,
.admin input[type="password"]:focus {
    border-color: #14171aff;
    outline: none;
}

/* Submit button */
.admin button {
    width: 100%;
    padding: 12px;
    background: #007bff;
    border: none;
    color: #ffffffff;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.2s ease, box-shadow 0.2s ease;
}

.admin button:hover {
    background: #0056b3;
    box-shadow: 0 4px 15px rgba(0,123,255,0.2);
}

    </style>
</head>
<body>
<div class="admin">
<h2 class="page-title">Admin Login</h2>

<?php if ($error) { echo "<p class='error'>$error</p>"; } ?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Admin Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
</div>
</body>
</html>

