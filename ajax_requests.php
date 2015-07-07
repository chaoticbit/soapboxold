<?php

session_start();

include 'library.php';

function namei($username) {

    $username = safeString($username);
    if ($username != $_SESSION['username']) {
        return false;
    }
    dbConnect();
    $result = mysql_query("SELECT srno FROM useraccounts WHERE username='$username'") or die(mysql_error());
    if ($result) {
        $row = mysql_fetch_array($result);
        return $row['srno'];
    }
    return false;
}

function checkUsername($param) {
    dbConnect();
    $result = mysql_query(("SELECT username FROM useraccounts WHERE username='$param'")) or die(mysql_error());
    if (mysql_num_rows($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
}

function checkPassword($param) {
    dbConnect();
    $param=  safeString($param);
    $result = mysql_query(("SELECT * FROM useraccounts WHERE password=md5('" . $param . "') AND username='" . $_SESSION['username'] . "'")) or die(mysql_error());
    if (mysql_num_rows($result)) {
        echo 'true';
    } else {
        echo 'false';
    }
}

function checkEmail($param) {
    dbConnect();
    $param=  safeString($param);
    $result = mysql_query(("SELECT * FROM extendedinfo WHERE email='$param'")) or die(mysql_error());
    if (mysql_num_rows($result)) {
        echo 'true';
    } 
    else {
        echo 'false';
    }
}

function updateEmail($param){
    dbConnect();
    $param = safeString($param);
    $result = mysql_query("SELECT * FROM extendedinfo WHERE email='" . $param . "'") or die(mysql_error());
    if(mysql_num_rows($result)){
        die('false');
    }
    $result = mysql_query("UPDATE extendedinfo SET email='" . $param . "' WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
    die('true');
}

function resetAc($username) {
    dbConnect();
    $username = safeString($username);
    $u = mysql_query("SELECT username,srno from useraccounts where username='$username'") or die(mysql_error());
    if(mysql_num_rows($u)){
        $rr = mysql_fetch_array($u);
        $result = mysql_query("SELECT question FROM extendedinfo WHERE uid=" . $rr['srno']) or die(mysql_error());
        $row = mysql_fetch_array($result);        
        echo $row['question'].'&&'.$rr['username'];
    }
    else{
        die('0');
    }
}

function resetAnswer($answer,$username) {
    dbConnect();
    $username = safeString($username);
    $answer = safeString($answer);
    $answer = md5($answer);
    $u = mysql_query("SELECT username,srno from useraccounts where username='$username'") or die(mysql_error());
    if(mysql_num_rows($u)){
        $rr = mysql_fetch_array($u);
        $result = mysql_query("SELECT * from extendedinfo WHERE answer = '$answer' and uid = " . $rr['srno']) or die(mysql_error());
        if(mysql_num_rows($result)){
            echo '1&&'.$rr['username'];
        }
        else{
            die('0');
        }
    }    
    else{
        die('0');
    }
}

function deleteimage($param) {
    if (strpos($param, 'userdata/' . $_SESSION['userid']) !== false) {
        unlink($param);
    }
}

function getInfo($param, $uid) {
    dbConnect();

    switch ($param) {
        case 'username' : $result = mysql_query("SELECT username FROM useraccounts WHERE srno=$uid") or die(mysql_error());
            $row = mysql_fetch_array($result);
            return $row['username'];
            break;

        case 'name' : $result = mysql_query("SELECT fname, lname FROM extendedinfo WHERE uid=$uid") or die(mysql_error());
            $row = mysql_fetch_array($result);
            return $row['fname'] . ' ' . $row['lname'];
            break;

        case 'avatar' : $result = mysql_query("SELECT * FROM extendedinfo WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
            $row = mysql_fetch_array($result);
            if ($row['avatarpath'] == '') {
                if ($row['gender'] == 'm') {
                    return 'images/avatar_male.png';
                } else {
                    return 'images/avatar_female.png';
                }
            }
            return $row['avatarpath'];
            break;
    }
}

function createNewThread($threadtitle, $filename, $coordinates, $threaddesc, $threadcategory, $tags, $uid) {
    if ($threadtitle == "" || $threadcategory == "") {
        echo "fail";
    } else {
        if ($tags != "") {
            $array = explode(',', $tags);
        }
        dbConnect();
        $threadtitle = safeThreadContent($threadtitle);
        $filename = safeThreadContent($filename);
        $coordinates = safeThreadContent($coordinates);
        $threaddesc = safeThreadContent($threaddesc);
        $threadcategory = safeThreadContent($threadcategory);
        $tags = safeThreadContent($tags);
        $result = mysql_query("INSERT INTO thread(title, description, imagepath, coordinates, cid, uid) values('$threadtitle', '$threaddesc', '$filename', '$coordinates', $threadcategory, $uid)") or die(mysql_error());

        if ($result) {
            $result = mysql_query("SELECT thread.*, category.name FROM thread, category WHERE thread.cid = category.srno and uid=" . $_SESSION['userid'] . " ORDER BY timestamp DESC LIMIT 1") or die(mysql_error());
            $row = mysql_fetch_array($result);
            mysql_query("INSERT INTO trackthread values(" . $row['srno'] . ", " . $row['uid'] . ")") or die(mysql_error());
            if ($tags != "") {
                foreach ($array as $value) {
                    mysql_query("INSERT INTO tags values('$value')");
                    mysql_query("INSERT INTO thread_tags values('" . $value . "'," . $row['srno'] . ")") or die(mysql_error());
                }
            }
            if ($row['imagepath'] != "") {
                echo'
                    <div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                    <div class="pure-g">
                    <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . '"></div>';
            }
            else{
                echo '
                <div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                <div class="pure-g">';
            }
            echo '
                <div class="pure-u-1" style="position: relative;">
                <div class="thread-owner-thumb" style="background-image: url('.$_SESSION['avatar'].');"></div>
                <p class="bold thread-owner-link"><a href="profile.php?username=' . $_SESSION['username'] . '"  rel="external">You</a></p>
                <i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                <ul class="thread-options bg-white">
                <li><a href="javascript:;" onclick="hideThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>
                <li><a href="javascript:;" onclick="readingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>
                <li><a href="javascript:;" onclick="trackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i> Track this thread</a></li>
                <li><a href="javascript:;" onclick="deleteThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete this thread</a></li>
                </ul>
                </div>
                <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                <p class="bold margin0" style="font-size: 20pt;"><a href="thread.php?tid=' . $row['srno'] . '" rel="external">'.$row['title'].'</a></p>
                </div>
                <div class="pure-u-1 thread-description">
                <p>'.$row['description'].'</p>
                <div class="gradient"></div>
                </div>
                <div class="pure-u-1" style="padding: 5px 20px;">';
                echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $row['name'] . '</a>';
                $result1 = mysql_query("SELECT name from thread_tags WHERE tid =" . $row['srno']) or die(mysql_error());
                while ($tags = mysql_fetch_array($result1)) {
                    echo '<a href="tag.php?t='.$tags['name'].'" class="featured-tag" title="tag" rel="external" rel="external">' . $tags['name'] . '</a>';
                }
                echo '
                </div>
                <div class="pure-u-1">
                    <div class="pure-g">
                        <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-heart fa-fw"></i> 0 Upvotes</p></div>
                        <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-comments fa-fw"></i> 0 Replies</p></div>
                        <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-clock-o hidden-for-mobile"></i> <span class="t-time">Just now</span></p></div>
                    </div>
                </div>                                
                </div>
                </div>';
        } else {
            echo "fail";
        }
    }
}

function createNewThreadMobile($mobileThreadTitle, $mobileFilename, $mobileThreadDesc, $mobileThreadCategory, $mobileTags, $uid) {
    if ($mobileThreadTitle == "" || $mobileThreadCategory == "") {
        echo "fail1";
    } else {
        if ($mobileTags != "") {
            $array = explode(',', $mobileTags);
        }
        dbConnect();
        $mobileThreadTitle = safeThreadContent($mobileThreadTitle);
        $mobileFilename = safeThreadContent($mobileFilename);
        $mobileThreadDesc = safeThreadContent($mobileThreadDesc);
        $mobileThreadCategory = safeThreadContent($mobileThreadCategory);
        $mobileTags = safeThreadContent($mobileTags);
        $result = mysql_query("INSERT INTO thread(title, description, imagepath, coordinates, cid, uid) values('$mobileThreadTitle', '$mobileThreadDesc', '$mobileFilename', '50% 50%', $mobileThreadCategory, $uid)") or die(mysql_error());

        if ($result) {
            $result = mysql_query("SELECT thread.*, category.name FROM thread, category WHERE thread.cid = category.srno and uid=" . $_SESSION['userid'] . " ORDER BY timestamp DESC LIMIT 1") or die(mysql_error());
            $row = mysql_fetch_array($result);
            if ($mobileTags != "") {
                foreach ($array as $value) {
                    mysql_query("INSERT INTO tags values('$value')");
                    mysql_query("INSERT INTO thread_tags values('" . $value . "'," . $row['srno'] . ")") or die(mysql_error());
                }
            }
            if ($row['imagepath'] != "") {
                echo'
                    <div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                    <div class="pure-g">
                    <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . '"></div>';
            }
            else{
                echo '
                <div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                <div class="pure-g">';
            }
            echo '
                <div class="pure-u-1" style="position: relative;">
                <div class="thread-owner-thumb" style="background-image: url('.$_SESSION['avatar'].');"></div>
                <p class="bold thread-owner-link"><a href="profile.php?username=' . $_SESSION['username'] . '"  rel="external">You</a></p>
                <i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                <ul class="thread-options bg-white">
                <li><a href="javascript:;" onclick="hideThread();"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>
                <li><a href="javascript:;" onclick="readingList();"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>
                <li><a href="javascript:;" onclick="trackThread();"><i class="fa fa-binoculars fa-fw"></i> Track this thread</a></li>
                </ul>
                </div>
                <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                <p class="bold margin0" style="font-size: 20pt;"><a href="thread.php?tid='.$row['srno'].'" class="fg-black" rel="external">'.$row['title'].'</a></p>
                </div>
                <div class="pure-u-1 thread-description">
                <p>'.$row['description'].'</p>
                <div class="gradient"></div>
                </div>
                <div class="pure-u-1" style="padding: 5px 20px;">';
                echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $row['name'] . '</a>';
                $result1 = mysql_query("SELECT name from thread_tags WHERE tid =" . $row['srno']) or die(mysql_error());
                while ($tags = mysql_fetch_array($result1)) {
                    echo '<a href="tag.php?t='.$tags['name'].'" class="featured-tag" rel="external">' . $tags['name'] . '</a>';
                }
                echo '
                </div>
                <div class="pure-u-1">
                    <div class="pure-g">
                        <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-heart"></i> <span class="hidden-for-mobile">0 Upvote</span></div>
                        <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-comments-o"></i> <span class="hidden-for-mobile">0 Replies</span></div>
                        <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-clock-o hidden-for-mobile"></i> <span class="t-time">Just now</span></div>
                    </div>
                </div>                                
                </div>
                </div>';
        } else {
            echo "fail2";
        }
    }
}

function searchAll($param, $C) {
    dbConnect();
    if ($C == "") {
        $result = mysql_query("SELECT thread.*,COUNT(upvotes_to_thread.tid) AS upvotes FROM thread LEFT JOIN upvotes_to_thread ON thread.srno = upvotes_to_thread.tid WHERE (thread.title LIKE '%$param%') OR (thread.description LIKE '%$param%') GROUP BY thread.srno ORDER BY upvotes DESC");
        //$result = mysql_query("SELECT extendedinfo.avatarpath,thread.srno,thread.title,thread.description FROM extendedinfo,thread WHERE (thread.title LIKE '%$param%' and thread.uid = extendedinfo.uid) OR (thread.description LIKE '%$param%' and thread.uid = extendedinfo.uid)") or die(mysql_error());
    } else {
        $result = mysql_query("SELECT extendedinfo.avatarpath,thread.srno,thread.title,thread.description FROM extendedinfo,thread WHERE (thread.title LIKE '%$param%' and thread.uid = extendedinfo.uid and thread.cid = " . $C . ") OR (thread.description LIKE '%$param%' and thread.uid = extendedinfo.uid and thread.cid = " . $C . ")") or die(mysql_error());
    }
    $result1 = mysql_query("SELECT tags.name FROM tags WHERE tags.name LIKE '%$param%' ") or die(mysql_error());
    $result2 = mysql_query("SELECT useraccounts.username,extendedinfo.fname,extendedinfo.lname,extendedinfo.avatarpath FROM useraccounts,extendedinfo WHERE (extendedinfo.fname LIKE '%$param%' and extendedinfo.uid = useraccounts.srno) OR (extendedinfo.lname LIKE '%$param%' and extendedinfo.uid = useraccounts.srno) ") or die(mysql_error());
    if (mysql_num_rows($result) <= 0 && mysql_num_rows($result1) <= 0 && mysql_num_rows($result2) <= 0) {
        echo '<div class="full-span"style="padding: 20px;"><h3 class="txt-center light">We couldn\'t find anything :(</h3></div>';
        return;
    }
    echo '<div class="pure-u-17-24" style="padding-right: 10px;">
    <div class="pure-g">
    <div class="pure-u-1" style = "padding: 10px 10px 10px 0;"><p class="margin0 bold" style = "text-transform: uppercase;font-size: small;letter-spacing: 2px;">threads</p></div>
    <ul class="pure-u-1" style="height: 500px;overflow: auto;">';
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_array($result)) {
            $ex = mysql_query("SELECT avatarpath from extendedinfo where uid = " . $row['uid']);
            $exa = mysql_fetch_array($ex);
            echo '<li class="thread-search-li full-span" style="padding: 10px;border-bottom: 1px solid #eae9ed;">';
            echo '<a href = "thread.php?tid=' . $row['srno'] . '" style="display: block;" rel="external">';
            $upvotes = mysql_query("SELECT COUNT(*) AS upvotes FROM upvotes_to_thread WHERE tid=" . $row['srno']) or die(mysql_error());
            $upvotes = mysql_fetch_array($upvotes);
            $replies = mysql_query("SELECT COUNT(*) AS replies FROM reply WHERE tid=" . $row['srno']) or die(mysql_error());
            $replies = mysql_fetch_array($replies);
            echo '<div class="pure-g">
            <div class="pure-u-1-12">
            <div class="flt-left result-thumb-pic" style="width: 50px;height: 50px;margin-top: 3px;border-radius: 50%;background: url(\'' . $exa['avatarpath'] . '\') no-repeat;background-position: 50% 50%;background-size: cover;">
            </div>
            </div>
            <div class="pure-u-11-12" style="padding-left: 5px;">
            <h6 class="margin0">' . $row['title'] . '</h6>
            <div class="pure-g">
            <div class="pure-u-1-5" style="padding: 5px 0 0 0;">
            <p class="margin0 fg-gray"><i class="fa fa-heart fa-fw"></i> ' . $upvotes['upvotes'] . ' Upvotes</p>
            </div>
            <div class="pure-u-1-5" style="padding: 5px 0 0 0;">
            <p class="margin0 fg-gray"><i class="fa fa-comments fa-fw"></i> ' . $replies['replies'] . ' Replies</p>
            </div>
            </div>
            </div>
            </div>
            </a>
            </li>';
        }
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="search-right-col pure-u-7-24" style="height: 500px;overflow: auto;">';
    echo '<div class="full-span">';
    echo '<div style = "padding: 10px;"><p class="margin0 bold" style = "text-transform: uppercase;font-size: small;letter-spacing: 2px;">tags</p></div>';
    echo '<div style = "padding: 10px;">';
    if(mysql_num_rows($result1)){
        while ($row1 = mysql_fetch_array($result1)) {
            echo '<a class="featured-tag" href="tag.php?t=' . $row1['name'] . '" rel="external">' . $row1['name'] . '</a>';
        }
    }
    echo '</div>';
    echo '</div>';
    echo '<div class="full-span">';
    echo '<div style = "padding: 0 10px;"><p class="margin0 bold" style = "text-transform: uppercase;font-size: small;letter-spacing: 2px;">people</p></div>';
    echo '<div style = "padding: 0 10px;">';
    if(mysql_num_rows($result2)){
        while ($row2 = mysql_fetch_array($result2)) {
            echo '<div class="info srch-info">';
            echo '<a href="profile.php?username=' . $row2['username'] . '" rel="external">';
            echo '<div class="thumb-beeper-pic generic-pic flt-left bg-white" style = "background-image: url(' . $row2['avatarpath'] . ')"></div>';
            echo '<div class="name flt-left"><h6 class="margin0 thread-owner-link">' . $row2['fname'] . ' ' . $row2['lname'] . ' </h6>
                    <p class="margin0">' . $row2['username'] . '</p></div>';
            echo '</a>';
            echo '</div>';
        }
    }
        echo '</div>';
        echo '</div>';
        echo '</div>';
}
function searchUsers($param){
    dbConnect();
    $result = mysql_query("SELECT useraccounts.username, extendedinfo.fname, extendedinfo.lname, extendedinfo.avatarpath FROM useraccounts, extendedinfo WHERE (extendedinfo.fname LIKE '%$param%' and extendedinfo.uid = useraccounts.srno) OR (extendedinfo.lname LIKE '%$param%' and extendedinfo.uid = useraccounts.srno) ") or die(mysql_error());
    if(mysql_num_rows($result)){    
        echo '<div class="pure-u-1" style="margin-top: 10px;">';
        while ($row = mysql_fetch_array($result)) {
            echo '<div class="flt-left">';
            echo '<div class="info srch-info">';
            echo '<a href="profile.php?username=' . $row['username'] . '" rel="external">';
            echo '<div class="thumb-beeper-pic generic-pic flt-left bg-white" style = "background-image: url(' . $row['avatarpath'] . ')"></div>';
            echo '<div class="name flt-left"><p class="bold margin0 txt-left thread-owner-link">' . $row['fname'] . ' ' . $row['lname'] . ' <br />' . $row['username'] . '</p></div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
    }
    else{
        echo '<div class="full-span" style="padding: 20px;"><h3 class="txt-center light">We couldn\'t find any users :(</h3></div>';
    }
}
function searchTags($param){
    dbConnect();
    $result = mysql_query("SELECT tags.name FROM tags WHERE tags.name LIKE '%$param%' ") or die(mysql_error());
    if(mysql_num_rows($result)){    
        echo '<div class="full-span pure-u-1">';
        echo '<div style = "padding: 10px;">';
        while ($row = mysql_fetch_array($result)) {
            echo '<a class="featured-tag" rel="external" href="tag.php?t='.$row['name'].'">' . $row['name'] . '</a>'; 
        }
        echo '</div>';
        echo '</div>';
    }
    else{
        echo '<div class="full-span" style="padding: 20px"><h3 class="txt-center light">We couldn\'t find any tags:(</h3></div>';
    }
}
function searchMobile($param){
    dbConnect();
    $result = mysql_query("SELECT thread.*,COUNT(upvotes_to_thread.tid) AS upvotes FROM thread LEFT JOIN upvotes_to_thread ON thread.srno = upvotes_to_thread.tid WHERE (thread.title LIKE '%$param%') OR (thread.description LIKE '%$param%') GROUP BY thread.srno ORDER BY upvotes DESC LIMIT 5") or die(mysql_error());
    $result1 = mysql_query("SELECT useraccounts.username, extendedinfo.fname, extendedinfo.lname, extendedinfo.avatarpath FROM useraccounts, extendedinfo WHERE (extendedinfo.fname LIKE '%$param%' and extendedinfo.uid = useraccounts.srno) OR (extendedinfo.lname LIKE '%$param%' and extendedinfo.uid = useraccounts.srno) LIMIT 5") or die(mysql_error());
    $result2 = mysql_query("SELECT tags.name FROM tags WHERE tags.name LIKE '%$param%' ") or die(mysql_error());
    if(mysql_num_rows($result)<=0 && mysql_num_rows($result1)<=0 && mysql_num_rows($result2)<=0){
        echo '<div class="full-span"><h3 class="txt-center">We couldn\'t find anything :(</h3></div>';
        return;
    }
    if(mysql_num_rows($result)){    
        echo '<div class="full-span featured-tags-title">';
        echo '<p class="margin0 bold">threads</p>';
        echo '</div > ';
        echo '<ul>';
        while ($row = mysql_fetch_array($result)) {
            $ex = mysql_query("SELECT avatarpath from extendedinfo where uid = " . $row['uid']);
            $exa = mysql_fetch_array($ex);
            echo '<li>';
            echo '<a href = "thread.php?tid='.$row['srno'].'" rel="external">';
            echo '<div class="flt-left mobile-search-thumb" style = "background-image: url(' . $exa['avatarpath'] . ') "></div>';
            echo '<div class="flt-left bold" style="margin-left: 5px;width: 75%;">' . $row['title'] . '</div>';
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    if (mysql_num_rows($result1)) {
        echo '<div class="full-span featured-tags-title">';
        echo '<p class="margin0 bold">users</p>';
        echo '</div>';
        echo '<ul>';
        while ($row1 = mysql_fetch_array($result1)) {
            echo '<li>';
            echo '<a class="fg-black" href = "profile.php?username=' . $row1['username'] . '" rel="external">';
            echo '<div class="flt-left mobile-search-thumb" style = "background-image: url(' . $row1['avatarpath'] . ') "></div>';
            echo '<p class="margin0 bold">' . $row1['fname'] . ' ' . $row1['lname'] . '</p>';
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    if (mysql_num_rows($result2)) {
        echo '<div class="full-span featured-tags-title">';
        echo '<p class="margin0 bold">tags</p>';
        echo '</div>';
        echo '<div class="flt-left">';
        while ($row2 = mysql_fetch_array($result2)) {
            echo '<a href = "tag.php?t = ' . $row2['name'] . '" class="featured-tag" rel="external">' . $row2['name'] . '</a>';
        }
        echo '</div>';
    }
}
function hideThread($thread, $username){
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if($userid){
        mysql_query("INSERT INTO hidethread values($thread, $userid)") or die(mysql_error());
    }
    else{
        die('fail');
    }
}
function readingList($thread, $username){
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if($userid){
        mysql_query("INSERT INTO readinglist values($thread, $userid)") or die(mysql_error());
        echo 'onclick="rmReadingList(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}

function trackThread($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }    
    $username = safeString($username);
    $userid = namei($username);
    if ($userid) {
        mysql_query("INSERT INTO trackthread values($thread, $userid)") or die(mysql_error());
        echo 'onclick="rmTrackThread(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}

function upvote($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("INSERT INTO upvotes_to_thread(tid, uid) values(".$thread.",". $userid.")") or die(mysql_error().'k');
        echo 'onclick="rmUpvote(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}

function rmReadingList($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("DELETE FROM readinglist WHERE tid=$thread AND uid=$userid") or die(mysql_error());
        echo 'onclick="readingList(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}

function rmUpvote($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("DELETE FROM upvotes_to_thread WHERE tid=$thread AND uid=$userid") or die(mysql_error());
        echo 'onclick="upvote(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}


function rmTrackThread($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("DELETE FROM trackthread WHERE tid=$thread AND uid=$userid") or die(mysql_error());
        echo 'onclick="trackThread(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}

function unhideThread($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("DELETE FROM hidethread WHERE tid=$thread AND uid=$userid") or die(mysql_error());
        //echo 'onclick="trackThread(\'' . $thread . '\',\'' . $username . '\', this);"';
    } 
    else{
        die('fail');
    }
}

function deleteThread($thread, $username) {
    dbConnect();
    $thread = safeString($thread);
    if(!is_whole($thread)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        $result = mysql_query("SELECT imagepath FROM thread WHERE srno=$thread") or die(mysql_error());
        $row = mysql_fetch_array($result);
        if (strpos($row['imagepath'], 'userdata/' . $_SESSION['userid']) !== false) {
            unlink($row['imagepath']);
        }        
        mysql_query("DELETE FROM thread WHERE srno=$thread") or die(mysql_error());
    } 
    else{
        die('fail');
    }
}

function loadMorePosts($t) {
    dbConnect();
    
    $result = mysql_query("SELECT category.name, useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, category_user, category WHERE thread.cid = category.srno and thread.cid = category_user.cid and category_user.uid = " . $_SESSION['userid'] . " and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid and thread.timestamp < '$t' ORDER BY timestamp DESC LIMIT 10") or die(mysql_error());
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
                echo'<div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                     <div class="pure-g">
                     <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . ';"></div>';
            } else {
                echo '<div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                      <div class="pure-g">';
            }
            echo'<div class="pure-u-1" style="position: relative;">
                 <div class="thread-owner-thumb" style="background-image: url(\'' . $row['avatarpath'] . '\');"></div>';
            if ($row['uid'] == $_SESSION['userid'])
                echo '<p class="bold">You</p>';
            else
                echo '<p class="bold"><a class="fg-black" href="profile.php?username='.$row['username'].'" rel="external">' . $row['fname'] . ' ' . $row['lname'] . '</a></p>';
            echo '<i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                  <ul class="thread-options bg-white">
                  <li><a href="javascript:;" onclick="hideThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>';
            $cmd = mysql_query("SELECT * FROM readinglist WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
            if (mysql_num_rows($cmd)) {
                echo '<li class="bg-green fg-white">';
                echo '<a href="javascript:;"><i class="fa fa-fw fa-check"></i> Added To Reading List</a>';
                echo '</li>';
            } else {
                echo '<li><a href="javascript:;" onclick="readingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>';
            }
            $cmd = mysql_query("SELECT * FROM trackthread WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
            if (mysql_num_rows($cmd)) {
                echo '<li class="bg-green fg-white">';
                echo '<a href="javascript:;"><i class="fa fa-fw fa-check"></i> Tracking This Thread</a>';
                echo '</li>';
            } else {
                echo '<li><a href="javascript:;" onclick="trackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i> Track this thread</a></li>';
            }
            if ($_SESSION['userid'] == $row['uid']) {
                echo '<li><a href="javascript:;" onclick="deleteThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete this thread</a></li>';
            }
            echo'</ul>
                 </div>
                 <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                 <p class="bold margin0" style="font-size: 20pt;"><a class="fg-black"  href="thread.php?tid='.$row['srno'].'" rel="external">' . $row['title'] . '</a></p>
                 </div>
                 <div class="pure-u-1 thread-description">' . $row['description'] . '
                 <div class="gradient"></div>
                 </div>
                 <div class="pure-u-1" style="padding: 5px 20px;">';
            echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $row['name'] . '</a>';
            $tags = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $row['srno']) or die(mysql_error());
            while ($tag = mysql_fetch_array($tags)) {
                echo '<a class="featured-tag" href="tag.php?t=' . $tag['name'] . '" rel="external">' . $tag['name'] . '</a>';
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
        echo '<input type="hidden" value="' . $hdnT . '" id="hdnT" />';
    } 
    else {
        echo '0';
    }
}
function loadMorePostsTag($t,$tag) {
    dbConnect();
    
    $result = mysql_query("SELECT distinct useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno,thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp FROM useraccounts, extendedinfo, thread, thread_tags, tags WHERE thread_tags.tid = thread.srno and thread_tags.name = '".$tag."' and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid and thread.timestamp < '$t' ORDER BY timestamp DESC LIMIT 10") or die(mysql_error());
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
                echo'<div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                     <div class="pure-g">
                     <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . ';"></div>';
            } else {
                echo '<div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                      <div class="pure-g">';
            }
            echo'<div class="pure-u-1" style="position: relative;">
                 <div class="thread-owner-thumb" style="background-image: url(\'' . $row['avatarpath'] . '\');"></div>';
            if ($row['uid'] == $_SESSION['userid'])
                echo '<p class="bold thread-owner-link"><a href="profile.php?username='.$row['username'].'" rel="external">You</a></p>';
            else
                echo '<p class="bold thread-owner-link"><a href="profile.php?username='.$row['username'].'" rel="external">' . $row['fname'] . ' ' . $row['lname'] . '</a></p>';
            echo '<i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                  <ul class="thread-options bg-white">
                  <li><a href="javascript:;" onclick="hideThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>';
            $cmd = mysql_query("SELECT * FROM readinglist WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
            if (mysql_num_rows($cmd)) {
                echo '<li class="bg-green fg-white">';
                echo '<a href="javascript:;"><i class="fa fa-fw fa-check"></i> Added To Reading List</a>';
                echo '</li>';
            } else {
                echo '<li><a href="javascript:;" onclick="readingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>';
            }
            $cmd = mysql_query("SELECT * FROM trackthread WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
            if (mysql_num_rows($cmd)) {
                echo '<li class="bg-green fg-white">';
                echo '<a href="javascript:;"><i class="fa fa-fw fa-check"></i> Tracking This Thread</a>';
                echo '</li>';
            } else {
                echo '<li><a href="javascript:;" onclick="trackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i> Track this thread</a></li>';
            }
            if ($_SESSION['userid'] == $row['uid']) {
                echo '<li><a href="javascript:;" onclick="deleteThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete this thread</a></li>';
            }
            echo'</ul>
                 </div>
                 <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                 <p class="bold margin0" style="font-size: 20pt;"><a class="fg-black" href="thread.php?tid='.$row['srno'].'" rel="external">' . $row['title'] . '</a></p>
                 </div>
                 <div class="pure-u-1 thread-description">' . $row['description'] . '
                 <div class="gradient"></div>
                 </div>
                 <div class="pure-u-1" style="padding: 5px 20px;">';
            $tags = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $row['srno']) or die(mysql_error());
            while ($tag = mysql_fetch_array($tags)) {
                echo '<a class="featured-tag" href="tag.php?t=' . $tag['name'] . '" rel="external">' . $tag['name'] . '</a>';
            }
            echo '</div>';
            $upvotes = mysql_query("SELECT COUNT(*) AS upvotes FROM upvotes_to_thread WHERE tid=" . $row['srno']) or die(mysql_error());
            $upvotes = mysql_fetch_array($upvotes);
            $replies = mysql_query("SELECT COUNT(*) AS replies FROM reply WHERE tid=" . $row['srno']) or die(mysql_error());
            $replies = mysql_fetch_array($replies);
            echo '<div class="pure-u-1">
                  <div class="pure-g">
                  <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-chevron-up"></i><p class="margin0 bold">' . $upvotes['upvotes'] . ' Upvotes</p></div>
                  <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-comments-o"></i><p class="margin0 bold">' . $replies['replies'] . ' Replies</p></div>
                  <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-clock-o"></i><p class="margin0 bold">' . time_elapsed_string($row['timestamp']) . '</p></div>
                  </div>
                  </div>                                
                  </div>
                  </div>';
        }
        echo '<input type="hidden" value="' . $hdnT . '" id="hdnT" />';
    } 
    else {
        echo '0';
    }
}

function replyThread($tid, $replyDesc){
    dbConnect();
    $replyDesc = safeThreadContent($replyDesc);
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die("fail");
    }
    $result0 = mysql_query("SELECT srno, uid FROM thread WHERE thread.srno=" . $tid) or die(mysql_error());
    if(mysql_num_rows($result0)){
        $thread = mysql_fetch_array($result0);
    }
    mysql_query("INSERT into reply(description, tid, uid) values('$replyDesc', $tid, " . $_SESSION['userid'] . ")") or die(mysql_error());
    $result = mysql_query("SELECT srno, description, timestamp, correct, uid FROM reply WHERE uid = " . $_SESSION['userid'] . " ORDER BY timestamp desc LIMIT 1") or die(mysql_error());
    while($reply = mysql_fetch_array($result)){
        echo '<div class="pure-u-1 bg-white block-flat reply" style="margin-top: 20px;position: relative;">';
        echo '<div class="pure-g">';
        echo '<div class="pure-u-1 pure-u-md-1-12">';
        echo '<div class="pure-g">';
        echo '<div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center padding-hack">';
        echo '<a href="javascript:;" onclick="upvoteToReply(\'' . $reply['srno'] . '\', \'' . $_SESSION['username'] . '\', this)"><i class="fa fa-heart fa-fw fa-2x fg-grayLight"></i></a><br/><small>0</small>';
        echo '</div>';
        echo '<div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center">';
        if($_SESSION['userid'] == $thread['uid']){
            echo '<a href="javascript:;" onclick="markCorrect(\'' . $reply['srno'] . '\',\'' . $thread['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-check-circle fa-fw fa-2x fg-grayLight"></i></a><br/><small>Correct</small>';
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
        echo '<p class="bold txt-right margin0">';
        echo $_SESSION['fname'] .' '. $_SESSION['lname']. ' ';
        echo '<small class="light fg-gray">Just now</small><i class="fa fa-angle-down fa-fw options-toggle"></i></p>';
        echo '<ul class="thread-options bg-white reply-options">';
        echo '<li><a href="javascript:;" onclick="deleteReply(\'' . $reply['srno'] . '\', \'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>';
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
        echo '<input type="text" class="txt-general add-comment margin0" placeholder="add a comment" onkeydown="addComment(\'' . $reply['srno'] . '\', this, event)" />';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="pure-u-1 reply-replies" style="padding-top: 5px;">';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
    }
}

function markCorrect($rid, $tid, $username){
    dbConnect();
    $rid = safeString($rid);
    if(!is_whole($rid)){
        die('fail');        
    }
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die('fail');
    }
    $result = mysql_query("SELECT uid FROM thread WHERE srno=" . $tid) or die(mysql_error());
    if($result){
        $userid = namei($username);
        if($userid===false){
            die('fail');
        }
        $row = mysql_fetch_array($result);
        if($row['uid']==$userid){
            $result = mysql_query("UPDATE reply SET correct=1 WHERE srno=$rid") or die(mysql_error());
            die('onclick="rmMarkCorrect(\'' . $rid . '\',\'' . $tid . '\',\'' . $username . '\', this);"');          
        }
    }
    die('fail');
}
function rmMarkCorrect($rid, $tid, $username){
    dbConnect();
    $rid = safeString($rid);
    if(!is_whole($rid)){
        die('fail');
    }
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die('fail');
    }
    $result = mysql_query("SELECT uid FROM thread WHERE srno=" . $tid) or die(mysql_error());
    if($result){
        $userid = namei($username);
        if(!$userid){
            die('fail');
        }
        $row = mysql_fetch_array($result);
        if($row['uid']==$userid){
            $result = mysql_query("UPDATE reply SET correct=0 WHERE srno=$rid") or die(mysql_error());
            die('onclick="markCorrect(\'' . $rid . '\',\'' . $tid . '\',\'' . $username . '\', this);"');          
        }
    }
    die('fail');
}

function replyToReply($rid,$comment){
    dbConnect();
    $rid = safeString($rid);
    $comment = safeString($comment);
    
    mysql_query("INSERT into replies_to_reply(description,rid,uid) values('$comment',$rid," . $_SESSION['userid'] . ")") or die(mysql_error());
    $result = mysql_query("SELECT description, timestamp FROM replies_to_reply WHERE uid = ".$_SESSION['userid']." ORDER BY timestamp desc LIMIT 1") or die(mysql_error());
    while($replies = mysql_fetch_array($result)){
        echo '<div class="pure-g">';
        echo '<div class="offset-md-1-12"></div>';
        echo '<div class="pure-u-1 pure-u-md-11-12">';
        echo '<p class="comment txt-justify margin0"><small>' . $replies['description'] . ' –<span class="bold">'.$_SESSION['fname'] .' '. $_SESSION['lname']. '</span> <span class="fg-gray">Just now</span></small></p>';
        echo '</div>';
        echo '</div>';
    }
}
function deleteReply($rid, $username){
    dbConnect();
    $rid = safeString($rid);
    if(!is_whole($rid)){
        die('fail');
    }
    $userid = namei($username);
    if($userid){
        $result = mysql_query("DELETE FROM reply WHERE srno=" . $rid) or die(mysql_error());
        die('success');
    }
    die('fail');
}
function upvoteToReply($rid, $username) {
    dbConnect();
    $rid = safeString($rid);
    if(!is_whole($rid)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("INSERT INTO upvotes_to_replies(rid, uid) values($rid, $userid)") or die(mysql_error());
        $result = mysql_query("SELECT COUNT(*) as count FROM upvotes_to_replies WHERE rid=".$rid) or die(mysql_error());
        $row=  mysql_fetch_array($result);
        die('onclick="rmUpvoteToReply(\'' . $rid . '\',\'' . $username . '\', this);"*'.$row['count']);
    } 
    else{
        die('fail');
    }
}

function rmUpvoteToReply($rid, $username) {
    dbConnect();
    $rid = safeString($rid);
    if(!is_whole($rid)){
        die('fail');
    }
    $userid = namei($username);
    if ($userid) {
        mysql_query("DELETE FROM upvotes_to_replies WHERE rid=$rid AND uid=$userid") or die(mysql_error());
        $result = mysql_query("SELECT COUNT(*) as count FROM upvotes_to_replies WHERE rid=".$rid) or die(mysql_error());
        $row = mysql_fetch_array($result);
        die('onclick="upvoteToReply(\'' . $rid . '\',\'' . $username . '\', this);"*'.$row['count']);
    } 
    else{
        die('fail');
    }
}
function updateCategories($DATA){
    dbConnect();
    $categories = $DATA;
    mysql_query("DELETE from category_user where uid = " . $_SESSION['userid']) or die(mysql_error());
    $array = explode(',', $categories);
    foreach ($array as $value) {
        mysql_query("INSERT INTO category_user values($value," . $_SESSION['userid'] . ")") or die(mysql_error());
    }
}
function waitForNotification() {
    dbConnect();
    header("Content-type: text/javascript");
    $key = "This is Matrix";
    $result = mysql_query("SELECT * FROM notifications WHERE uid =" . $_SESSION['userid'] . " AND sent=0") or die(mysql_error());
    $cnt = mysql_num_rows($result);
    $json = array();
    while ($row = mysql_fetch_array($result)) {
        if($row['type']=="1"){
            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,reply.tid,reply.srno,thread.title FROM thread, reply, extendedinfo where reply.srno = " . $row['ref']." and reply.tid = thread.srno and reply.uid = extendedinfo.uid") or die(mysql_error());
            $tresult = mysql_fetch_array($tar);
            $response = array(
                'text' => $tresult['fname'].' '.$tresult['lname'].' left a reply on a thread ' . substr($tresult['title'],0,20),
                'uid' => $row['uid'],
                'cnt' => $cnt,
                'avatar' => $tresult['avatarpath'],
                'link' => 'thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] .'#r' . $tresult['srno']
            );
            array_push($json, $response);
        }
        if($row['type']=="2"){
            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,reply.description,reply.tid,replies_to_reply.srno from thread,reply,replies_to_reply,extendedinfo where replies_to_reply.srno=" . $row['ref'] . " and replies_to_reply.rid = reply.srno and reply.tid = thread.srno and replies_to_reply.uid = extendedinfo.uid") or die(mysql_error());
            $tresult = mysql_fetch_array($tar);
            $response = array(
                'text' => $tresult['fname'].' '.$tresult['lname'].' left a comment on your reply ' . substr(strip_tags($tresult['description']),0,20),
                'uid' => $row['uid'],
                'cnt' => $cnt,
                'avatar' => $tresult['avatarpath'],
                'link' => 'thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] .'#rr' . $tresult['srno']
            );
            array_push($json, $response);
        }
        if($row['type']=="3"){
            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,thread.srno,thread.title from thread,extendedinfo,upvotes_to_thread where upvotes_to_thread.srno=" . $row['ref'] . " and thread.srno = upvotes_to_thread.tid and upvotes_to_thread.uid = extendedinfo.uid") or die(mysql_error());
            $tresult = mysql_fetch_array($tar);
            $response = array(
                'text' => $tresult['fname'].' '.$tresult['lname'].' upvoted ' . substr($tresult['title'],0,20),
                'uid' => $row['uid'],
                'cnt' => $cnt,
                'avatar' => $tresult['avatarpath'],
                'link' => 'thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['srno'],
            );
            array_push($json, $response);
        }
        if($row['type']=="4"){
            $tar = mysql_query("SELECT extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, reply.description, reply.tid, reply.srno FROM thread, reply, extendedinfo, upvotes_to_replies where upvotes_to_replies.srno = " . $row['ref']." and reply.tid = thread.srno and upvotes_to_replies.rid=reply.srno and upvotes_to_replies.uid = extendedinfo.uid") or die(mysql_error());
            $tresult = mysql_fetch_array($tar);
            $response = array(
                'text' => $tresult['fname'].' '.$tresult['lname'].' upvoted ' . substr(strip_tags($tresult['description']),0,20),
                'uid' => $row['uid'],
                'cnt' => $cnt,
                'avatar' => $tresult['avatarpath'],
                'link' => 'thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] . '#r'.$tresult['srno'],
            );
            array_push($json, $response);
        }
        if($row['type']=="5"){
            $tar = mysql_query("SELECT extendedinfo.avatarpath,extendedinfo.fname,extendedinfo.lname,reply.description,reply.tid,reply.srno FROM thread, reply, extendedinfo where reply.srno = " . $row['ref']." and reply.tid = thread.srno and thread.uid = extendedinfo.uid") or die(mysql_error());
            $tresult = mysql_fetch_array($tar);
            $response = array(
                'text' => $tresult['fname'].' '.$tresult['lname'].' marked your reply as correct.',
                'uid' => $row['uid'],
                'cnt' => $cnt,
                'avatar' => $tresult['avatarpath'],
                'link' => 'thread.php?noref=' . $row['ref'] . '&tid=' . $tresult['tid'] .'#r' . $tresult['srno']
            );
            array_push($json, $response);
        }        
    }
    echo json_encode($json);
}
function resetNotification() {
    dbConnect();
    mysql_query("UPDATE notifications SET sent=1 WHERE uid = " . $_SESSION['userid']) or die(mysql_error());
}
function readAll() {
    dbConnect();
    mysql_query("UPDATE notifications SET readflag=1 WHERE uid = " . $_SESSION['userid']) or die(mysql_error());
    echo $_SESSION['userid'];
}
function loadReadingList($tid) {
    dbConnect();
    $result = mysql_query("SELECT category.name, useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, readinglist, category WHERE thread.cid = category.srno and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid and readinglist.tid = ".$tid." and readinglist.tid = thread.srno and readinglist.uid=" . $_SESSION['userid'] . "") or die(mysql_error());
    $thread = mysql_fetch_array($result);
    echo '<div class="pure-g">
    <div class="pure-u-1">
    <div class="pure-g">';
    if($thread['imagepath']!=""){
    echo '<div class="pure-u-1 bg-white block-flat" style="border: 0;">
    <div class="pure-g">
    <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $thread['imagepath'] . '\');background-position: ' . $thread['coordinates'] . '"></div>';
    }
    else{
    echo '<div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
    <div class="pure-g">';
    }
    echo '<div class="pure-u-1" style="position: relative;">
    <div class="thread-owner-thumb" style="background-image: url(\''.$thread['avatarpath'].'\');"></div>
    <p class="bold">'.$thread['fname'] . ' ' . $thread['lname'].'</p>
    </div>
    <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
    <h4 class="bold margin0"><a class="fg-black" href="thread.php?tid='.$thread['srno'].'"rel="external">'.$thread['title'].'</a></h4>
    </div>
    <div class="pure-u-1 thread-description">
    '.$thread['description'].'
    </div>
    <div class="pure-u-1" style="padding: 5px 20px;">';
    echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $thread['name'] . '</a>';
    $result = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $thread['srno']) or die(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        echo '<a class="featured-tag tagfx" href="tag.php?t=' . $row['name'] . '" rel="external">' . $row['name'] . '</a>';
    };
    echo '</div>';
    $upvote=  mysql_query("SELECT * FROM upvotes_to_thread WHERE tid=" . $thread['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());                                    
    $readinglist=  mysql_query("SELECT * FROM readinglist WHERE tid=" . $thread['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());                                    
    $track=  mysql_query("SELECT * FROM trackthread WHERE tid=" . $thread['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());
    echo '<div class="pure-u-1 desktop-actions" style="padding-top: 5px;">
    <div class="pure-g">
        <div class="pure-u-1-3 txt-center thread-action">';

            if(!mysql_num_rows($upvote)){
                echo '<p class="margin0 bold"><a class="block" href="javascript:;"><i class="fa fa-heart-o fa-fw"></i><span class="hidden-for-mobile"> Upvote this thread</span></a></p>';
            }
            else{
                echo '<p class="margin0 bold"><a class="block" href="javascript:;"><i class="fa fa-heart fa-fw fg-red"></i><span class="hidden-for-mobile"> You upvoted</span></a></p>';
            }
        echo '</div>
        <div class="pure-u-1-3 txt-center thread-action">';

            if(!mysql_num_rows($readinglist)){
                echo '<p class="margin0 bold"><a class="block" href="javascript:;"><i class="fa fa-book fa-fw"></i><span class="hidden-for-mobile"> Add to reading list</span></a></p>';
            }
            else{
                echo '<p class="margin0 bold"><a class="block" href="javascript:;"><i class="fa fa-check fa-fw fg-green"></i><span class="hidden-for-mobile"> Added to reading list</span></a></p>';
            }
        echo '</div>
        <div class="pure-u-1-3 txt-center thread-action">';
            if(!mysql_num_rows($track)){
                echo '<p class="margin0 bold"><a class="block" href="javascript:;"><i class="fa fa-binoculars fa-fw"></i><span class="hidden-for-mobile"> Track this thread</span></a></p>';
            }
            else{
                echo '<p class="margin0 bold"><a class="block" href="javascript:;"><i class="fa fa-check fa-fw fg-green"></i><span class="hidden-for-mobile"> Tracking this thread</span></a></p>';
            }
        echo '</div>                                            
    </div>
    </div>
    </div>
    </div>
    </div>';
                        
    $result1 = mysql_query("SELECT extendedinfo.fname, extendedinfo.lname, reply.srno, reply.description, reply.timestamp, reply.correct, reply.uid FROM reply, extendedinfo WHERE reply.tid = " . $thread['srno']." AND reply.uid = extendedinfo.uid ORDER BY correct desc") or die(mysql_error());
    if(mysql_num_rows($result1)){
        while($reply = mysql_fetch_array($result1)){    
        echo '<div class="pure-u-1 bg-white block-flat reply" id="r' . $reply['srno'] . '" style="margin-top: 20px;position: relative;">';
        echo '<div class="pure-g">';
        echo '<div class="pure-u-1 pure-u-md-1-12">';
        echo '<div class="pure-g">';
        echo '<div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center padding-hack">';
        $result2 = mysql_query("SELECT * FROM upvotes_to_replies WHERE rid = " . $reply['srno']) or die(mysql_error());
        $upvoteToReply = mysql_query("SELECT * FROM upvotes_to_replies WHERE rid=" . $reply['srno'] . " AND uid=" . $_SESSION['userid']) or die(mysql_error());
        if(mysql_num_rows($upvoteToReply)){
            echo '<a href="javascript:;"><i class="fa fa-heart fa-fw fa-2x fg-red"></i></a><br/><small>' . mysql_num_rows($result2) .'</small>';
        }
        else{
            echo '<a href="javascript:;"><i class="fa fa-heart fa-fw fa-2x fg-grayLight"></i></a><br/><small>' . mysql_num_rows($result2) .'</small>';
        }
        echo '</div>';
        echo '<div class="pure-u-1-2 pure-u-md-1-12 pure-u-md-1 txt-center">';
        if($reply['correct']==1){
            echo '<a href="javascript:;"><i class="fa fa-check-circle fa-fw fa-2x fg-green pointer"></i><br/></a><small>Correct</small>';
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
        echo '<p class="bold txt-right margin0">';
        echo $reply['fname'] .' '. $reply['lname']. '  <small class="light fg-gray">' . time_elapsed_string($reply['timestamp']) . '</small></p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $result3 = mysql_query("SELECT extendedinfo.fname, extendedinfo.lname, replies_to_reply.description, replies_to_reply.timestamp FROM extendedinfo,replies_to_reply WHERE replies_to_reply.rid=".$reply['srno']." and replies_to_reply.uid = extendedinfo.uid ORDER BY timestamp desc") or die(mysql_error());
        echo '<div class="pure-u-1 reply-replies" style="padding-top: 5px;">';
        if(mysql_num_rows($result3)){
            while($replies = mysql_fetch_array($result3)){
            echo '<div class="pure-g">';
            echo '<div class="offset-md-1-12"></div>';
            echo '<div class="pure-u-1 pure-u-md-11-12">';
            echo '<p class="comment txt-justify margin0"><small>' . $replies['description'] . ' –<span class="bold">'.$replies['fname'] .' '. $replies['lname']. '</span> <span class="fg-gray">' . time_elapsed_string($replies['timestamp']) . '</span></small></p>';
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
}
function rmReplyToReply($rrid, $username){
    dbConnect();
    $rrid = safeString($rrid);
    if(!is_whole($rrid)){
        die('fail');
    }
    $userid = namei($username);
    if($userid){
        $result = mysql_query("DELETE FROM replies_to_reply WHERE srno=" . $rrid) or die(mysql_error());
        die('success');
    }
    die('fail');
}
function loadMorePostsMyThreads($t){
    dbConnect();
    $result = mysql_query("SELECT category.name, useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, category WHERE thread.cid = category.srno and thread.uid = " . $_SESSION['userid'] . " and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid and thread.timestamp < '$t' ORDER BY timestamp DESC LIMIT 10") or die(mysql_error());
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
                echo'<div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                     <div class="pure-g">
                     <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . ';"></div>';
            } else {
                echo '<div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                      <div class="pure-g">';
            }
            echo'<div class="pure-u-1" style="position: relative;">
                 <div class="thread-owner-thumb" style="background-image: url(\'' . $row['avatarpath'] . '\');"></div>';
            if ($row['uid'] == $_SESSION['userid'])
                echo '<p class="bold thread-owner-link"><a href="profile.php?username=' . $row['username']  . '" rel="external">You</a></p>';
            else
                echo '<p class="bold" thread-owner-link"><a href="profile.php?username=' . $row['username']  . '" rel="external">' . $row['fname'] . ' ' . $row['lname'] . '<a/></p>';
            echo '<i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                  <ul class="thread-options bg-white">
                  <li><a href="javascript:;" onclick="hideThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>';
            $cmd = mysql_query("SELECT * FROM readinglist WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
            if (mysql_num_rows($cmd)) {
                echo '<li class="bg-green fg-white">';
                echo '<a href="javascript:;"><i class="fa fa-fw fa-check"></i> Added To Reading List</a>';
                echo '</li>';
            } else {
                echo '<li><a href="javascript:;" onclick="readingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>';
            }
            $cmd = mysql_query("SELECT * FROM trackthread WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
            if (mysql_num_rows($cmd)) {
                echo '<li class="bg-green fg-white">';
                echo '<a href="javascript:;"><i class="fa fa-fw fa-check"></i> Tracking This Thread</a>';
                echo '</li>';
            } else {
                echo '<li><a href="javascript:;" onclick="trackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i> Track This Thread</a></li>';
            }
            if ($_SESSION['userid'] == $row['uid']) {
                echo '<li><a href="javascript:;" onclick="deleteThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete This Thread</a></li>';
            }
            echo'</ul>
                 </div>
                 <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                 <p class="bold margin0" style="font-size: 20pt;"><a href="thread.php?tid='.$row['srno'].'" class="fg-black" rel="external">' . $row['title'] . '</a> </p>
                 </div>
                 <div class="pure-u-1 thread-description">' . $row['description'] . '
                 <div class="gradient"></div>
                 </div>
                 <div class="pure-u-1" style="padding: 5px 20px;">';
            echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $row['name'] . '</a>';
            $tags = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $row['srno']) or die(mysql_error());
            while ($tag = mysql_fetch_array($tags)) {
                echo '<a class="featured-tag" href="tag.php?t=' . $tag['name'] . '" rel="external">' . $tag['name']  . '</a>';
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
        echo '<input type="hidden" value="' . $hdnT . '" id="hdnT" />';
    } 
    else {
        echo '0';
    }
}
function loadEditThread($tid,$username) {
    dbConnect();
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die('fail');
    }
    $userid = namei($username);
    if($userid){
        $result = mysql_query("SELECT * FROM thread WHERE srno=" . $tid) or die(mysql_error());
        $row = mysql_fetch_array($result);
        echo $row['title'] .'$$'.$row['description'].'$$'.'editThread(\''.$row['srno'].'\',\''.$_SESSION['username'].'\');';
    }
    else{
        die('fail');
    }
}
function editThread($tid, $username,$threadTitle, $threadDesc, $coordinates) {
    dbConnect();
    $tid = safeString($tid);
    $threadTitle = safeThreadContent($threadTitle);
    $threadDesc = safeThreadContent($threadDesc);
    $coordinates = safeThreadContent($coordinates);
    if(!is_whole($tid)){
        die('fail');
    }
    $userid = namei($username);
    if($userid){
        mysql_query("UPDATE thread set title='$threadTitle', description='$threadDesc',coordinates='$coordinates',edit=1 WHERE srno=$tid") or die(mysql_error());
        $result = mysql_query("SELECT title, description, coordinates FROM thread WHERE srno=" . $tid) or die(mysql_error());
        $row = mysql_fetch_array($result);
        die(''.$row['title'].'**'.$row['description'].'**'.$row['coordinates']);
    }
    else{
        die('fail');
    }
}

function toggleEditHistory($tid){
    dbConnect();
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die('fail');
    }
    require 'class.Diff.php';
    echo '<div class="theatre editHistoryTheatre">';
    echo '<i class="fa fa-times-circle cancelEditHistoryTheatre fa-2x fg-white pointer" style="right:0;position:absolute;padding:10px;"></i>';
    echo '<div class="pure-g editHistoryChild">';
    echo '<div class="pure-u-1 eParentWrap">';
    $result = mysql_query("SELECT useraccounts.username,extendedinfo.fname,extendedinfo.lname,extendedinfo.avatarpath,threadhistory.* FROM useraccounts, extendedinfo, threadhistory WHERE tid=$tid and threadhistory.uid = extendedinfo.uid and extendedinfo.uid = useraccounts.srno ORDER BY timestamp DESC") or die(mysql_error());
    while($row = mysql_fetch_array($result)){
        $tm = $row['timestamp'];
        $th = mysql_query("select title,description from thread where srno = $tid");
        $rth = mysql_fetch_array($th);
        $diff = Diff::toHTML(Diff::compare($row['title'], $rth['title']));
        $diffDesc = Diff::toHTML(Diff::compare($row['description'], $rth['description']));
        echo '<div class="pure-u-md-3-4 pure-u-1 eThreadWrap">';
        echo '<div class="block-flat bg-white thread" style="margin-bottom:20px;">';
        if(!$row['imagepath']==""){
            echo '<div class="featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . '"></div>';
        }
        echo '<div class="pure-u-1" style="position: relative;">';
        echo '<div class="thread-owner-thumb" style="background-image: url('.$row['avatarpath'].');"></div>';
        echo '<p class="bold"><a class="fg-darker" rel="external" href="profile.php?username=' . $row['username'] . '">' . $row['fname'] . ' ' . $row['lname'] . '</a></p>';
        echo '</div>';
        echo '<div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">';
        echo '<h4 class="bold margin0">'.$diff.'</h4>';
        echo '</div>';
        echo '<div class="thread-description" id="edit-thread-editable">'.$diffDesc.'</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="pure-u-md-1-4 eTime">';        
        echo '<div class="eTimeBlock" style="padding: 0px 20px 20px 20px;"><i class="fa fa-fw fa-3x fa-clock-o fg-white txt-left" style="vertical-align: bottom;font-size: 20pt;"></i> <h5 class="fg-white bold" style="display: inline-block;font-size:16pt;margin-left:-5px;">Edited on</h5><h5 class="fg-white bold" style="font-size:13pt;margin: 5px 0;">'.date('d-M-Y h:m:s a',strtotime($tm)).'</h5></div>';
        echo '</div>';
    }   
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function getUpvoteList($tid) {
    dbConnect();
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die('fail');
    }
    $result = mysql_query("SELECT useraccounts.username, extendedinfo.fname, extendedinfo.avatarpath, extendedinfo.lname from useraccounts, extendedinfo, upvotes_to_thread WHERE upvotes_to_thread.tid = $tid and extendedinfo.uid = upvotes_to_thread.uid and useraccounts.srno = extendedinfo.uid") or die(mysql_error());
    echo '<div class="theatre" style="background: rgba(0,0,0,0.5);">';
    echo '<div class="pure-g">';
    echo '<div class="stat-defocus pure-u-md-3-8 pure-u-1">';
    echo '<div class="bg-globalColor defocus-head" style="padding: 10px;">';
    echo '<h6 class="fg-white bold">UPVOTES <i class="fa fa-fw fa-times btn-close-defocus fg-white flt-right"></i></h6>';
    echo '</div>';
    echo '<div class="pure-u-1" style="margin-top: 45px;">'; 
    echo '<div class="upvotes-list">';
    echo '<ul>';
    if(mysql_num_rows($result)){
        while($row = mysql_fetch_array($result)) {
        echo '<li>';
        echo '<a href="profile.php?username=' . $row['username'] . '" rel="external">';
        echo '<div class="pure-u-1-8"><div class="thumb-pic generic-pic" style="height:45px;width:45px;background-image: url(\'' . $row['avatarpath'] . '\')"></div></div>';
        echo '<div class="pure-u-7-8"><p class="bold margin0 fg-grayDark">';
        if($row['username']==$_SESSION['username']){
            echo 'You';
        }
        else{
            echo $row['fname'] .' '. $row['lname'];
        }
        echo '</p></div>';
        echo '</a>';
        echo '</li>';                                                              
        }
    }
    else {
        die('<li><a><p class="bold fg-grayDark margin0" style="padding: 5px;">0 Upvotes</p></a></li>');
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
function getViewList($tid) {
    dbConnect();
    $tid = safeString($tid);
    if(!is_whole($tid)){
        die('fail');
    }
    $result = mysql_query("SELECT useraccounts.username, extendedinfo.fname, extendedinfo.avatarpath, extendedinfo.lname from useraccounts, extendedinfo, views WHERE views.tid = $tid and extendedinfo.uid = views.uid and useraccounts.srno = extendedinfo.uid") or die(mysql_error());
    echo '<div class="theatre" style="background: rgba(0,0,0,0.5);">';
    echo '<div class="pure-g">';
    echo '<div class="stat-defocus pure-u-md-3-8 pure-u-1">';
    echo '<div class="bg-globalColor defocus-head" style="padding: 10px;">';
    echo '<h6 class="fg-white bold">VIEWS <i class="fa fa-fw fa-times btn-close-defocus fg-white flt-right"></i></h6>';
    echo '</div>';
    echo '<div class="pure-u-1" style="margin-top: 45px;">'; 
    echo '<div class="upvotes-list">';
    echo '<ul>';
    if(mysql_num_rows($result)){
        while($row = mysql_fetch_array($result)) {
        echo '<li>';
        echo '<a href="profile.php?username=' . $row['username'] . '" rel="external">';
        echo '<div class="pure-u-1-8"><div class="thumb-pic generic-pic" style="height:45px;width:45px;background-image: url(\'' . $row['avatarpath'] . '\')"></div></div>';
        echo '<div class="pure-u-7-8"><p class="bold margin0 fg-grayDark">';
        if($row['username']==$_SESSION['username']){
            echo 'You';
        }
        else{
            echo $row['fname'] .' '. $row['lname'];
        }
        echo '</p></div>';
        echo '</a>';
        echo '</li>';                                                              
        }
    }
    else {
        die('<li><a><p class="bold fg-grayDark margin0" style="padding: 5px;">0 Views</p></a></li>');
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function loadMoreTimeline($t,$userid) {
    dbConnect();
    $userid = safeString($userid);
    $activity = mysql_query("SELECT * FROM activitylog WHERE uid = $userid and timestamp < '$t' ORDER BY timestamp DESC LIMIT 15") or die(mysql_error());
    if(mysql_num_rows($activity)){
        while($act = mysql_fetch_array($activity)){
            $hdnT = $act['timestamp'];
            if($act['type']=="0"){ //upvotetothread
                $tar = mysql_query("SELECT * FROM thread ,upvotes_to_thread where thread.srno = " . $act['ref']." and thread.srno = upvotes_to_thread.tid") or die(mysql_error());
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
                echo '<a href="thread.php?tid=' . $tresult['tid'] . '#rr' . $tresult['srno'] . '" rel="external">';
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
                echo '<a href="thread.php?tid=' . $tresult['srno'] . '" rel="external">';
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
                $tar = mysql_query("SELECT reply.tid,reply.srno FROM thread, reply where reply.srno = " . $act['ref']." and reply.tid = thread.srno") or die(mysql_error());
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
        echo '****'.$hdnT;
    }
    else{
        echo '0';
    }
}
function updateInfoSetOne($fname, $lname, $gender, $about){
    dbConnect();
    $fname = safeString($fname);
    $lname = safeString($lname);
    $gender = safeString($gender);
    $about = safeString($about);
    
    if (!preg_match("/^[A-Za-z]+$/", $fname)) {
        die('Please check first name.');
    }    
    if (!preg_match("/^[A-Za-z]+$/", $lname)) {
        die('Please check last name.');
    }    
//    if ($gender !="m" || gender!="f") {
//        die('Please check gender.');
//    }    
    if (!preg_match("/^[A-Za-z0-9 !.,&()?]+$/", $about)) {
        die('Please check about.');
    }
    mysql_query("UPDATE extendedinfo SET fname='" . $fname . "', lname='" . $lname . "', gender='" . $gender . "', about='" . $about . "' WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
    $_SESSION['fname']=$fname;
    $_SESSION['lname']=$lname;
    die('true');
}

function updateInfoSetTwo($hometown, $city, $profession, $education, $college, $school){
    dbConnect();
    $hometown = safeString($hometown);
    $city = safeString($city);
    $profession = safeString($profession);
    $education = safeString($education);
    $college = safeString($college);
    $school = safeString($school);

    if (!preg_match("/^[A-Za-z ]+$/", $hometown)) {
        die('Please check Hometown.');
    }    
    if (!preg_match("/^[A-Za-z ]+$/", $city)) {
        die('Please check Current City.');
    }    
    if (!preg_match("/^[A-Za-z .,\']+$/", $profession)) {
        die('Please check Profession.');
    }    
    if (!preg_match("/^[A-Za-z .,\']+$/", $education)) {
        die('Please check Education.');
    }    
    if (!preg_match("/^[A-Za-z ,.\']+$/", $college)) {
        die('Please check College.');
    }    
    if (!preg_match("/^[A-Za-z ,.\']+$/", $school)) {
        die('Please check School.');
    }    
    mysql_query("UPDATE extendedinfo SET hometown='" . $hometown . "', city='" . $city . "', profession='" . $profession . "', education='" . $education . "', college='" . $college . "', school='" . $school . "' WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
    die('true');
}
?>