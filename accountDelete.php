<?php

include 'connection.php';

include 'headerlogged.php';

$userID = $_POST['userID'];

$sqlaux5 = "DELETE from follow where follow.id in (select f.id from follow f join posts p on f.post_followed = p.id where p.creator_id = $userID)";
$resultsaux5 = mysqli_query($db, $sqlaux5);
if (!$resultsaux5)
    die('Action failed');
else {
    $sqlaux4 = "DELETE from comments where comments.id in (select c.id from comments c join posts p on c.post_id = p.id where p.creator_id = $userID)";
    $resultsaux4 = mysqli_query($db, $sqlaux4);
    if (!$resultsaux4)
        die('Action failed');
    else {
        $sqlaux3 = "DELETE from posts where creator_id = $userID";
        $resultsaux3 = mysqli_query($db, $sqlaux3);
        if (!$resultsaux3)
            die('Action failed');
        else {
            $sqlaux2 = "DELETE from comments where creator_id = $userID";
            $resultsaux2 = mysqli_query($db, $sqlaux2);
            if (!$resultsaux2)
                die('Action failed');
            else {
                $sqlaux1 = "DELETE from follow where user_following = $userID";
                $resultsaux1 = mysqli_query($db, $sqlaux1);
                if (!$resultsaux1)
                    die('Action failed');
                else {
                    $sql = "DELETE from users where id = $userID";
                    $results = mysqli_query($db, $sql);
                    if (!$results)
                        die('Action failed');
                    else {
                        if ($_SESSION["type_id"] == 1)
                            redirect('view.php');
                        else
                            redirect("logout.php");
                    }
                }
            }
        }
    }
}
include 'footer.php';
