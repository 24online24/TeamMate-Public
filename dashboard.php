<?php

include 'connection.php';

include 'headerlogged.php';
?>

<div class="centered">
    <button type='button' class='button' data-open='postModal'>Make a post!</button>
    <div class="reveal" id="postModal" data-reveal>
        <form action="postCreate.php" name='createPost' onsubmit='return checkCreatePost(this)' method="post">
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="medium-4 cell">
                        <input type="text" name="title" placeholder="Title (required)">
                    </div>
                    <div class="medium-12 cell">
                        <label> Date (required)
                            <input type="datetime-local" name="date">
                        </label>
                    </div>
                    <div class="medium-12 cell">
                        <input type="text" name="location" placeholder="Location (required)">
                    </div>
                    <div class="medium-12 cell">
                        <textarea name="description" placeholder="Description (required)"></textarea>
                    </div>
                </div>
                <button class="submit button">Create</button>
            </div>
        </form>
    </div>
</div>

<?php
$userID = $_SESSION['id'];

echo "<h2>Posts you created</h2>";
$sql_CreatedPosts = "SELECT p.* from posts p where p.creator_id = $userID order by p.creation_date desc";
$resultviewCreated = mysqli_query($db, $sql_CreatedPosts);
if (!$resultviewCreated)
    die('Action failed');
