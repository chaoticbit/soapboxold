<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
    die();
}
include 'library.php';
dbConnect();
if(isset($_REQUEST['tid']) && is_whole($_REQUEST['tid'])){
    $tid = $_REQUEST['tid'];
    $tid = safeString($tid);
    if(isset($_REQUEST['noref'])) {
        $ref = safeString($_REQUEST['noref']);
        mysql_query("UPDATE notifications SET readflag=1 WHERE ref=$ref and uid=" . $_SESSION['userid']) or die(mysql_error());
    }
    $result = mysql_query("SELECT category.name, useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.edit, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, category WHERE thread.cid = category.srno and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid AND thread.srno = " . $tid) or die(mysql_error());
    if(mysql_num_rows($result)){
        $thread = mysql_fetch_array($result);
        mysql_query("INSERT INTO views values(" . $thread['srno'] . "," . $_SESSION['userid'] . ")");
    }
    else{
        echo '<meta http-equiv="refresh" content="0; url=index.php">';
        die();        
    }
}
else{
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    die();
}
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
        <link rel="stylesheet" href="css/thread.css" />        
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
        <link rel="stylesheet" href="css/medium-editor.css" />
    </head>
    <body> 
        <?php include 'sidebar.php'; ?>
        <div class="container">
            <?php include 'headbar.php'; ?>
            <div class="thread-container mobile-top-padding">
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-3-4 innerthreadcontainer">
                        <div class="pure-g">
                                    <?php
                                    if($thread['imagepath']!=""){
                                        echo '<div class="pure-u-1 bg-white block-flat thread">';
                                        echo '<div class="pure-g">';
                                        echo '<div class="pure-u-1 featured-thumbnail pointer" data-image="'.$thread['imagepath'].'" style="background-image: url(\'' . $thread['imagepath'] . '\');background-position: ' . $thread['coordinates'] . '"></div>';
                                    }
                                    else{
                                    echo '<div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">';
                                    echo '<div class="pure-g">';
                                    }
                                    ?>
                                    <div class="pure-u-1" style="position: relative;">
                                        <div class="thread-owner-thumb" style="background-image: url('<?php echo $thread['avatarpath']; ?>');"></div>
                                        <p class="bold thread-owner-link"><?php echo '<a rel="external" href="profile.php?username=' . $thread['username'] . '">' . $thread['fname'] . ' ' . $thread['lname'] . '</a>' ?>
                                            <?php
                                            if($_SESSION['userid']==$thread['uid']){
                                            	echo '<i class="fa fa-angle-down fa-fw options-toggle flt-right" style="padding-right: 15px;"></i>';
                                            }
                                            if($thread['edit']=='1'){
                                                echo '<a href="javascript:;" class="toggleEditHistory" data-tid="' . $thread['srno'] . '"><small class="fg-grayLight">Edited</small></a>';
                                            }
                                            ?>
                                        </p>
                                        <?php
                                        if($_SESSION['userid']==$thread['uid']){                                           
                                            echo
                                        '<ul class="thread-options bg-white">
                                            <li><a href="javascript:;" onclick="deleteThread(\'' . $thread['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete this thread</a></li>
                                            <li><a href="javascript:;" onclick="loadEditThread(\'' . $thread['srno'] . '\',\'' . $_SESSION['username'] . '\');"><i class="fa fa-fw fa-pencil-square"></i> Edit this thread</a></li>
                                        </ul>';
                                        } 
                                        ?>
                                    </div>
                                    <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                                        <h4 class="bold margin0"><?php echo $thread['title']; ?></h4>
                                    </div>
                                    <div class="pure-u-1 thread-description">
                                        <div class="thread-desc-inner">
                                            <?php echo $thread['description']; ?>
                                        </div>
                                    </div>
                                    <div class="pure-u-1" style="padding: 5px 20px;">
                                        <?php
                                        echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $thread['name'] . '</a>';
                                        $result = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $tid) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                            echo '<a class="featured-tag tagfx" href="tag.php?t=' . $row['name'] . '" rel="external">' . $row['name'] . '</a>';
                                        };
                                        ?>
                                    </div>
                                    <?php
                                    $upvote=  mysql_query("SELECT * FROM upvotes_to_thread WHERE tid=" . $thread['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());                                    
                                    $readinglist=  mysql_query("SELECT * FROM readinglist WHERE tid=" . $thread['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());                                    
                                    $track=  mysql_query("SELECT * FROM trackthread WHERE tid=" . $thread['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());
                                    ?>
                                    <div class="pure-u-1 desktop-actions" style="padding-top: 5px;">
                                        <div class="pure-g">
                                            <div class="pure-u-1-3 txt-center thread-action">
                                                <?php
                                                if(!mysql_num_rows($upvote)){
                                                    echo '<p class="margin0 bold"><a class="block" href="javascript:;" onclick="upvote(\'' . $thread['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-heart-o fa-fw"></i><span class="hidden-for-mobile"> Upvote this thread</span></a></p>';
                                                }
                                                else{
                                                    echo '<p class="margin0 bold"><a class="block" href="javascript:;" onclick="rmUpvote(\'' . $thread['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-heart fa-fw fg-red"></i><span class="hidden-for-mobile"> You upvoted</span></a></p>';
                                                }
                                                ?>
                                            </div>
                                            <div class="pure-u-1-3 txt-center thread-action">
                                                <?php
                                                if(!mysql_num_rows($readinglist)){
                                                    echo '<p class="margin0 bold"><a class="block" href="javascript:;" onclick="readingList(\'' . $thread['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-book fa-fw"></i><span class="hidden-for-mobile"> Add to reading list</span></a></p>';
                                                }
                                                else{
                                                    echo '<p class="margin0 bold"><a class="block" href="javascript:;" onclick="rmReadingList(\'' . $thread['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-check fa-fw fg-green"></i><span class="hidden-for-mobile"> Added to reading list</span></a></p>';
                                                }
                                                ?>
                                            </div>
                                            <div class="pure-u-1-3 txt-center thread-action">
                                                <?php
                                                if(!mysql_num_rows($track)){
                                                    echo '<p class="margin0 bold"><a class="block" href="javascript:;" onclick="trackThread(\'' . $thread['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i><span class="hidden-for-mobile"> Track this thread</span></a></p>';
                                                }
                                                else{
                                                    echo '<p class="margin0 bold"><a class="block" href="javascript:;" onclick="rmTrackThread(\'' . $thread['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-check fa-fw fg-green"></i><span class="hidden-for-mobile"> Tracking this thread</span></a></p>';
                                                }
                                                ?>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pure-u-1 bg-white block-flat new-reply" style="padding: 20px;margin-top: 20px;">
                            <p class="stat-title bold margin0">reply to this thread</p>
                            <div class="editable" data-text=""></div>
                            <textarea class="duptarea" data-id="<?php echo $thread['srno']; ?>" name="reply-description" style="display: none;"></textarea>
                            <div class="pure-g">
                                <div class="pure-u-1 pure-u-md-4-5"></div>
                                <div class="pure-u-1 pure-u-md-1-5">
                                    <button class="btn-general bg-cyan fg-white btn-submit-reply">REPLY</button>
                                </div>
                            </div>
                        </div>
                        <!-- reply starts -->
                        <?php
                        $result1 = mysql_query("SELECT useraccounts.username,extendedinfo.fname, extendedinfo.lname, reply.srno, reply.description, reply.timestamp, reply.correct, reply.uid FROM useraccounts,reply, extendedinfo WHERE reply.tid = " . $thread['srno']." AND reply.uid = extendedinfo.uid and extendedinfo.uid = useraccounts.srno ORDER BY correct desc") or die(mysql_error());
                        if(mysql_num_rows($result1)){
                            while($reply = mysql_fetch_array($result1)){    
                            echo '<div class="pure-u-1 bg-white block-flat reply" id="r' . $reply['srno'] . '" style="border: 0px solid transparent;margin-top: 20px;position: relative;">';
                            echo '<div class="pure-g">';
                            echo '<div class="pure-u-1 pure-u-md-1-12">';
                            echo '<div class="pure-g">';
                            echo '<div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center padding-hack">';
                            $result2 = mysql_query("SELECT * FROM upvotes_to_replies WHERE rid = " . $reply['srno']) or die(mysql_error());
                            $upvoteToReply = mysql_query("SELECT * FROM upvotes_to_replies WHERE rid=" . $reply['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());
                            if(mysql_num_rows($upvoteToReply)){
                                echo '<a href="javascript:;" onclick="rmUpvoteToReply(\'' . $reply['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-heart fa-fw fa-2x fg-red"></i></a><br/><small>' . mysql_num_rows($result2) .'</small>';
                            }
                            else{
                                echo '<a href="javascript:;" onclick="upvoteToReply(\'' . $reply['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-heart fa-fw fa-2x fg-grayLight"></i></a><br/><small>' . mysql_num_rows($result2) .'</small>';
                            }
                            echo '</div>';
                            echo '<div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center">';
                            echo '<input type="hidden" class="hdn-rid" value="' . $reply['srno'] . '">';
                            if($reply['correct']==1){
                                echo '<a href="javascript:;"';
                                if($_SESSION['userid'] == $thread['uid']){
                                    echo 'onclick="rmMarkCorrect(\'' . $reply['srno'] . '\',\'' . $thread['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"';
                                }
                                echo '><i class="fa fa-check-circle fa-fw fa-2x fg-green pointer"></i><br/></a><small>Correct</small>';
                            }
                            else if($_SESSION['userid'] == $thread['uid']){
                                echo '<a href="javascript:;" onclick="markCorrect(\'' . $reply['srno'] . '\',\'' . $thread['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-check-circle fa-fw fa-2x fg-grayLight pointer mark-correct"></i><br/></a><small>Correct</small>';
                            }
                            echo '</div>';                                        
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="pure-u-1 pure-u-md-11-12 reply-text">';
                            echo '<p class="margin0">' . $reply['description'] . '</p>';
                            echo '</div>';
                            echo '<div class="pure-u-1 reply-owner">';
                            echo '<div class="pure-g">';
                            echo '<div class="offset-md-1-12"></div>';
                            echo '<div class="pure-u-1 pure-u-md-11-12">';
                            echo '<div class="pure-g">';
                            echo '<div class="pure-u-1" style="position: relative;">';
                            echo '<p class="bold txt-right margin0 thread-owner-link">';
                            echo '<a href="profile.php?username='.$reply['username'].'" rel="external">'.$reply['fname'] .' '. $reply['lname']. ' </a> <small class="light fg-gray">' . time_elapsed_string($reply['timestamp']) . '</small>';
                            if($reply['uid']==$_SESSION['userid']){
                                echo '<i class="fa fa-angle-down fa-fw options-toggle"></i></p>';
                            }
                            echo '<ul class="thread-options bg-white reply-options">';
                            if($reply['uid']==$_SESSION['userid']){
                                echo '<li><a href="javascript:;" onclick="deleteReply(\'' . $reply['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="pure-u-1 reply-to-reply">';
                            echo '<div class="pure-g">';
                            echo '<div class="offset-md-1-12"></div>';
                            echo '<div class="pure-u-11-12">';
                            echo '<input type="text" class="txt-general add-comment margin0" placeholder="add a comment" onkeyup="addComment(\'' . $reply['srno'] . '\', this, event)" />';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            $result3 = mysql_query("SELECT useraccounts.username,extendedinfo.fname, extendedinfo.lname, replies_to_reply.srno, replies_to_reply.uid, replies_to_reply.description, replies_to_reply.timestamp FROM useraccounts,extendedinfo,replies_to_reply WHERE replies_to_reply.rid=".$reply['srno']." and replies_to_reply.uid = extendedinfo.uid and extendedinfo.uid = useraccounts.srno ORDER BY timestamp desc") or die(mysql_error());
                            echo '<div class="pure-u-1 reply-replies" style="padding-top: 5px;">';
                            if(mysql_num_rows($result3)){
                                while($replies = mysql_fetch_array($result3)){
                                echo '<div class="pure-g" id="rr' . $replies['srno'] . '">';
                                echo '<div class="offset-md-1-12"></div>';
                                echo '<div class="pure-u-1 pure-u-md-11-12 r2r" style="padding-right: 20px;position: relative;">';
                                if($replies['uid']==$_SESSION['userid']){
                                    echo '<i class="fa fa-times fa-fw delete-r2r" onclick="rmReplyToReply(\'' . $replies['srno'] . '\',\'' . $_SESSION['username'] . '\',this);" style="position: absolute;top: 2px;right: 0;"></i>';
                                }
                                echo '<p class="comment txt-justify margin0"><small>' . $replies['description'] . ' –<span class="bold thread-owner-link"><a href="profile.php?username='.$replies['username'].'" rel="external">'.$replies['fname'] .' '. $replies['lname']. '</a></span> <span class="fg-gray">' . time_elapsed_string($replies['timestamp']) . '</span></small></p>';
                                echo '</div>';
                                echo '</div>';
                                }
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            }
                        }
                        else{
                            echo '<div class="pure-u-1 block-flat bg-white txt-center noreplybox" style="margin-top:20px;padding: 5px;"><p class="bold margin0">No Replies :(</p></div>';
                        }
                        ?>
<!--                        <div class="pure-u-1 bg-white block-flat reply" style="margin-top: 20px;position: relative;">
                            <div class="pure-g">-->
<!--                                <div class="pure-u-1 pure-u-md-1-12">
                                    <div class="pure-g">
                                        <div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center padding-hack">
                                            <i class="fa fa-heart fa-fw fa-2x fg-grayLight"></i><br/><small>9999</small>
                                        </div>
                                        <div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center">
                                            <i class="fa fa-check-circle fa-fw fa-2x fg-grayLight"></i><br/><small>Correct</small>
                                        </div>                                        
                                    </div>
                                </div>-->
<!--                                <div class="pure-u-1 pure-u-md-11-12 reply-text">
                                    <p class="margin0">Publisher Activision launched the Ascendance downloadable content for Call of Duty: Advanced Warfare today on Xbox One, but some gamers who own the map pack cannot download it. Microsoft and Activision have confirmed that they are working to fix a problem where Xbox Live asks gamers to pay for the new Ascendance content even if they already have purchased a season pass for all Advanced Warfare DLC. This is the latest manifestation of this problem, which previously plagued an earlier add-on pack for this Call of Duty release on Xbox One.</p>
                                </div>
                                <div class="pure-u-1 reply-owner">
                                    <div class="pure-g">
                                        <div class="offset-md-1-12"></div>
                                        <div class="pure-u-1 pure-u-md-11-12">
                                            <div class="pure-g">
                                                <div class="pure-u-1" style="position: relative;">
                                                    <p class="bold txt-right margin0">
                                                        Jitesh Deshpande <small class="light fg-gray">6 hours ago</small><i class="fa fa-angle-down fa-fw options-toggle"></i>
                                                    </p>
                                                    <ul class="thread-options bg-white reply-options">
                                                        <li><a href="javascript:;" onclick="hideThread();"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
                                                        <li><a href="javascript:;" onclick="readingList();"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a></li>
                                                    </ul>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
<!--                                <div class="pure-u-1 reply-to-reply">
                                    <div class="pure-g">
                                        <div class="offset-md-1-12"></div>
                                        <div class="pure-u-11-12">
                                            <input type="text" class="txt-general add-comment margin0" placeholder="add a comment" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pure-u-1 reply-replies">
                                    <div class="pure-g">
                                        <div class="offset-md-1-12"></div>
                                        <div class="pure-u-1 pure-u-md-11-12">
                                            <p class="comment txt-justify"><small>Soapbox Editor gives you a feel of control. You can decorate your thread with the most basic editing tools, on the fly. There is nothing like raw text in Soapbox Editor. Everything you do exactly looks like a live thread! –<span class="bold">Mihir Karandikar</span> <span class="fg-gray">Jul 9 '12 at 14:11</span></small></p>
                                            <p class="comment txt-justify"><small>Soapbox Editor gives you a feel of control. You can decorate your thread with the most basic editing tools, on the fly. There is nothing like raw text in Soapbox Editor. Everything you do exactly looks like a live thread! –<span class="bold">Mihir Karandikar</span> <span class="fg-gray">Jul 9 '12 at 14:11</span></small></p>
                                            <p class="comment txt-justify"><small>Soapbox Editor gives you a feel of control. You can decorate your thread with the most basic editing tools, on the fly. There is nothing like raw text in Soapbox Editor. Everything you do exactly looks like a live thread! –<span class="bold">Mihir Karandikar</span> <span class="fg-gray">Jul 9 '12 at 14:11</span></small></p>
                                        </div>
                                    </div>
                                </div>-->
<!--                            </div>
                        </div> reply ends -->
                    </div>
                    <div class="pure-u-1 pure-u-md-1-4 statistics" style="padding: 0 20px;">
                        <div class="pure-g">
                            <div class="pure-u-1 txt-center" style="padding: 0 20px 10px 20px;">
                                <p class="stat-title bold margin0">statistics</p>
                            </div>
                            <?php
                            $upvotes = mysql_query("SELECT COUNT(*) as upvotes FROM upvotes_to_thread WHERE tid=" . $tid) or die(mysql_error());
                            $count = mysql_fetch_array($upvotes);
                            $count = $count['upvotes'];
                            ?>
                            <div class="pure-u-md-1 txt-center bg-white block-flat gradient-stat upvotes-toggle" title="Click to view upvoters" data-tid="<?php echo $thread['srno']; ?>" style="padding: 10px 20px;margin-bottom: 20px;">
                                <i class="fa fa-heart fa-fw fa-3x fg-red"></i>
                                <p class="margin0 bold"><?php if($count==1) {echo $count . " Upvote";} else {echo $count . " Upvotes";} ?></p>
                            </div>
                            <?php
                            $replies = mysql_query("SELECT COUNT(*) as replies FROM reply WHERE tid=" . $tid) or die(mysql_error());
                            $count = mysql_fetch_array($replies);
                            $count = $count['replies'];
                            ?>                            
                            <div class="pure-u-md-1 txt-center bg-white block-flat gradient-stat replies-toggle" style="padding: 10px 20px;margin-bottom: 20px;">
                                <i class="fa fa-comments fa-fw fa-3x fg-cyan"></i>
                                <p class="margin0 bold"><?php if($count==1) {echo $count . " Reply";} else {echo $count . " Replies";} ?></p>
                            </div>
                            <?php
                            $views = mysql_query("SELECT COUNT(*) as views FROM views WHERE tid=" . $tid) or die(mysql_error());
                            $count = mysql_fetch_array($views);
                            $count = $count['views'];
                            ?>                                                        
                            <div class="pure-u-md-1 txt-center bg-white block-flat gradient-stat views-toggle" title="Click to view viewers"  data-tid="<?php echo $thread['srno']; ?>" style="padding: 10px 20px;margin-bottom: 20px;">
                                <i class="fa fa-eye fa-fw fa-3x fg-green"></i>
                                <p class="margin0 bold"><?php if($count==1) {echo $count . " View";} else {echo $count . " Views";} ?></p>
                            </div>
                        </div>
                    </div>
            <div class="full-span bg-white footer" style="left: 0;display: none;bottom: 0;padding: 13px 10px;position: fixed;-webkit-filter: drop-shadow(0px 0px 5px rgba(0,0,0,0.5));">
                <div style="position: relative;">
                    <div class="pure-g">
                        <div class="pure-u-1-2">
                            <a href="index.php" rel="external"  style="display:block;padding: 0 20px;">
                                <p class="margin0 bold" style="color: #3b5988;"><i class="fa fa-fw fa-home" style="color: #3b5988;font-size: 18px;"></i> Home</p>
                            </a>
                        </div>
                        <div class="pure-u-1-2"> 
                            <a  href="javascript:;" rel="external" style="display:block;padding: 0 10px;">
                                <p class="margin0 bold" style="color: #3b5988;"><i class="fa fa-fw fa-bell" style="color: #3b5988;font-size: 18px;"></i> Notifications 
                                    <span class="bubble">2</span>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            <script src="js/jquery-2.1.3.min.js"></script>
            <script src="js/medium-editor.js"></script>
            <script>
                var editor = new MediumEditor('.editable', {
                    buttonLabels: 'fontawesome',
                    buttons: ['bold', 'italic', 'underline', 'quote', 'anchor', 'pre', 'indent', 'unorderedlist'],
                    disablePlaceholders: true,
                    targetBlank: true,
                    externalInteraction: true,
                    imageDragging: false,
                    cleanPastedHTML: false
                });
                $('.editable').on('input', function () {
                    $('.duptarea').val($(this).html());
                });
                $(document).on('input focus','.edit-thread-editable',function () {
                    $('.edit-duptarea').val($(this).html());
                });
            </script>
            <script src="js/main.js"></script>
            <script src="js/thread.js"></script>
    </body>
</html>