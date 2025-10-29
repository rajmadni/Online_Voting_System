<?php
session_start();
include("connection.php");

$mobile = $_POST['mob'];
$pass = $_POST['pass'];
$role = $_POST['role'];

// Validate input
if (!preg_match('/^\d{10}$/', $mobile)) {
    echo '<script>
            alert("Invalid mobile number! It should be 10 digits.");
            window.location = "../";
          </script>';
    exit();
}

if (strlen($pass) < 8) {
    echo '<script>
            alert("Password must be at least 8 characters long.");
            window.location = "../";
          </script>';
    exit();
}

$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile='$mobile' AND password='$pass' AND role='$role'");

if (mysqli_num_rows($check) > 0) {
    $getGroups = mysqli_query($connect, "SELECT name, photo, votes, id FROM user WHERE role=2");
    if (mysqli_num_rows($getGroups) > 0) {
        $groups = mysqli_fetch_all($getGroups, MYSQLI_ASSOC);
        $_SESSION['groups'] = $groups;
    }
    $data = mysqli_fetch_array($check);
    $_SESSION['id'] = $data['id'];
    $_SESSION['status'] = $data['status'];
    $_SESSION['data'] = $data;
    echo '<script>
            window.location = "../routes/dashboard.php";
          </script>';
} else {
    echo '<script>
            alert("Invalid credentials!");
            window.location = "../";
          </script>';
}
?>
