<?php
session_start();
include('db_connect.php');

// Check if form is submitted
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user credentials
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['login_id'] = $user['id'];
        $_SESSION['login_role'] = $user['type']; // Assuming 'type' is the role field

        // Redirect based on role
        if($user['type'] == 1){
            header('location: admin_dashboard.php');
        } elseif($user['type'] == 2){
            header('location: academic_advisor_dashboard.php');
        } elseif($user['type'] == 3){
            header('location: industrial_advisor_dashboard.php');
        } elseif($user['type'] == 4){
            header('location: student_dashboard.php');
        } else {
            echo "Invalid role!";
        }
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>

