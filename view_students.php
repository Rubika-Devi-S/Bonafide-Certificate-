<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Include database connection
include 'db.php';

// Fetch students
$sql = "SELECT id, name, course, year FROM students";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching students: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students List</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        a.button { 
            display: inline-block; padding: 5px 10px; margin: 10px;
            background: #28a745; color: white; text-decoration: none; border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Registered Students</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Year</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['course']}</td>
                        <td>{$row['year']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No students found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <div style="text-align:center;">
        <a href="admin_dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>
