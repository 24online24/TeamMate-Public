<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamMate</title>
    <link rel="icon" type="image/png" href="./assets/icon64g.png">
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
    <?php
    if (!isset($_SESSION['id']) || $_SESSION['id'] == '') {
        redirect('index.php');
    }
    require_once('connection.php');
    $page = basename($_SERVER['PHP_SELF']);

    $typeID = $_SESSION["type_id"];
    $querryOption = "SELECT p.menu_name, p.file_name from pages p join page_rights pr on p.id = pr.page_id where pr.user_type='$typeID'";

    $sqlOption = mysqli_query($db, $querryOption);
    echo
    "<div class='top-bar'>
        <div class='top-bar-left'>
            <ul class='menu'>
                <li><a href='" . $_SESSION['fpage'] . "' class='logo'>TeamMate</a></li>
                <li>
                    <form action='search.php' method='post'>
                        <label>
                            <input type='search' name='username' placeholder='Name' required>
                        </label>
                    </form>
                </li>
            </ul>
        </div>
        <div class='top-bar-right'>
            <ul class='menu'>
                <ul class='dropdown menu' data-dropdown-menu>
                    <li>
                        <a href='#'>Options</a>
                        <ul class='menu'>";
    while ($rowOption = mysqli_fetch_array($sqlOption, MYSQLI_ASSOC)) {
        echo "<li><a href='" . $rowOption['file_name'] . "' class='submit button'>" . $rowOption['menu_name'] . "</a></li>";
    }
    echo "</ul>
                    </li>
                </ul>
            </ul>
        </div>
    </div>";
    ?>