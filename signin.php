<?php
include 'connection.php';
include 'header.php';

$username = $email = $phone = $password = $gender = '';
$username = $_POST["username"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$birthday = $_POST["birth"];
$gender = $_POST["gender"];
$sql = "insert into users (username, email, phone, password, birthday, gender) values ('$username', '$email', '$phone', '$password', '$birthday','$gender')";
$results = mysqli_query($db, $sql);
if (!$results)
    die('Sign in failed');
else {
    echo "Account created successfully.<br>";
    echo "You will be redirected in 3 seconds...";
    // sleep(10);
    redirect("index.php");
}

include 'footer.php';
