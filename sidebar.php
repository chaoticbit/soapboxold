<div class="sidebar">
            <div class="padder">
                <ul class="side-nav">
                    <li>
                        <a href="profile.php?username=<?php echo $_SESSION['username']; ?>" rel="external">
                            <div class="info">
                                <input type="hidden" value="<?php echo $_SESSION['username']; ?>" class="hdnuname" />
                                <div class="thumb-pic generic-pic flt-left bg-white" style="background-image: url('<?php echo $_SESSION['avatar']; ?>');"></div>
                                <div class="name flt-left"><p class="fg-white bold margin0 txt-left"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] . "<br />" . $_SESSION['username']; ?></p></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="index.php" rel="external">
                            <i class="fa fa-home side-nav-icon"></i>
                            <span class="side-nav-title">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="categories.php" rel="external">
                            <i class="fa fa-th-large side-nav-icon"></i>
                            <span class="side-nav-title">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="yourthreads.php" rel="external">
                            <i class="fa fa-paperclip side-nav-icon"></i>
                            <span class="side-nav-title">Your Threads</span>
                        </a>
                    </li>
                    <li>
                        <div class="popover notifications-popover">
                            <span class="fa fa-caret-left fa-2x notifier-caret"></span>
                            <div style="position: fixed;padding: 4px 15px;border-bottom: 1px solid rgba(0,0,0,0.1);width: 345px;font-size: 14px;"><span class="txt-left"><a href="#" class="readAll">Read All</a></span></div>
                                    <?php          
                                    echo '<div class="popover-content" id="popovercontent_'. $_SESSION['userid'].'">';
                                    echo '<ul>';
                                    $notify = mysql_query("SELECT * FROM notifications WHERE notifications.uid =" . $_SESSION['userid'] . " ORDER BY readflag,timestamp desc") or die(mysql_error());
                                    if(mysql_num_rows($notify)){
                                    while ($row = mysql_fetch_array($notify)) {
                                        if($row['type']=="1") {
                                            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,reply.tid,reply.srno,thread.title FROM thread, reply, extendedinfo where reply.srno = " . $row['ref']." and reply.tid = thread.srno and reply.uid = extendedinfo.uid") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            if($row['readflag']!='0'){
                                                echo '<li>';
                                            }
                                            else{
                                                echo '<li style="background:rgba(0,0,0,0.04);">';
                                            }
                                                echo '<a href="thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] .'#r' . $tresult['srno'].'">';
                                                echo '<div class="pure-u-1-6"><div class="thumb-beeper-pic generic-pic" style="background-image: url(\''.$tresult['avatarpath'].'\');"></div></div>';
                                                echo '<div class="pure-u-19-24" style="display: -webkit-inline-box;padding: 10px;font-size: 14px;">'.$tresult['fname'].' '.$tresult['lname'].' left a reply on a thread ' . substr($tresult['title'],0,20).'</div>';
                                                echo '</a>';
                                                echo '</li>';
                                        }
                                        if($row['type']=="2"){
                                            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,reply.description,reply.tid,replies_to_reply.srno from thread,reply,replies_to_reply,extendedinfo where replies_to_reply.srno=" . $row['ref'] . " and replies_to_reply.rid = reply.srno and reply.tid = thread.srno and replies_to_reply.uid = extendedinfo.uid") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            if($row['readflag']!='0'){
                                                echo '<li>';
                                            }
                                            else{
                                                echo '<li style="background:rgba(0,0,0,0.04);">';
                                            }
                                                echo '<a href="thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] .'#rr' . $tresult['srno'].'">';
                                                echo '<div class="pure-u-1-6"><div class="thumb-beeper-pic generic-pic" style="background-image: url(\''.$tresult['avatarpath'].'\');"></div></div>';
                                                echo '<div class="pure-u-19-24" style="display: -webkit-inline-box;padding: 10px;font-size: 14px;">'.$tresult['fname'].' '.$tresult['lname'].' left a comment on your reply ' . substr(strip_tags($tresult['description']),0,20).'</div>';
                                                echo '</a>';
                                                echo '</li>';
                                        }
                                        if($row['type']=="3"){
                                            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,thread.srno,thread.title from thread,extendedinfo,upvotes_to_thread where upvotes_to_thread.srno=" . $row['ref'] . " and thread.srno = upvotes_to_thread.tid and upvotes_to_thread.uid = extendedinfo.uid") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            if($row['readflag']!='0'){
                                                echo '<li>';
                                            }
                                            else{
                                                echo '<li style="background:rgba(0,0,0,0.04);">';
                                            }
                                                echo '<a href="thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['srno'].'">';
                                                echo '<div class="pure-u-1-6"><div class="thumb-beeper-pic generic-pic" style="background-image: url(\''.$tresult['avatarpath'].'\');"></div></div>';
                                                echo '<div class="pure-u-19-24" style="display: -webkit-inline-box;padding: 10px;font-size: 14px;">'.$tresult['fname'].' '.$tresult['lname'].' upvoted ' . substr($tresult['title'],0,20).'</div>';
                                                echo '</a>';
                                                echo '</li>';
                                        }
                                        if($row['type']=="4"){
                                            $tar = mysql_query("SELECT extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, reply.description, reply.tid, reply.srno FROM thread, reply, extendedinfo, upvotes_to_replies where upvotes_to_replies.srno = " . $row['ref']." and reply.tid = thread.srno and upvotes_to_replies.rid=reply.srno and upvotes_to_replies.uid = extendedinfo.uid") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            if($row['readflag']!='0'){
                                                echo '<li>';
                                            }
                                            else{
                                                echo '<li style="background:rgba(0,0,0,0.04);">';
                                            }
                                                echo '<a href="thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['srno'].'">';
                                                echo '<div class="pure-u-1-6"><div class="thumb-beeper-pic generic-pic" style="background-image: url(\''.$tresult['avatarpath'].'\');"></div></div>';
                                                echo '<div class="pure-u-19-24" style="display: -webkit-inline-box;padding: 10px;font-size: 14px;">'.$tresult['fname'].' '.$tresult['lname'].' upvoted ' . substr(strip_tags($tresult['description']),0,20).'</div>';
                                                echo '</a>';
                                                echo '</li>';
                                        }
                                        if($row['type']=="5"){
                                            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,reply.description,reply.tid,reply.srno FROM thread, reply, extendedinfo where reply.srno = " . $row['ref']." and reply.tid = thread.srno and thread.uid = extendedinfo.uid") or die(mysql_error());
                                            $tresult = mysql_fetch_array($tar);
                                            if($row['readflag']!='0'){
                                                echo '<li>';
                                            }
                                            else{
                                                echo '<li style="background:rgba(0,0,0,0.04);">';
                                            }
                                                echo '<a href="thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] .'#r' . $tresult['srno'].'">';
                                                echo '<div class="pure-u-1-6"><div class="thumb-beeper-pic generic-pic" style="background-image: url(\''.$tresult['avatarpath'].'\');"></div></div>';
                                                echo '<div class="pure-u-19-24" style="display: -webkit-inline-box;padding: 10px;font-size: 14px;">' . $tresult['fname'].' '.$tresult['lname'].' marked your reply as correct.</div>';
                                                echo '</a>';
                                                echo '</li>';
                                        }        
                                    }
                                    echo '</ul>';
                                    }
                                    else {
                                        echo '<ul></ul><p class="margin0 notify-null" style="padding: 10px 5px 15px 5px;">No Notifications</p>';
                                    }
                                    echo '</div>';
                                    ?>
                        </div>
                        <a href="javascript:;" class="toggle-notify">
                            <i class="fa fa-bell side-nav-icon"></i>
                            <span class="side-nav-title">Notifications</span>
                            <?php 
                                $cnt = mysql_num_rows(mysql_query("select * from notifications where uid = " . $_SESSION['userid'] . " and readflag=0")); 
                                if($cnt>=1){
                                    echo '<span class="bubble bold" style="">' . $cnt . '</span>';
                                }
                                else{
                                    echo '<span class="bubble bold" style="display:none;">' . $cnt . '</span>';
                                }
                            ?>
                        </a>
                    </li>
                    <li>
                        <a href="readinglist.php" rel="external">
                            <i class="fa fa-book side-nav-icon"></i>
                            <span class="side-nav-title">Reading List</span>
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" rel="external">
                            <i class="fa fa-cog side-nav-icon"></i>
                            <span class="side-nav-title">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" rel="external">
                            <i class="fa fa-sign-out side-nav-icon"></i>
                            <span class="side-nav-title">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>        
        <div class="beeper-wrapper">
            <audio id="beep" controls preload="auto" style="display: none;">
                <source src="ping.mp3" type="audio/mp3">
                <source src="ping.mp4" type="audio/mp4">
            </audio>
            <ul>
<!--                <li class="beeper"><a href="javascript:;">
        <i class="beeper-close fa fa-times"></i>
        <div class="thumb-beeper-pic generic-pic flt-left bg-white" style="background-image: url('<?php echo $_SESSION['avatar']; ?>')"></div>
        <div class="beeper-desc flt-left"><p class="margin0 txt-left">Mihir Karandikar replied to your thread</p></div></a>
        </li>-->
            </ul>
        </div>
