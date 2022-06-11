<?php

include 'connection.php';

include 'headerlogged.php';

$username = $_POST["username"];

$sql = "SELECT * from users where username='$username'";
$results = mysqli_query($db, $sql);

if (!$results)
    die("Name not found." . mysqli_error($db));
else {
    echo "<table border=1 cellpadding=2>";
    echo "<tr><td><b>Username</b></td><td><b></b></td></tr>";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        echo "<tr><td>";
        echo $row["username"];
        echo "</td></tr>";
    }
    echo "</table>";
}
include 'footer.php';
