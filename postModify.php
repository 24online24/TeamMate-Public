<?php

include 'connection.php';

include 'headerlogged.php';
$title = $description = $date = $location ='';

$title = $_POST["title"];
$description = $_POST["description"];
$date = $_POST["date"];
$location = $_POST["location"];
$creator = $_SESSION['id'];
$idPost = $_POST['idPostCreated'];

$sql = "UPDATE posts set title='$title', description='$description', date='$date', location='$location' where id= $idPost";
$results = mysqli_query($db, $sql);
if (!$results)
    die('Sign in failed');
else {
    redirect("index.php");
}

include 'footer.php';
