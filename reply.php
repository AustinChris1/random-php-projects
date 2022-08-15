<?php
require_once "databases/db_conn.php";
// include "header.php";
$commentNewCount = $_POST['commentNewCount'];
// $post = $db->query("SELECT * FROM posts LIMIT 5");
// $p = $post->fetch_assoc();
// foreach ($post as $posts) :
//     $post_id = $posts['id'];
$post_id = $_SESSION['pid'];
                            // get all comments of post
                            $result = $db->query("SELECT * FROM comments WHERE post_id = '$post_id' LIMIT $commentNewCount");

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
                                <ul class="comments row" >
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
