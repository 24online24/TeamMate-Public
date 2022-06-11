<?php

include 'connection.php';

include 'headerlogged.php';

$idPost = $_POST['idPost'];

$sqlaux2 = "DELETE from follow where post_followed = $idPost";
$resultsaux2 = mysqli_query($db, $sqlaux2);
if (!$resultsaux2)
    die('Sign in failed');
else {
    $sqlaux1 = "DELETE from comments where post_id = $idPost";
    $resultsaux1 = mysqli_query($db, $sqlaux1);
    if (!$resultsaux1)
        die('Sign in failed');
    else {
        $sql = "DELETE from posts where id = $idPost";
        $results = mysqli_query($db, $sql);
        if (!$results)
            die('Sign in failed');
        else {
            redirect("index.php");
        }
    }
}
include 'footer.php';
