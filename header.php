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
    if (isset($_SESSION['id']) && $_SESSION['id'] != '') {
        redirect($_SESSION["fpage"]);
    }
