<?php
include "header.php";
require_once "databases/db_conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require "vendor/autoload.php";


if (isset($_POST["add_comment"])) {
    $name = $db->real_escape_string($_POST["name"]);
    $email = $db->real_escape_string($_POST["email"]);
    $comment = $db->real_escape_string($_POST["comment"]);
    $post_id = $db->real_escape_string($_POST["post_id"]);
    $reply_of = 0;

    $query = $db->query("INSERT INTO comments(name, email, comment, post_id, created_at, reply_of) VALUES ('$name', '$email', '$comment', '$post_id', NOW(), '$reply_of')");
    if ($query) {
        $_SESSION["message"] = "Reply Sent";
        header("location: comment.php");
        exit();
    } else {
        $_SESSION["message"] = "Failed";
        header("location: comment.php");
        exit();
    }
}


if (isset($_POST["do_reply"])) {
    $name = $db->real_escape_string($_POST["name"]);
    $email = $db->real_escape_string($_POST["email"]);
    $comment = $db->real_escape_string($_POST["comment"]);
    $post_id = $db->real_escape_string($_POST["post_id"]);
    $reply_of = $db->real_escape_string($_POST["reply_of"]);

    $result = $db->query("SELECT * FROM comments WHERE id = '$reply_of'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_object();
        // $name = $row->name;
        // sending email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "server236.web-hosting.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->Username = "info@spectrawebx.xyz";
        $mail->Password = $mail['password'];

        $mail->setFrom("info@spectrawebx.xyz", "Spectra Web-X");
        $mail->addAddress($row->email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = "Spectra Web-X Reply";

        $email_template = "
            <h2>Hello $row->name, $name just replied to your comment</h2>
            <img src='https://unsplash.it/801' width='200px' height='200px'>        
            ";
        $mail->Body = $email_template;
        $mail->send();
    }
        $db->query("INSERT INTO comments(name, email, comment, post_id, created_at, reply_of) VALUES ('$name', '$email', '$comment', '$post_id', NOW(), '$reply_of')");
        $_SESSION["message"] = "Reply Sent";
        header("location: comment.php");
        exit();
}

?>
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">

            <div class="card">
                <?php include "message.php";?>
                <div class="card-header">
                    <h2>Comment Section</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        $post = $db->query("SELECT * FROM posts LIMIT 5");
                        $p = $post->fetch_assoc();
                        foreach ($post as $posts) :
                            $post_id = $posts['id'];
                            if(isset($_SESSION['pid'])){
                                $_SESSION['pid'] = true;
                                $_SESSION['pid'] = $post_id;

                            }
                        ?>
                            <img src="posts/<?= $posts['image']; ?>" alt="" class="col-md-12">
                            <form action="" method="post">
                                <input type="hidden" name="post_id" value="<?= $post_id; ?>" class="form-control">
                                <div class="col-md-12">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Comment</label>
                                    <textarea name="comment" class="form-control" required> </textarea>
                                </div>
                                <input type="submit" class="btn btn-primary w-100 mt-4" name="add_comment" value="Add Comment">
                            </form>
                            <?php
                            // get all comments of post
                            $result = $db->query("SELECT * FROM comments WHERE post_id = '$post_id' LIMIT 2");

                            // save all records from database in an array
                            $comments = array();
                            while ($row = $result->fetch_object()) {
                                array_push($comments, $row);
                            }

                            // loop through each comment
                            foreach ($comments as $comment_key => $comment) {
                                // initialize replies array for each comment
                                $replies = array();

                                // check if it is a comment to post, not a reply to comment
                                if ($comment->reply_of == 0) {
                                    // loop through all comments again
                                    foreach ($comments as $reply_key => $reply) {
                                        // check if comment is a reply
                                        if ($reply->reply_of == $comment->id) {
                                            // add in replies array
                                            array_push($replies, $reply);

                                            // remove from comments array
                                            unset($comments[$reply_key]);
                                        }
                                    }
                                }

                                // assign replies to comments object
                                $comment->replies = $replies;
                            ?>
                            <?php
                            }
                            ?>
                                <ul class="comments row" id="comments">
                                    <?php foreach ($comments as $comment) : ?>
                                        <div class="col-md-12 w-100 mt-4" style="background-color: #E1E1E1; margin:auto;">
                                            <div class="col-md-12">
                                                <?php echo "<b>".$comment->name."</b>"; ?>
                                            </div>

                                            <div class="col-md-12">
                                                <?php echo $comment->comment; ?>
                                            </div>

                                            <div class="col-md-12">
                                                <?php echo date("F d, Y h:i a", strtotime($comment->created_at)); ?>
                                            </div>

                                            <div class="btn btn-primary" data-id="<?php echo $comment->id; ?>" onclick="showReplyForm(this);"> Reply <i class="fa fa-reply" style="color: #fff;"></i></div>

                                            <form action="" method="post" id="form-<?php echo $comment->id; ?>" style="display: none;">

                                                <input type="hidden" name="reply_of" value="<?php echo $comment->id; ?>" required>
                                                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" required>

                                                <div class="col-md-12">
                                                    <label>Your name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <label>Your email address</label>
                                                    <input type="email" name="email" class="form-control" required>
                                                    </p>

                                                    <div class="col-md-12">
                                                        <label>Comment</label>
                                                        <textarea name="comment" class="form-control" required></textarea>
                                                    </div>

                                                    <p>
                                                        <input type="submit" value="Send Reply" class="btn btn-primary w-100 mt-4" name="do_reply">
                                                    </p>
                                            </form>
                                    </div>
                                            <ul class="comments reply">
                                                <?php foreach ($comment->replies as $reply) : ?>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <?php echo "<b>".$reply->name."</b>"; ?>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <?php echo $reply->comment; ?>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <?php echo date("F d, Y h:i a", strtotime($reply->created_at)); ?>
                                                        </div>

                                                        <div class="btn btn-info" onclick="showReplyForReplyForm(this);" data-name="<?php echo $reply->name; ?>" data-id="<?php echo $comment->id; ?>"> Reply <i class="fa fa-reply" style="color: #fff;"></i></div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endforeach; ?>
                                            <button class="btn btn-secondary w-50" id="show">Show More</button>
                                </ul>


                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showReplyForm(self) {
        var commentId = self.getAttribute("data-id");
        if (document.getElementById("form-" + commentId).style.display == "") {
            document.getElementById("form-" + commentId).style.display = "none";
        } else {
            document.getElementById("form-" + commentId).style.display = "";
        }
    }
</script>
<script>
    function showReplyForReplyForm(self) {
        var commentId = self.getAttribute("data-id");
        var name = self.getAttribute("data-name");

        if (document.getElementById("form-" + commentId).style.display == "") {
            document.getElementById("form-" + commentId).style.display = "none";
        } else {
            document.getElementById("form-" + commentId).style.display = "";
        }

        document.querySelector("#form-" + commentId + " textarea[name=comment]").value = "@" + name;
        document.getElementById("form-" + commentId).scrollIntoView();
    }
</script>
<script>
    $(document).ready(function() {
            var commentCount = 2;
        $("#show").click(function() {
            commentCount = commentCount + 2;
            $("#comments").load("reply.php", {
                commentNewCount: commentCount
            });
        });
    });
</script>

</body>

</html>