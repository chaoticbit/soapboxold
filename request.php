<?php session_start();
if (!isset($_SESSION['userid']) && $_REQUEST['KEY']!="checkUsername" && $_REQUEST['KEY']!="resetAc" && $_REQUEST['KEY']!="resetAnswer" && $_REQUEST['KEY']!="checkEmail") {
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
    die();
}

include 'ajax_requests.php';

$KEY=$_REQUEST['KEY'];
if($KEY=="resetAnswer"){
    $answer = $_REQUEST['answer'];
    $username = $_REQUEST['username'];
}
if($KEY=="hideThread" || $KEY=="readingList" || $KEY=="trackThread" || $KEY=="rmReadingList" || $KEY=="rmTrackThread" || $KEY=="unhideThread" || $KEY=="deleteThread" || $KEY=="upvote" || $KEY=="rmUpvote"){
    $thread=$_REQUEST['thread'];
    $username=$_REQUEST['username'];
}
if($KEY=="loadMorePosts" || $KEY=="loadMorePostsMyThreads"){
    $t = $_REQUEST['t'];
}
if($KEY=="loadMoreTimeline"){
    $t = $_REQUEST['t'];
    $username = $_REQUEST['username'];
}
if($KEY=="loadMorePostsTag"){
    $t = $_REQUEST['t'];
    $tag = $_REQUEST['tag'];
}
if($KEY=="createNewThread"){
    $threadtitle=$_REQUEST['threadtitle'];
    $filename=$_REQUEST['filename'];
    $coordinates=$_REQUEST['coordinates'];
    $threaddesc=$_REQUEST['threaddesc'];
    $threadcategory=$_REQUEST['threadcategory'];
    $tags=$_REQUEST['tags'];
}
if($KEY == "searchAll"){
    $C = $_REQUEST['C'];
}
if($KEY == "createNewThreadMobile"){
    $mobileThreadTitle = $_REQUEST['mobileThreadTitle'];
    $mobileFilename = $_REQUEST['mobileFilename'];
    $mobileThreadDesc = $_REQUEST['mobileThreadDesc'];
    $mobileThreadCategory = $_REQUEST['mobileThreadCategory'];
    $mobileTags = $_REQUEST['mobileTags'];
}
if($KEY == "replyThread"){
    $tid = $_REQUEST['tid'];
    $replyDesc = $_REQUEST['replyDesc'];
}
if($KEY == "replyToReply"){
    $rid = $_REQUEST['rid'];
    $comment = $_REQUEST['comment'];
}
if($KEY == "markCorrect" || $KEY== "rmMarkCorrect" || $KEY=="deleteReply" || $KEY=="upvoteToReply" || $KEY=="rmUpvoteToReply"){
    $rid=$_REQUEST['rid'];
    $tid=$_REQUEST['tid'];
    $username=$_REQUEST['username'];
}
if($KEY=="loadReadingList" || $KEY=="getUpvoteList" || $KEY=="getViewList" || $KEY=="toggleEditHistory"){
    $tid = $_REQUEST['tid'];
}
if($KEY=="rmReplyToReply"){
    $rrid=$_REQUEST['rrid'];
    $username=$_REQUEST['username'];
}
if($KEY=="loadEditThread"){
    $tid = $_REQUEST['tid'];
    $username=$_REQUEST['username'];    
}
if($KEY=="editThread"){
    $tid = $_REQUEST['tid'];
    $username=$_REQUEST['username'];    
    $threadTitle = $_REQUEST['threadTitle'];
    $threadDesc = $_REQUEST['threadDesc'];
    $coordinates = $_REQUEST['coordinates'];
}
if($KEY=="updateInfoSetOne"){
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $gender = $_REQUEST['gender'];
    $about = $_REQUEST['about'];
}
if($KEY=="updateInfoSetTwo"){
    $hometown = $_REQUEST['hometown'];
    $city = $_REQUEST['city'];
    $profession = $_REQUEST['profession'];
    $education = $_REQUEST['education'];
    $college = $_REQUEST['college'];
    $school = $_REQUEST['school'];
}
$DATA=$_REQUEST['DATA'];