else {
    echo
    "<div class='grid-container'>
        <div class='grid-x grid-margin-x small-up-1 medium-up-2'>";
    while ($rowCreated = mysqli_fetch_array($resultviewCreated, MYSQLI_ASSOC)) {
        $idPostCreated = $rowCreated["id"];
        $postCreatorID = $rowCreated['creator_id'];
        $sql_PostCreator = "SELECT u.username from users u where u.id = $postCreatorID";
        $resultPostCreator = mysqli_query($db, $sql_PostCreator);
        $rowPostCreator = mysqli_fetch_array($resultPostCreator, MYSQLI_ASSOC);
        echo
        "<div class='cell'>
            <div class='card'>
                <div class='card-section'>
                    <h2>" . $rowCreated["title"] . "</h2>
                    <h4>Posted by: " . $rowPostCreator["username"] . "</h4>
                    <button type='button' class='tiny button' data-open='editPostModal" . $idPostCreated . "'>Edit</button>
                    <button type='button' class='tiny secondary button' data-open='deletePostModal" . $idPostCreated . "'>Delete</button>
                    <h5>Date: " . $rowCreated["date"] . "</h5>
                    <h5>Location: " . $rowCreated["location"] . "</h5>
                    <p>" . $rowCreated["description"] . "</p>
                    <div>
                    <button type='button' class='button' data-open='commentModalCreated" . $idPostCreated . "'>Comment</button>
                    </div>
                </div>";
        $sql_CreatedPostsComments = "SELECT c.* from comments c join posts p on c.post_id = $idPostCreated group by c.id order by p.creation_date desc";
        $resultviewCreatedPostsComments = mysqli_query($db, $sql_CreatedPostsComments);
        if (!$resultviewCreatedPostsComments)
            die('Action failed');
        else {
            echo "<div class='card-section'>";
            while ($rowCreatedPostsComments = mysqli_fetch_array($resultviewCreatedPostsComments, MYSQLI_ASSOC)) {
                $commentID = $rowCreatedPostsComments['id'];
                $commentCreatorID = $rowCreatedPostsComments['creator_id'];
                $sql_CommentCreator = "SELECT u.username from users u where u.id = $commentCreatorID";
                $resultCommentCreator = mysqli_query($db, $sql_CommentCreator);
                $rowCommentCreator = mysqli_fetch_array($resultCommentCreator, MYSQLI_ASSOC);
                echo "<p><b>" . $rowCommentCreator['username'] . "</b>: " . $rowCreatedPostsComments['body_text'] . "<button type='button' class='tiny secondary button' data-open='commentDeleteModal" . $commentID . "' style='float: right'>Delete</button></p><br>";

                echo
                "<div class='tiny reveal' id='commentDeleteModal" . $commentID . "' data-reveal>
                    <form action='commentDelete.php' method='post'>
                        <div class='grid-container'>
                            <p>Are you sure you want to delete this comment: \"" . $rowCreatedPostsComments['body_text'] . "\"?</p>
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
        "<div class='reveal' id='editPostModal" . $idPostCreated . "' data-reveal>
            <form action='postModify.php' name='modifyPost' onsubmit='return checkModifyPost(this)' method='post'>
                <div class='grid-container'>
                    <div class='grid-x grid-padding-x'>
                        <div class='medium-4 cell'>
                            <textarea name='title'>" . $rowCreated["title"] . "</textarea>
                        </div>
                        <div class='medium-12 cell'>
                            <input type='datetime-local' name='date' value='" . $rowCreated["date"] . "'>
                        </div>
                        <div class='medium-12 cell'>
                            <textarea name='location'>" . $rowCreated["location"] . "</textarea>
                        </div>
                        <div class='medium-12 cell'>
                            <textarea name='description'>" . $rowCreated["description"] . "</textarea>
                        </div>
                    </div>
                    <button class='submit button' name='idPostCreated' value='$idPostCreated'>Save</button>
                </div>
            </form>
        </div>";

        echo
        "<div class='reveal' id='commentModalCreated" . $idPostCreated . "' data-reveal>
            <form action='commentCreate.php' method='post'>
                <div class='grid-container'>
                    <div class='grid-x grid-padding-x'>
                        <div class='medium-12 cell'>
                            <textarea name='text' placeholder='Write your comment here! &#10;Only the post creator will be able to delete it.' required></textarea>
                        </div>
                    </div>
                    <button class='submit button' name='idPost' value='$idPostCreated'>Post comment</button>
                </div>
            </form>
        </div>";

        echo
        "<div class='tiny reveal' id='deletePostModal" . $idPostCreated . "' data-reveal>
            <form action='postDelete.php' method='post'>
                <div class='grid-container'>
                    <p>Are you sure you want to delete this post: \"" . $rowCreated['title'] . "\"?</p>
                    <button class='alert button' name='idPost' value=" . $idPostCreated . " style='float: left'>Delete comment</button>
                    <button type='button' class='button' data-close style='float: right'>Cancel</button>
                </div>
            </form>
        </div>";
    }
    echo "</div>
    </div>";
}

echo "<h2>Posts you follow</h2>";
$sql_FollowedPosts = "SELECT p.* from posts p join follow f on p.id = f.post_followed join users u on f.user_following = u.id where u.id = $userID group by p.id order by p.creation_date desc";
$resultviewFollowed = mysqli_query($db, $sql_FollowedPosts);
if (!$resultviewFollowed)
    die('Action failed');
else {
    echo
    "<div class='grid-container'>
        <div class='grid-x grid-margin-x small-up-1 medium-up-2'>";
    while ($rowFollowed = mysqli_fetch_array($resultviewFollowed, MYSQLI_ASSOC)) {
        $idPostFollowed = $rowFollowed["id"];
        $postCreatorID = $rowFollowed['creator_id'];
        $sql_PostCreator = "SELECT u.username from users u where u.id = $postCreatorID";
        $resultPostCreator = mysqli_query($db, $sql_PostCreator);
        $rowPostCreator = mysqli_fetch_array($resultPostCreator, MYSQLI_ASSOC);

        echo
        "<div class='cell'>
            <div class='card'>
                <div class='card-section'>
                    <h2>" . $rowFollowed["title"] . "</h2>
                    <h4>Posted by: " . $rowPostCreator["username"] . "</h4>
                    <h5>Date: " . $rowFollowed["date"] . "</h5>
                    <h5>Location: " . $rowFollowed["location"] . "</h5>
                    <p>" . $rowFollowed["description"] . "</p>
                    <div>
                        <form action=unfollow.php method=post>
                        <button class='submit button' name='idPost' value='$idPostFollowed'>Unfollow</button>
                        </form>
                        <button type='button' class='button' data-open='commentModalFollowed" . $idPostFollowed . "'>Comment</button>
                    </div>
                </div>";
        $sql_FollowedPostsComments = "SELECT c.* from comments c join posts p on c.post_id = $idPostFollowed join follow f on p.id = f.post_followed join users u on f.user_following = u.id where u.id = $userID group by c.id order by p.creation_date desc";
        $resultviewFollowedPostsComments = mysqli_query($db, $sql_FollowedPostsComments);
        if (!$resultviewFollowedPostsComments)
            die('Action failed');
        else {
            echo "<div class='card-section'>";
            while ($rowFollowedPostsComments = mysqli_fetch_array($resultviewFollowedPostsComments, MYSQLI_ASSOC)) {
                $commentCreatorID = $rowFollowedPostsComments['creator_id'];
                $sql_CommentCreator = "SELECT u.username from users u where u.id = $commentCreatorID";
                $resultCommentCreator = mysqli_query($db, $sql_CommentCreator);
                $rowCommentCreator = mysqli_fetch_array($resultCommentCreator, MYSQLI_ASSOC);
                echo "<p><b>" . $rowCommentCreator['username'] . "</b>: " . $rowFollowedPostsComments['body_text'] . "</p>";
            }
            echo "</div>";
        }
        echo "</div>
        </div>";

        echo
        "<div class='reveal' id='commentModalFollowed" . $idPostFollowed . "' data-reveal>
            <form action='commentCreate.php' method='post'>
                <div class='grid-container'>
                    <div class='grid-x grid-padding-x'>
                        <div class='medium-12 cell'>
                            <textarea name='text' placeholder='Write your comment here! &#10;Only the post creator will be able to delete it.' required></textarea>
                        </div>
                    </div>
                    <button class='submit button' name='idPost' value='$idPostFollowed'>Post comment</button>
                </div>
            </form>
        </div>";
    }
    echo "</div>
    </div>";
}

echo "<h2>Recent posts</h2>";
$sql_UnfPosts = "SELECT p.* from posts p
                where p.id not in (SELECT p.id from posts p join follow f on p.id = f.post_followed
                join users u on f.user_following = u.id where u.id = $userID group by p.id)
                and p.creator_id != $userID group by p.id order by p.creation_date desc";
$resultviewUnf = mysqli_query($db, $sql_UnfPosts);
if (!$resultviewUnf)
    die('Action failed');
else {
    echo
    "<div class='grid-container'>
        <div class='grid-x grid-margin-x small-up-1 medium-up-2'>";
    while ($rowUnf = mysqli_fetch_array($resultviewUnf, MYSQLI_ASSOC)) {
        $idPostUnfollowed = $rowUnf["id"];
        $postCreatorID = $rowUnf['creator_id'];
        $sql_PostCreator = "SELECT u.username from users u where u.id = $postCreatorID";
        $resultPostCreator = mysqli_query($db, $sql_PostCreator);
        $rowPostCreator = mysqli_fetch_array($resultPostCreator, MYSQLI_ASSOC);
        echo
        "<div class='cell'>
            <div class='card'>
                <div class='card-section'>
                    <h2>" . $rowUnf["title"] . "</h2>
                    <h4>Posted by: " . $rowPostCreator["username"] . "</h4>
                    <h5>Date: " . $rowUnf["date"] . "</h5>
                    <h5>Location: " . $rowUnf["location"] . "</h5>
                    <p>" . $rowUnf["description"] . "</p>
                    <div>
                        <form action=follow.php method=post>
                        <button class='submit button' name='idPost' value='$idPostUnfollowed'>Follow</button>
                        </form>
                        <button type='button' class='button' data-open='commentModalUnfollowed" . $idPostUnfollowed . "'>Comment</button>
                    </div>
                </div>";
        $sql_UnfollowedPostsComments = "SELECT c.* from comments c join posts p on c.post_id = $idPostUnfollowed
                                        where p.id not in (SELECT p.id from posts p join follow f on p.id = f.post_followed 
                                        join users u on f.user_following = u.id where u.id = $userID group by p.id)
                                        and p.creator_id != $userID group by c.id order by p.creation_date desc";
        $resultviewUnfollowedPostsComments = mysqli_query($db, $sql_UnfollowedPostsComments);
        if (!$resultviewUnfollowedPostsComments)
            die('Action failed');
        else {
            echo "<div class='card-section'>";
            while ($rowUnfollowedPostsComments = mysqli_fetch_array($resultviewUnfollowedPostsComments, MYSQLI_ASSOC)) {
                $commentCreatorID = $rowUnfollowedPostsComments['creator_id'];
                $sql_CommentCreator = "SELECT u.username from users u where u.id = $commentCreatorID";
                $resultCommentCreator = mysqli_query($db, $sql_CommentCreator);
                $rowCommentCreator = mysqli_fetch_array($resultCommentCreator, MYSQLI_ASSOC);
                echo "<p><b>" . $rowCommentCreator['username'] . "</b>: " . $rowUnfollowedPostsComments['body_text'] . "</p>";
            }
            echo "</div>";
        }


        echo "</div>
        </div>";

        echo
        "<div class='reveal' id='commentModalUnfollowed" . $idPostUnfollowed . "' data-reveal>
            <form action='commentCreate.php' method='post'>
                <div class='grid-container'>
                    <div class='grid-x grid-padding-x'>
                        <div class='medium-12 cell'>
                            <textarea name='text' placeholder='Write your comment here! &#10;Only the post creator will be able to delete it.' required></textarea>
                        </div>
                    </div>
                    <button class='submit button' name='idPost' value='$idPostUnfollowed'>Post comment</button>
                </div>
            </form>
        </div>";
    }
    echo "</div>
    </div>";
}

include 'footer.php';
