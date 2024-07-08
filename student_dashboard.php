<?php
session_start();
if($_SESSION['login_role'] != 4){
    header('location: login.php');
    exit;
}
include('db_connect.php');

// Handle report upload
if(isset($_POST['upload'])){
    $student_id = $_SESSION['login_id'];
    $advisor_id = $_POST['advisor_id'];
    $report_name = $_POST['report_name'];
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    move_uploaded_file($file_tmp, "uploads/".$file);

    $query = "INSERT INTO reports (student_id, advisor_id, report_name, status, grade, comments) VALUES ('$student_id', '$advisor_id', '$report_name', 'Pending', NULL, NULL)";
    mysqli_query($conn, $query);
}

$reports = mysqli_query($conn, "SELECT * FROM reports WHERE student_id=".$_SESSION['login_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Student Dashboard</h1>
    <a href="logout.php">Logout</a>
    <h2>Upload Report</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="number" name="advisor_id" placeholder="Advisor ID" required>
        <input type="text" name="report_name" placeholder="Report Name" required>
        <input type="file" name="file" required>
        <button type="submit" name="upload">Upload</button>
    </form>
    <h2>My Reports</h2>
    <table border="1">
        <tr>
            <th>Report ID</th>
            <th>Report Name</th>
            <th>Status</th>
            <th>Grade</th>
            <th>Comments</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($reports)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['report_name']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['grade']; ?></td>
            <td><?php echo $row['comments']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
