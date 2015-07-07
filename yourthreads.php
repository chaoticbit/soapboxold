<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['fname'])) {
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
    die();
}
include 'library.php';
dbConnect();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SoapBox</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/index.css" />        
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
    </head>
    <body>
        <?php include 'sidebar.php'; ?>
        <div class="container">
        <?php include 'headbar.php'; ?>
            <div class="thread-container">
                <div class="flt-left thread-parent">
                    <div class="pure-g">
                        <?php
                        $result = mysql_query("SELECT category.name, useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, category WHERE thread.cid = category.srno and thread.uid = " . $_SESSION['userid'] . " and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid ORDER BY timestamp DESC LIMIT 10") or die(mysql_error());
                        if (mysql_num_rows($result)) {
                            while ($row = mysql_fetch_array($result)) {
                                $flag = 0;
                                $hiderequests = mysql_query("SELECT * FROM hidethread") or die(mysql_error());
                                while ($hide = mysql_fetch_array($hiderequests)) {
                                    if ($hide['tid'] == $row['srno'] && $hide['uid'] == $_SESSION['userid'])
                                        $flag = 1;
                                }
                                if ($flag) {
                                    continue;
                                }
                                $hdnT = $row['timestamp'];
                                if ($row['imagepath'] != "") {
                                echo'
                                <div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                                    <div class="pure-g">
                                        <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . ';"></div>';
                                }
                                else{
                                    echo '
                                <div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                                    <div class="pure-g">';
                                }
                                echo'
                                        <div class="pure-u-1" style="position: relative;">
                                            <div class="thread-owner-thumb" style="background-image: url(\'' . $row['avatarpath'] . '\');"></div>';
                                            if($row['uid']==$_SESSION['userid'])
                                                echo '<p class="bold thread-owner-link"><a href="profile.php?username=' . $row['username'] . '" rel="external">You</a></p>';
                                            else
                                                echo '<p class="bold thread-owner-link"><a href="profile.php?username=' . $row['username'] . '" rel="external">' . $row['fname'] . ' ' . $row['lname'] . '</a></p>';
                                            echo '<i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                                            <ul class="thread-options bg-white">
                                                <li><a href="javascript:;" onclick="hideThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>';
                                                $cmd = mysql_query("SELECT * FROM readinglist WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
                                                if (mysql_num_rows($cmd)) {
                                                    echo '<li class="bg-green fg-white">';
                                                    echo '<a href="javascript:;" onclick="rmReadingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-check"></i> Added to reading list</a>';
                                                    echo '</li>';
                                                } 
                                                else {
                                                    echo '<li><a href="javascript:;" onclick="readingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>';
                                                }
                                                $cmd = mysql_query("SELECT * FROM trackthread WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
                                                if (mysql_num_rows($cmd)) {
                                                    echo '<li class="bg-green fg-white">';
                                                    echo '<a href="javascript:;" onclick="rmTrackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-check"></i> Tracking this thread</a>';
                                                    echo '</li>';
                                                } 
                                                else {
                                                    echo '<li><a href="javascript:;" onclick="trackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i> Track this thread</a></li>';
                                                }
                                                if($_SESSION['userid']==$row['uid']){
                                                    echo '<li><a href="javascript:;" onclick="deleteThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete this thread</a></li>';
                                                }
                                            echo'</ul>
                                        </div>
                                        <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                                            <p class="bold margin0" style="font-size: 20pt;"><a href="thread.php?tid=' . $row['srno'] . '" rel="external">' . $row['title'] . '</a></p>
                                        </div>
                                        <div class="pure-u-1 thread-description">
                                        ' . $row['description'] . '
                                            <div class="gradient"></div>
                                        </div>
                                        <div class="pure-u-1" style="padding: 5px 20px;">';
                                            echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $row['name'] . '</a>';
                                        $tags = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $row['srno']) or die(mysql_error());
                                        while ($tag = mysql_fetch_array($tags)) {
                                            echo '<a class="featured-tag" href="tag.php?t=' . $tag['name'] . '">' . $tag['name'] . '</a>';
                                        }
                                        echo '</div>';                                            
                                        $upvotes = mysql_query("SELECT COUNT(*) AS upvotes FROM upvotes_to_thread WHERE tid=" . $row['srno']) or die(mysql_error());
                                        $upvotes = mysql_fetch_array($upvotes);
                                        $replies = mysql_query("SELECT COUNT(*) AS replies FROM reply WHERE tid=" . $row['srno']) or die(mysql_error());
                                        $replies = mysql_fetch_array($replies);
                                        echo '<div class="pure-u-1">
                                                <div class="pure-g">
                                                <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-heart"></i> '; if($upvotes['upvotes']==1) {echo $upvotes['upvotes'] . ' <span class="hidden-for-mobile">Upvote</span>';} else{echo $upvotes['upvotes'] . ' <span class="hidden-for-mobile">Upvotes</span>';} echo '</p></div>
                                                <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-comments"></i> '; if($replies['replies']==1) {echo $replies['replies'] . ' <span class="hidden-for-mobile">Reply</span>';} else {echo $replies['replies'] . ' <span class="hidden-for-mobile">Replies</span>';} echo '</p></div>';
                                                echo '<div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-clock-o hidden-for-mobile"></i> <span class="t-time">' . time_elapsed_string($row['timestamp']) . '</span></p></div>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>';
                            }
                            echo '<input type="hidden" value="'.$hdnT.'" id="hdnT" />
                            <div class="pure-u-1 bg-white block-flat load-more-post-box" style="margin: 0 0 20px 0;padding: 10px;">
                                <p class="margin0 txt-center"><button class="load-more-post-mythreads btn-general bg-white fg-gray">LOAD MORE POSTS</button></p>
                            </div>';
                        } else {
                            echo '<div class="full-span" style="margin: 10px;"><h3 class="txt-center light">We couldn’t find any posts for you :(</h3></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script>
            $('.fa-paperclip').closest('li').addClass('active');
        </script>
        <script src="js/index.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>

