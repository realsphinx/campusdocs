<?php
session_start();
if($_SESSION['login_role'] != 3){
    header('location: login.php');
    exit;
}
include('db_connect.php');

// Handle report grading and comments
if(isset($_POST['grade'])){
    $report_id = $_POST['report_id'];
    $grade = $_POST['grade'];
    $comments = $_POST['comments'];

    $query = "UPDATE reports SET grade='$grade', comments='$comments' WHERE id=$report_id";
    mysqli_query($conn, $query);
}

$reports = mysqli_query($conn, "SELECT * FROM reports WHERE advisor_id=".$_SESSION['login_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Industrial Advisor Dashboard</title>
</head>
<body>
    <h1>Industrial Advisor Dashboard</h1>
    <a href="logout.php">Logout</a>
    <h2>Manage Reports</h2>
    <table border="1">
        <tr>
            <th>Report ID</th>
            <th>Student ID</th>
            <th>Report Name</th>
            <th>Status</th>
            <th>Grade</th>
            <th>Comments</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($reports)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['report_name']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['grade']; ?></td>
            <td><?php echo $row['comments']; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="grade" placeholder="Grade" required>
                    <input type="text" name="comments" placeholder="Comments" required>
                    <button type="submit" name="grade">Submit</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
