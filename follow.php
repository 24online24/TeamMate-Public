<?php

include 'connection.php';

include 'headerlogged.php';
$idUser = $_SESSION['id'];
$idPost = $_POST['idPost'];
$sql = "insert into follow (user_following, post_followed) values ('$idUser', '$idPost')";
$results = mysqli_query($db, $sql);

if (!$results)
    die('Action failed!');
else {
    redirect("index.php");
}

include 'footer.php';