switch($KEY){
    case 'checkUsername'    :   checkUsername($DATA);
                                break;
    case 'checkPassword'    :   checkPassword($DATA);
                                break;
    case 'checkEmail'       :   checkEmail($DATA);
                                break;
    case 'updateEmail'      :   updateEmail($DATA);
                                break;
    case 'resetAc'          :   resetAc($DATA);
                                break;   
    case 'resetAnswer'      :   resetAnswer($answer,$username);
                                break;                            
    case 'deleteImage'      :   deleteimage($DATA);
                                break;
    case 'uploadImage'      :   $allowedExts = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
                                $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                                if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
                                    if ($_FILES["file"]["error"] > 0) {
                                        echo '0';
                                    } 
                                    else {
                                        $temp = explode(".",$_FILES["file"]["name"]);
                                        $newfilename = $temp[0] . rand(1,99999) . '_-_'. time() . '.' .end($temp);
                                        $filepath = "userdata/" . $_SESSION['userid'] . "/" . $newfilename;
                                        move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);
                                        if (file_exists($filepath)) {
                                            echo $filepath;
                                        }
                                    }
                                } else {
                                    echo '0';
                                }
                                break;
    case 'uploadImageMobile':   $allowedExts = array("jpeg", "jpg", "png");
                                $extension = pathinfo($_FILES["filemobile"]["name"], PATHINFO_EXTENSION);
                                if ((($_FILES["filemobile"]["type"] == "image/jpeg") || ($_FILES["filemobile"]["type"] == "image/jpg") || ($_FILES["filemobile"]["type"] == "image/pjpeg") || ($_FILES["filemobile"]["type"] == "image/x-png") || ($_FILES["filemobile"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
                                    if ($_FILES["filemobile"]["error"] > 0) {
                                        echo '0';
                                    } 
                                    else {
                                        $temp = explode(".",$_FILES["filemobile"]["name"]);
                                        $newfilename = $temp[0] . rand(1,99999) . '.' .end($temp);
                                        $filepath = "userdata/" . $_SESSION['userid'] . "/" . $newfilename;
                                        move_uploaded_file($_FILES["filemobile"]["tmp_name"], $filepath);
                                        if (file_exists($filepath)) {
                                            echo $filepath;
                                        }
                                    }
                                } else {
                                    echo '0';
                                }
                                break;   
    case 'createNewThread'  :   createNewThread($threadtitle, $filename, $coordinates, $threaddesc, $threadcategory, $tags, $_SESSION['userid']);
                                break;
    case 'createNewThreadMobile'  :   createNewThreadMobile($mobileThreadTitle, $mobileFilename, $mobileThreadDesc, $mobileThreadCategory, $mobileTags, $_SESSION['userid']);
                                break;                            
    case 'searchAll'        :   searchAll($DATA,$C);
                                break;
    case 'searchUsers'      :   searchUsers($DATA);
                                break;                            
    case 'searchTags'       :   searchTags($DATA);
                                break;
    case 'searchMobile'     :   searchMobile($DATA);
                                break;
    case 'upvote'           :   upvote($thread, $username);
                                break;
    case 'rmUpvote'         :   rmUpvote($thread, $username);
                                break;                            
    case 'hideThread'       :   hideThread($thread, $username);
                                break;
    case 'readingList'      :   readingList($thread, $username);
                                break;      
    case 'trackThread'      :   trackThread($thread, $username);
                                break;                            
    case 'rmReadingList'    :   rmReadingList($thread, $username);
                                break;      
    case 'rmTrackThread'    :   rmTrackThread($thread, $username);
                                break;                            
    case 'unhideThread'     :   unhideThread($thread, $username);
                                break;                                                        
    case 'deleteThread'     :   deleteThread($thread, $username);
                                break;
    case 'loadMorePosts'    :   loadMorePosts($t);
                                break;
    case 'loadMorePostsTag' :   loadMorePostsTag($t,$tag);
                                break;                            
    case 'replyThread'      :   replyThread($tid, $replyDesc);
                                break;
    case 'markCorrect'      :   markCorrect($rid, $tid, $username);
                                break;
    case 'rmMarkCorrect'    :   rmMarkCorrect($rid, $tid, $username);
                                break;                            
    case 'replyToReply'     :   replyToReply($rid,$comment);
                                break;
    case 'deleteReply'      :   deleteReply($rid, $username);
                                break;                            
    case 'upvoteToReply'    :   upvoteToReply($rid, $username);
                                break;                            
    case 'rmUpvoteToReply'  :   rmUpvoteToReply($rid, $username);
                                break;       
    case 'updateCategories' :   updateCategories($DATA);
                                break;                                                     
    case 'waitForNotification': waitForNotification();
                                break;
    case 'resetNotification':   resetNotification();
                                break;
    case 'loadReadingList'  :   loadReadingList($tid);
                                break;
    case 'rmReplyToReply'   :   rmReplyToReply($rrid, $username);
                                break;
    case 'loadMorePostsMyThreads':  loadMorePostsMyThreads($t);
                                break;             
    case 'loadEditThread'   :   loadEditThread($tid, $username);
                                break;
    case 'editThread'       :   editThread($tid, $username, $threadTitle, $threadDesc, $coordinates);
                                break;
    case 'toggleEditHistory':   toggleEditHistory($tid);
                                break;
    case 'getUpvoteList'    :   getupvoteList($tid);
                                break;
    case 'getViewList'      :   getViewList($tid);
                                break;
    case 'loadMoreTimeline' :   loadMoreTimeline($t, $username);
                                break;        
    case 'updateInfoSetOne' :   updateInfoSetOne($fname, $lname, $gender, $about);
                                break;
    case 'updateInfoSetTwo' :   updateInfoSetTwo($hometown, $city, $profession, $education, $college, $school);
                                break;
    case 'readAll'          :   readAll();
                                break;
}
?>