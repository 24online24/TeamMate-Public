<?php

include 'connection.php';

include 'headerlogged.php';

$idComment = $_POST['idComment'];

$sql = "DELETE from comments where id = $idComment";
$results = mysqli_query($db, $sql);
if (!$results)
    die('Sign in failed');
else {
    redirect("index.php");
}

include 'footer.php';
