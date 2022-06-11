<?php

include 'connection.php';

if (!isset($_SESSION['id']) || $_SESSION['id'] == '') {
    redirect('index.php');
}

include 'headerlogged.php';
$idUser = $_SESSION['id'];
$idPost = $_POST['idPost'];
$sql = "delete from follow where user_following ='$idUser' and post_followed = '$idPost'";
$results = mysqli_query($db, $sql);

if (!$results)
    die('Action failed!');
else {
    redirect("index.php");
}

include 'footer.php';
