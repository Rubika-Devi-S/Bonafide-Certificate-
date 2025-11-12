<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// --- Security check: only admin can access ---
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Access denied. Please <a href='admin_login.php'>login as admin</a>.");
}

// --- Handle Approve/Reject actions ---
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE students SET status='approved' WHERE id=$id");
} elseif (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $conn->query("DELETE FROM students WHERE id=$id");
}

// --- Fetch pending students ---
$result = $conn->query("SELECT * FROM students WHERE status='pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Approve Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        table th {
            background: #2196F3;
            color: white;
        }
        .button {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: #fff;
            font-size: 14px;
        }
        .approve {
            background: #4CAF50;
        }
        .approve:hover {
            background: #45a049;
        }
        .reject {
            background: #f44336;
        }
        .reject:hover {
            background: #d32f2f;
        }
        .no-data {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

<h1>Pending Student Approvals</h1>

<?php if ($result->num_rows > 0) { ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll</th>
            <th>Course</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['roll']); ?></td>
            <td><?php echo htmlspecialchars($row['course']); ?></td>
            <td><?php echo htmlspecialchars($row['year']); ?></td>
            <td>
                <a href="approve.php?approve=<?php echo $row['id']; ?>" class="button approve">Approve</a>
                <a href="approve.php?reject=<?php echo $row['id']; ?>" class="button reject" onclick="return confirm('Are you sure you want to reject this student?')">Reject</a>
            </td>
        </tr>
        <?php } ?>
    </table> <br><br>
    <div style="text-align:center; margin-bottom:20px;">
    <a href="admin_dashboard.php" 
       style="padding:8px 16px; background:#2196F3; color:#fff; text-decoration:none; border-radius:6px;">
       ⬅ Back to Dashboard
    </a>
    </div>
<?php } else { ?>
    <p class="no-data">✅ No pending student registrations!</p>
<?php } ?>

</body>
</html>
