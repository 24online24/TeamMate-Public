<?php

include 'connection.php';

if ($_SESSION["type_id"] != 1) {
    redirect('index.php');
}

include 'headerlogged.php';


echo "<h2>User posts</h2>";
$sql_AllPosts = "SELECT p.* from posts p";
$resultviewAllPosts = mysqli_query($db, $sql_AllPosts);

if (!$resultviewAllPosts)
    die('Action failed');
else {
    echo "<div class='grid-container'>";
    echo "<div class='grid-x grid-margin-x small-up-1 medium-up-2'>";
    while ($rowAllPosts = mysqli_fetch_array($resultviewAllPosts, MYSQLI_ASSOC)) {
        $idPost = $rowAllPosts["id"];
        echo
        "<div class='cell'>
            <div class='card'>
                <div class='card-section'>
                    <h2>" . $rowAllPosts["title"] . "</h2>
                    <button type='button' class='tiny alert button' data-open='deletePostModal" . $idPost . "'>Delete</button>
                    <h5>Date: " . $rowAllPosts["date"] . "</h5>
                    <h5>Location: " . $rowAllPosts["location"] . "</h5>
                    <p>" . $rowAllPosts["description"] . "</p>
                    <div>
                    <button type='button' class='button' data-open='commentModalCreated" . $idPost . "'>Comment</button>
                    </div>
                </div>";
        $sql_AllPostsComments = "SELECT c.* from comments c join posts p on c.post_id = $idPost group by c.id order by p.creation_date desc";
        $resultviewAllPostsComments = mysqli_query($db, $sql_AllPostsComments);
        if (!$resultviewAllPostsComments)
            die('Action failed');
        else {
            echo "<div class='card-section'>";
            while ($rowAllPostsComments = mysqli_fetch_array($resultviewAllPostsComments, MYSQLI_ASSOC)) {
                $commentID = $rowAllPostsComments['id'];
                $commentCreatorID = $rowAllPostsComments['creator_id'];
                $sql_CommentCreator = "SELECT u.username from users u where u.id = $commentCreatorID";
                $resultCommentCreator = mysqli_query($db, $sql_CommentCreator);
                $rowCommentCreator = mysqli_fetch_array($resultCommentCreator, MYSQLI_ASSOC);
                echo "<p><b>" . $rowCommentCreator['username'] . "</b>: " . $rowAllPostsComments['body_text'] . "<button type='button' class='tiny alert button' data-open='commentDeleteModal" . $commentID . "' style='float: right'>Delete</button></p><br>";

                echo
                "<div class='tiny reveal' id='commentDeleteModal" . $commentID . "' data-reveal>
                    <form action='commentDelete.php' method='post'>
                        <div class='grid-container'>
                            <p>Are you sure you want to delete this comment: \"" . $rowAllPostsComments['body_text'] . "\"?</p>
                            <button class='alert button' name='idComment' value=" . $commentID . " style='float: left'>Delete comment</button>
                            <button type='button' class='button' data-close style='float: right'>Cancel</button>
                        </div>
                    </form>
                </div>";
            }
            echo "</div>";
        }
        echo "</div>
        </div>";

        echo
        "<div class='reveal' id='editPostModal" . $idPost . "' data-reveal>
            <form action='postModify.php' method='post'>
                <div class='grid-container'>
                    <div class='grid-x grid-padding-x'>
                        <div class='medium-4 cell'>
                            <textarea name='title' required>" . $rowAllPosts["title"] . "</textarea>
                        </div>
                        <div class='medium-12 cell'>
                            <input type='datetime-local' name='date' value=" . $rowAllPosts["date"] . ">
                        </div>
                        <div class='medium-12 cell'>
                            <textarea name='location' required>" . $rowAllPosts["location"] . "</textarea>
                        </div>
                        <div class='medium-12 cell'>
                            <textarea name='description' required>" . $rowAllPosts["description"] . "</textarea>
                        </div>
                    </div>
                    <button class='submit button' name='idPost' value='$idPost'>Save</button>
                </div>
            </form>
        </div>";

        echo
        "<div class='reveal' id='commentModalCreated" . $idPost . "' data-reveal>
            <form action='commentCreate.php' method='post'>
                <div class='grid-container'>
                    <div class='grid-x grid-padding-x'>
                        <div class='medium-12 cell'>
                            <textarea name='text' placeholder='Write your comment here! <br> Only the post creator will be able to delete it.' required></textarea>
                        </div>
                    </div>
                    <button class='submit button' name='idPost' value='$idPost'>Post comment</button>
                </div>
            </form>
        </div>";

        echo
        "<div class='tiny reveal' id='deletePostModal" . $idPost . "' data-reveal>
            <form action='postDelete.php' method='post'>
                <div class='grid-container'>
                    <p>Are you sure you want to delete this post: \"" . $rowAllPosts['title'] . "\"?</p>
                    <button class='alert button' name='idPost' value=" . $idPost . " style='float: left'>Delete comment</button>
                    <button type='button' class='button' data-close style='float: right'>Cancel</button>
                </div>
            </form>
        </div>";
    }
    echo "</div>";
    echo "</div>";
}


include 'footer.php';
