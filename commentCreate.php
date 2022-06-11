<?php

include 'connection.php';

include 'headerlogged.php';
$title = $description = $date = $location ='';

$text = $_POST["text"];
$idPost = $_POST['idPost'];
$creator = $_SESSION['id'];

$sql = "INSERT into comments (body_text, creator_id, post_id) values ('$text', '$creator', '$idPost')";
$results = mysqli_query($db, $sql);
if (!$results)
    die('Sign in failed');
else {
    redirect("index.php");
}

include 'footer.php';
