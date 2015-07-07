<?php
session_start();
if (!isset($_SESSION['userid'])) {
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
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />    
        <link rel="stylesheet" href="css/readinglist.css" />
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
    </head>
    <body>
        <?php include 'sidebar.php'; ?>
        <div class="container">
            <?php include 'headbar.php'; ?>
            <div class="readinglist-container">
                <div class="readingparent flt-left hidden-for-mobile" style="width:66%;margin-bottom: 20px;">
                   <?php
                    $result = mysql_query("SELECT useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, readinglist WHERE extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid and readinglist.tid = thread.srno and readinglist.uid=" . $_SESSION['userid'] . " ORDER BY timestamp DESC LIMIT 1") or die(mysql_error());
                    if(!mysql_num_rows($result))
                    {
                        echo '<div class="pure-g">';
                        echo '<div class="pure-u-1">';
                        echo '<h4>There are no threads in your reading list.</h4>';
                        echo '</div>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="pure-g">';
                        echo '<div class="pure-u-1">';
                        echo '<h3 class="txt-center light" style="font-size: 25pt;"><i class="fa fa-book fg-gray" style="font-size: 27pt;"></i> No thread selected</h3>';
                        echo '</div>';
                        echo '</div>';                        
                    }
                    $thread = mysql_fetch_array($result);
                   ?>
                    
                </div>
                <div class="right-pane flt-right">
                    <div class="pure-g">
                        <div class="pure-u-1 readhead" style="padding: 10px 10px 10px 10px;">
                            <h5 class="fg-white txt-center">READING LIST</h5>
                        </div>
                        <div class="pure-u-1 readlist">
                            <ul>
                                <?php
                                $rr = mysql_query("SELECT thread.srno, thread.title, thread.description, thread.timestamp , readinglist.* FROM thread, readinglist WHERE readinglist.uid = " . $_SESSION['userid'] . " and readinglist.tid = thread.srno ORDER BY timestamp DESC") or die(mysql_error());
                                if (mysql_num_rows($rr)) {
                                    while ($row = mysql_fetch_array($rr)) {
                                        echo '<li>';
                                        echo '<a href="javascript:;" class="toggleread" data-tid="' . $row['srno'] . '">';
                                        echo '<p class="fg-white bold margin0">' . $row['title'] . '</p>';
                                        if($row['description']!="<p><br></p>")
                                        echo '<p class="fg-white margin0">' . substr(strip_tags($row['description']), 0, 35) . '...</p>';
                                        echo '<p class="fg-grayLight margin0 tm"><i class="fa fa-clock-o"></i>  ' . $row['timestamp'] . '</p>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                    
                                }
                                ?>
                                <!--<li>
                                    <a href="javascript:;">
                                    <p class="fg-white bold margin0"></p>
                                    <p class="fg-white margin0"></p>
                                    <p class="fg-white margin0"><i class="fa fa-clock-o fg-white"></i>  </p>
                                    </a>
                                    </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mobile-reading-list">
                    <div class="pure-g">
                        <div class="pure-u-1 readhead" style="padding: 10px 10px 10px 10px;">
                            <h5 class="fg-white txt-center">READING LIST</h5>
                        </div>
                        <div class="pure-u-1 readlist">
                            <ul>
                                <?php
                                $rr = mysql_query("SELECT thread.srno, thread.title, thread.description, thread.timestamp , readinglist.* FROM thread, readinglist WHERE readinglist.uid = " . $_SESSION['userid'] . " and readinglist.tid = thread.srno ORDER BY timestamp DESC") or die(mysql_error());
                                if (mysql_num_rows($rr)) {
                                    while ($row = mysql_fetch_array($rr)) {
                                        echo '<li>';
                                        echo '<a class="fg-white" href="thread.php?tid='.$row['srno'].'" rel="external">';
                                        echo '<p class="fg-white bold margin0">' . substr($row['title'], 0, 30) . '</p>';
                                        echo '<p class="fg-white margin0">' . substr(strip_tags($row['description']), 0, 40) . '</p>';
                                        echo '<p class="fg-grayLight margin0 tm"><i class="fa fa-clock-o"></i>  ' . $row['timestamp'] . '</p>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                    
                                }
                                ?>
                                <!--<li>
                                    <a href="javascript:;">
                                    <p class="fg-white bold margin0"></p>
                                    <p class="fg-white margin0"></p>
                                    <p class="fg-white margin0"><i class="fa fa-clock-o fg-white"></i>  </p>
                                    </a>
                                    </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <script src="js/jquery-2.1.3.min.js"></script>
            <script src="js/readinglist.js"></script>
            <script src="js/main.js"></script>
    </body>
</html>