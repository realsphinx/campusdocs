<?php
session_start();
if($_SESSION['login_role'] != 1){
    header('location: login.php');
    exit;
}
include('db_connect.php');

// Handle user creation, deletion, and modification
if(isset($_POST['create'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    $query = "INSERT INTO users (name, username, password, type) VALUES ('$name', '$username', '$password', '$type')";
    mysqli_query($conn, $query);
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $query = "DELETE FROM users WHERE id=$id";
    mysqli_query($conn, $query);
}

$users = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="logout.php">Logout</a>
    <h2>Create User</h2>
    <form method="post" action="">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="type" required>
            <option value="1">Admin</option>
            <option value="2">Academic Advisor</option>
            <option value="3">Industrial Advisor</option>
            <option value="4">Student</option>
        </select>
        <button type="submit" name="create">Create User</button>
    </form>
    <h2>Manage Users</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($users)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td>
                <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
