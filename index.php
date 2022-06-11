<?php
include 'connection.php';
include 'header.php';

$mode = '';

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
}

if ($mode == 'submitted') {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    if ($email != '' && $pass != '') {
        $sql1 = "SELECT * from users where email = '$email' and password = '$pass' ";
        $result1 = mysqli_query($db, $sql1);

        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
        if (!$row1) {
            die('Invalid email or password');
        } else {
            $result2 = mysqli_query($db, "SELECT users.id, users.username, users.type_id, user_type.fpage from users left join user_type on users.type_id = user_type.id where users.email ='$email' and users.password='$pass'");

            $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

            $rows_number = mysqli_num_rows($result2);

            if ($rows_number > 0) {
                $_SESSION["id"] = $row2["id"];
                $_SESSION["username"] = $row2["username"];
                $_SESSION["type_id"] = $row2["type_id"];
                $_SESSION["fpage"] = $row2["fpage"];

                redirect($_SESSION["fpage"]);
                exit;
            }
        }
    } else {
        redirect("index.php");
    }
}
?>


<div class="centered grid-x">
    <div class="cell small-12 medium-6 large-4">
        <div class="card">
            <img src="./assets/basketball.jpg" alt="People playing basketball">
        </div>
    </div>
    <div class="cell small-12 medium-6 large-4">
        <div class="card">
            <form action='' method="post" name='loginForm' onsubmit="return check_login(this);">
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                        <div class="medium-8 cell">
                            <label>
                                <input type="text" name='email' placeholder="Email">
                            </label>
                        </div>
                        <div class="medium-8 cell">
                            <label>
                                <input type="password" name='password' placeholder="Password">
                            </label>
                        </div>
                    </div>
                    <button class="submit button" name='mode' value='submitted'>Log In</button>
                    <button type="button" class="secondary button" data-open="signinModal">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="reveal" id="signinModal" data-reveal>
    <form action="signin.php" method="post" name='signinForm' onsubmit="return check_signin(this);">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="medium-8 cell">
                    <label>
                        <input type="text" name="username" placeholder="Username">
                    </label>
                </div>
                <div class="medium-8 cell">
                    <label>
                        <input type="text" name="email" placeholder="Email">
                    </label>
                </div>
                <div class="medium-8 cell">
                    <label>
                        <input type="tel" name="phone" placeholder="Phone number">
                    </label>
                </div>
                <div class="medium-8 cell">
                    <label>
                        <input type="password" name="password" placeholder="Password">
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Date of birth
                        <input type="date" name="birth">
                    </label>
                </div>
                <fieldset class="fieldset">
                    <legend>Gender</legend>
                    <input type="radio" name="gender" value="Male" id="male"><label for="male">Male</label>
                    <input type="radio" name="gender" value="Female" id="female"><label for="female">Female</label>
                    <input type="radio" name="gender" value="Other" id="other"><label for="other">Other</label>
                </fieldset>
            </div>
            <button class="submit button">Sign In</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>