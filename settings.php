<?php

include 'connection.php';
include 'headerlogged.php';

$userID = $_SESSION['id'];
$sql = "SELECT * from users where id = $userID";
$results = mysqli_query($db, $sql);
$row = mysqli_fetch_array($results, MYSQLI_ASSOC);

echo
"<div class='centered grid-x'>
    <div class='cell small-12 medium-6 large-4'>
        <div class='card'>
            <form action='' method='post' name='signinForm' onsubmit='return check_signin(this);'>
                <div class='grid-container'>
                    <div class='centered grid-x grid-padding-x'>
                        <div class='medium-8 cell'>
                            <label>
                                <input type='text' name='username' value='" . $row['username'] . "'>
                            </label>
                        </div>
                        <div class='medium-8 cell'>
                            <label>
                                <input type='email' name='email' value='" . $row['email'] . "'>
                            </label>
                        </div>
                        <div class='medium-8 cell'>
                            <label>
                                <input type='tel' name='phone' value='" . $row['phone'] . "'>
                            </label>
                        </div>
                        <div class='medium-8 cell'>
                            <label>
                                <input type='password' name='password' value='" . $row['password'] . "'>
                            </label>
                        </div>
                        <div class='medium-8 cell'>
                            <label>Date of birth
                                <input type='date' name='birth' value=" . $row['birthday'] . ">
                            </label>
                        </div>
                        <fieldset class='fieldset'>
                            <legend>Gender</legend>
                            <input type='radio' name='gender' value='Male' id='male' ";
if ($row['gender'] == 'Male') echo "checked ";
echo "><label for='male'>Male</label>
                            <input type='radio' name='gender' value='Female' id='female' ";
if ($row['gender'] == 'Female') echo "checked ";
echo "><label for='female'>Female</label>
                            <input type='radio' name='gender' value='Other' id='other' ";
if ($row['gender'] == 'Other') echo "checked ";
echo "><label for='other'>Other</label>
                        </fieldset>
                    </div>
                    <button class='submit button' name='save' value='submitted'>Save</button><br>";
                    if ($_SESSION["type_id"] != 1) {
                        echo "<button type='button' class='alert button' data-open='accountDeleteModal' name='delete' style='float: right'>Delete account</button>";
                    }
            echo "</div>
            </form>
        </div>
    </div>
</div>";

echo
"<div class='tiny reveal' id='accountDeleteModal' data-reveal>
    <form action='accountDelete.php' method='post'>
        <div class='grid-container'>
            <p>Are you sure you want to delete this account?</p>
            <button class='alert button' name='userID' value=" . $userID . " style='float: left'>Delete account</button>
            <button type='button' class='button' data-close style='float: right'>Cancel</button>
        </div>
    </form>
</div>";

$save = '';

if (isset($_POST['save'])) {
    $save = $_POST['save'];
}

if ($save == 'submitted') {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $birthday = $_POST["birth"];
    $gender = $_POST["gender"];
    $sqlSave = "UPDATE users set username='$username', email='$email', phone='$phone', password='$password', birthday='$birthday', gender='$gender' where id= $userID";
    $resultsSave = mysqli_query($db, $sqlSave);
    if (!$resultsSave)
        die('Sign in failed');
    else {
        $_SESSION["username"] = $username;
        redirect("settings.php");
    }
}

include 'footer.php';
