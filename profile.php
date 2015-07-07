<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
    die();
}
include 'library.php';
dbConnect();
if(isset($_REQUEST['username'])){
    $username = safeString($_REQUEST['username']);
    $userid = getuserid($username);
    if($userid){
        $profile = mysql_query("SELECT * FROM extendedinfo WHERE uid = " . $userid) or die(mysql_error());
        $attr = mysql_fetch_array($profile);
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
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />    
        <link rel="stylesheet" href="css/profile.css" />
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
    </head>
    <body>
        <?php include 'sidebar.php'; ?>
        <div class="container">
        <?php include 'headbar.php'; ?>
            <div class="profile-container">
                <div class="pure-g" style="padding-right: 10px;">
                    <div class="pure-u-1 bg-white block-flat">
                        <div class="pure-g">
                            <div class="pure-u-1 pure-u-md-1-8">
                                <div class="avatar" style="background-image: url('<?php echo $attr['avatarpath']; ?>');"></div>                                
                            </div>
                            <div class="pure-u-1 pure-u-md-7-8">
                                <h4 class="center-on-mobile"><?php echo $attr['fname'] . ' ' . $attr['lname'] ?></h4>
                                <p class="center-on-mobile"><?php echo $attr['about']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pure-g" style="padding: 20px 10px 20px 0px;">
                        <div class="pure-u-1 pure-u-md-1-2" style="margin: 0 0px 0 0;">
                            <div class="pure-g">
                                <div class="pure-u-1">
                            <div class="full-span" style="  padding: 0 5px;border-bottom: 1px solid #E1E1E1;margin-bottom: 15px;">
                                <p class="margin0 bold" style="font-size: 16px;text-transform: uppercase;">timeline</p>
                            </div>
                            <ul class="timeline">
                                <?php
                                $activity = mysql_query("SELECT * FROM activitylog WHERE uid = $userid ORDER BY timestamp DESC LIMIT 15") or die(mysql_error());
                                if(mysql_num_rows($activity)){
                                    while($act = mysql_fetch_array($activity)){
                                        $hdnT = $act['timestamp'];
                                        if($act['type']=="0"){ //upvotetothread
                                            $tar = mysql_query("SELECT thread.srno,thread.description FROM thread ,upvotes_to_thread where upvotes_to_thread.srno = " . $act['ref']." and thread.srno = upvotes_to_thread.tid") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            echo '<li>';
                                            echo '<a href="thread.php?tid=' . $tresult['srno'] . '" rel="external">';
                                            echo '<i class="fa fa-heart bg-red fg-white"></i>';
                                            echo '<span class="date">'.date('d M',strtotime($act['timestamp'])).'</span>';
                                            echo '<div class="content">';
                                            echo '<p><span style="font-size: 10pt !important;">'.$act['description'].'</span></p>';
                                            echo '<small class="fg-gray"><i class="fa fa-fw fa-clock-o fg-gray"></i> '.time_elapsed_string($act['timestamp']).'</small>';
                                            echo '</div>';
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                        if($act['type']=="1"){ //reply
                                            $tar = mysql_query("SELECT reply.tid,reply.srno FROM thread, reply where reply.srno = " . $act['ref']." and reply.tid = thread.srno") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            echo '<li>';
                                            echo '<a href="thread.php?tid=' . $tresult['tid'] . '#r' . $tresult['srno'] . '" rel="external">';
                                            echo '<i class="fa fa-comment bg-green fg-white"></i>';
                                            echo '<span class="date">'.date('d M',strtotime($act['timestamp'])).'</span>';
                                            echo '<div class="content">';
                                            echo '<p><span style="font-size: 10pt !important;">'.$act['description'].'</span></p>';
                                            echo '<small class="fg-gray"><i class="fa fa-fw fa-clock-o fg-gray"></i> '.time_elapsed_string($act['timestamp']).'</small>';
                                            echo '</div>';
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                        if($act['type']=="2"){ //rreply
                                            $tar = mysql_query("SELECT reply.tid,replies_to_reply.srno from thread,reply,replies_to_reply where replies_to_reply.srno=" . $act['ref'] . " and replies_to_reply.rid = reply.srno and reply.tid = thread.srno") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            echo '<li>';
                                            echo '<a href="thread.php?tid=' . $tresult['tid'] . '#rr' . $tresult['srno'] . '">';
                                            echo '<i class="fa fa-comments fg-white" style="background-color:#68537C;"></i>';
                                            echo '<span class="date">'.date('d M',strtotime($act['timestamp'])).'</span>';
                                            echo '<div class="content">';
                                            echo '<p><span style="font-size: 10pt !important;">'.$act['description'].'</span></p>';
                                            echo '<small class="fg-gray"><i class="fa fa-fw fa-clock-o fg-gray"></i> '.time_elapsed_string($act['timestamp']).'</small>';
                                            echo '</div>';
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                        if($act['type']=="3"){ //thread
                                            $tar = mysql_query("SELECT thread.srno from thread where thread.srno=" . $act['ref'] . "") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            echo '<li>';
                                            echo '<a href="thread.php?tid=' . $tresult['srno'] . '">';
                                            echo '<i class="fa fa-leanpub bg-gray fg-white"></i>';
                                            echo '<span class="date">'.date('d M',strtotime($act['timestamp'])).'</span>';
                                            echo '<div class="content">';
                                            echo '<p><span style="font-size: 10pt !important;">'.$act['description'].'</span></p>';
                                            echo '<small class="fg-gray"><i class="fa fa-fw fa-clock-o fg-gray"></i> '.time_elapsed_string($act['timestamp']).'</small>';
                                            echo '</div>';
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                        if($act['type']=="4"){ //upvotetoreply
                                            $tar = mysql_query("SELECT reply.tid,reply.srno FROM thread, reply,upvotes_to_replies where upvotes_to_replies.srno = " . $act['ref']." and reply.tid = thread.srno and upvotes_to_replies.rid = reply.srno") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            echo '<li>';
                                            echo '<a href="thread.php?tid=' . $tresult['tid'] . '#r' . $tresult['srno'] . '" rel="external">';
                                            echo '<i class="fa fa-heart bg-darkRed fg-white"></i>';
                                            echo '<span class="date">'.date('d M',strtotime($act['timestamp'])).'</span>';
                                            echo '<div class="content">';
                                            echo '<p><span style="font-size: 10pt !important;">'.$act['description'].'</span></p>';
                                            echo '<small class="fg-gray"><i class="fa fa-fw fa-clock-o fg-gray"></i> '.time_elapsed_string($act['timestamp']).'</small>';
                                            echo '</div>';
                                            echo '</a>';    
                                            echo '</li>';
                                        }                                    
                                    }
                                    echo '<input type="hidden" value="'.$hdnT.'" id="hdnTimelineT" />';
                                    echo '<a href="javascript:;" data-uname="'.$userid.'" class="fg-darker loadMoreTimeline"><i class="fa fa-refresh txt-center" style="margin:0 0 20px 80px;"></i> Load More</a>';
                                }
                                $u = mysql_query("SELECT username, timestamp FROM useraccounts WHERE srno = $userid") or die(mysql_error());
                                $ut = mysql_fetch_array($u);
                                echo '<li class="joined-li">';
                                echo '<a href="profile.php?username=' . $ut['username'] .'" rel="external">';
                                echo '<i class="fa fa-user bg-globalColor fg-white"></i>';
//                                echo '<span class="date fg-dark" style="padding-top:2px;">'.date('d M y',strtotime($ut['timestamp'])).'</span>';
                                echo '<div class="content">';
                                echo '<p  class="bold"><span style="font-size: 10pt !important;"><i class="fa fa-fw fa-clock-o fg-gray"></i> Joined Soapbox on </span> <small class="fg-gray"> '.date('d M Y',strtotime($ut['timestamp'])).'</small></p>';
                                echo '</div>';
                                echo '</a>';    
                                echo '</li>';
                                ?>
                            </ul>
                            </div>
                            </div>
                        </div>
                        <div class="pure-u-1 pure-u-md-1-2 profile-content-parent">
                            <div class="pure-u-1">
                                <div class="full-span" style="  padding: 0 5px;border-bottom: 1px solid #E1E1E1;margin-bottom: 10px;">
                                    <p class="margin0 bold" style="font-size: 16px;text-transform: uppercase;">personal info</p>
                                </div>
                                <div class="pure-g">
                                <div class="bg-white tab-content block-flat full-span">       
                                        <?php
                                        $result = mysql_query("SELECT * FROM extendedinfo WHERE uid = " . $userid) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                            echo '<div class="pure-u-1">';
                                            echo '<div class="pure-u-1-4">';
                                            echo '<p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">GENDER</p>';
                                            echo '</div>';
                                            echo '<div class="pure-u-md-1-2 pure-u-17-24">';
                                            if ($row['gender'] == 'm') {
                                                echo '<p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">Male</p>';
                                            } else {
                                                echo '<p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">Female</p>';
                                            }
                                            echo'</div>';
                                            echo '</div>';
                                            echo '<div class="pure-u-1">';
                                            echo '<div class="pure-u-1-4">';
                                            echo '<p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">EMAIL</p>';
                                            echo '</div>';
                                            echo '<div class="pure-u-md-1-2 pure-u-17-24">';
                                            echo '<p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['email'] . '</p>';
                                            echo '</div>';
                                            echo '</div>';
                                            if ($row['hometown'] != "") {
                                                echo '<div class="pure-u-1">';
                                                echo '<div class="pure-u-1-4">';
                                                echo '<p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">HOMETOWN</p>';
                                                echo '</div>';
                                                echo '<div class="pure-u-md-1-2 pure-u-17-24">';
                                                echo '<p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['hometown'] . '</p>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            if ($row['city'] != "") {
                                                echo '<div class="pure-u-1">
                                        <div class="pure-u-1-4">
                                            <p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">CURRENT CITY</p>
                                        </div>
                                        <div class="pure-u-md-1-2 pure-u-17-24">
                                        <p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['city'] . '</p>
                                        </div>
                                    </div>';
                                            }
                                            if ($row['profession'] != "") {
                                                echo '<div class="pure-u-1">
                                        <div class="pure-u-1-4">
                                            <p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">PROFESSION</p>
                                        </div>
                                        <div class="pure-u-md-1-2 pure-u-17-24">
                                        <p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['profession'] . '</p>
                                        </div>
                                    </div>';
                                            }
                                            if ($row['education'] != "") {
                                                echo '<div class="pure-u-1">
                                        <div class="pure-u-1-4">
                                            <p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">EDUCATION</p>
                                        </div>
                                        <div class="pure-u-md-1-2 pure-u-17-24">
                                        <p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['education'] . '</p>
                                        </div>
                                    </div>';
                                            }
                                            if ($row['college'] != "") {
                                                echo '<div class="pure-u-1">
                                        <div class="pure-u-1-4">
                                            <p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">COLLEGE</p>
                                        </div>
                                        <div class="pure-u-md-1-2 pure-u-17-24">
                                        <p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['college'] . '</p>
                                        </div>
                                    </div>';
                                            }
                                            if ($row['school'] != "") {
                                                echo '<div class="pure-u-1">
                                        <div class="pure-u-1-4">
                                            <p class="bold margin0 fg-grayDarker" style="padding: 10px 0;font-size: 13px;">SCHOOL</p>
                                        </div>
                                        <div class="pure-u-md-1-2 pure-u-17-24">
                                        <p class="bold margin0 fg-gray" style="padding: 10px 0;font-size: 13px;">' . $row['school'] . '</p>
                                        </div>
                                        </div>';
                                            }
                                        }
                                        ?>
                                </div>
                                </div>
                            </div>
                            <div class="pure-u-1">
                                <div class="bg-white block-flat total-ques-stat">
                                    <div class="full-span bg-gray" style="padding: 7px 10px;border-bottom: 1px solid rgba(0,0,0,0.05);">
                                        <p class="margin0 bold fg-white">Top Threads</p>
                                    </div>
                                    <div class="full-span">
                                        <ul>
                                            <?php
                                            $result1 = mysql_query("SELECT thread.*,COUNT(upvotes_to_thread.tid) AS upvotes FROM thread LEFT JOIN upvotes_to_thread ON thread.srno = upvotes_to_thread.tid WHERE thread.uid = ". $userid." GROUP BY thread.srno ORDER BY upvotes DESC LIMIT 5") or die(mysql_error());
                                            if(mysql_num_rows($result1)){
                                            while ($thread = mysql_fetch_array($result1)) {   
                                            $cnt = $thread['upvotes'];
                                            echo '<li>';
                                            echo '<a href="thread.php?tid='.$thread['srno'].'" rel="external">';
                                            if(strlen($thread['title'])>50){
                                                echo '<p class="margin0">' . substr($thread['title'], 0, 50) . '... <span class="flt-right">'. $cnt .' <i class="fa fa-fw fa-heart fg-red"></i></span></p>';
                                            }
                                            else{
                                                echo '<p class="margin0">' . $thread['title'] . '<span class="flt-right">'. $cnt .' <i class="fa fa-fw fa-heart fg-red"></i></span></p>';
                                            }
                                            echo '';
                                            echo '</a>';
                                            echo '</li>';
                                            }
                                            }
                                            else{
                                                echo '<li><p class="margin0 txt-center">No threads found</p></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pure-u-1">
                                <div class="bg-white block-flat total-ques-stat">
                                    <div class="full-span bg-lightOlive" style="padding: 7px 10px;border-bottom: 1px solid rgba(0,0,0,0.05);">
                                        <p class="margin0 bold fg-white">Top Replies</p>
                                    </div>
                                    <div class="full-span">
                                        <ul class="replies">
                                            <?php
                                            $result1 = mysql_query("select reply.*, COUNT(upvotes_to_replies.rid) AS replycnt FROM reply LEFT JOIN upvotes_to_replies ON reply.srno = upvotes_to_replies.rid WHERE reply.uid = ". $userid." GROUP BY reply.srno ORDER BY replycnt DESC LIMIT 5") or die(mysql_error());
                                            if(mysql_num_rows($result1)){
                                            while($reply = mysql_fetch_array($result1)){
                                            $cnt = $reply['replycnt'];
                                            echo '<li class="pointer">';
                                            echo '<a class="pr" id="'.$reply['srno'].'&'.$reply['tid'].'">';
                                            $str = strip_tags($reply['description']);
                                            if(strlen($str) > 50){
                                                echo '<p class="margin0">' . substr($str, 0, 50) . '...<span class="flt-right">' . $cnt .' <i class="fa fa-fw fa-heart fg-darkRed"></i></span></p>';
                                            }
                                            else{
                                                echo '<p class="margin0">' . $str . '<span class="flt-right">' . $cnt .' <i class="fa fa-fw fa-heart fg-darkRed"></i></span></p>';
                                            }
                                            echo '</a>';
                                            echo '</li>';
                                            }
                                            }
                                            else{
                                                echo '<li><p class="margin0 txt-center">No replies found</p></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pure-u-1">
                                <div class="bg-white block-flat total-ques-stat">
                                    <?php
                                    $result1 = mysql_query("select * from thread_tags, thread where thread_tags.tid = thread.srno and thread.uid = ". $userid) or die(mysql_error());
                                    ?>
                                    <div class="full-span bg-darkCyan" style="padding: 7px 10px;border-bottom: 1px solid rgba(0,0,0,0.05);">
                                        <p class="margin0 bold fg-white"><?php echo mysql_num_rows($result1); ?> Tags</p>
                                    </div>
                                    <div class="full-span" style="padding: 10px 10px 0 10px;">
                                        <?php
                                        $result1 = mysql_query("SELECT thread_tags.name,COUNT(thread_tags.name) as tagcnt FROM thread_tags LEFT JOIN thread ON thread_tags.tid = thread.srno WHERE thread.uid = ". $userid." GROUP BY thread_tags.name ORDER BY tagcnt DESC");
                                        while($tags = mysql_fetch_array($result1)){
                                            $cnt = $tags['tagcnt'];
                                            echo '<div style="display:inline-block;padding: 0 5px 5px 0;"><a href="tag.php?t=' . $tags['name'] . '" class="featured-tag" rel="external">' . $tags['name'] . '</a><small>x ' . $cnt . '</small></div>';
                                        }
                                        ?>
<!--                                        <div style="display:inline-block;padding: 0 5px 5px 0;"><a href="#" class="featured-tag">soapbox</a><small>x 34</small></div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/profile.js"></script>
    <script src="js/main.js"></script>
</body>
</html>