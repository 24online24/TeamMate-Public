<?php

include 'connection.php';

include 'headerlogged.php';
$title = $description = $date = $location ='';

$title = $_POST["title"];
$description = $_POST["description"];
$date = $_POST["date"];
$location = $_POST["location"];
$creator = $_SESSION['id'];

$sql = "INSERT into posts (title, description, date, location, creator_id) values ('$title', '$description', '$date', '$location', '$creator')";
$results = mysqli_query($db, $sql);
if (!$results)
    die('Sign in failed');
else {
    redirect("index.php");
}

include 'footer.php';
