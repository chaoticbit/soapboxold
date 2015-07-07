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
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/categories.css" />
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
    </head>
    <body>
        <?php include 'sidebar.php'; ?>
        <div class="container">
            <?php include 'headbar.php'; ?>
            <div class="thread-container ">
                <div class="pure-g">
                    <div class="block-flat categoryTitle full-span" style="background: #f7f7f7 !important;border-top: 1px solid #eee;opacity: 0.9;z-index: 99;position: fixed;margin: 0px 0 0 0;padding: 10px;">
                        <div style="position: relative;" class="pure-u-1 pure-u-1">
                            <div style="position: relative;" class="pure-u-1 pure-u-md-3-5">
                                <h5 class="light flt-left">Click update to save your preferences.</h5>
                            </div>
                            <div style="position: relative;" class="pure-u-1 pure-u-md-1-5">
                                <button class="btn-general bg-globalColor fg-white update-category flt-right">UPDATE</button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 50px;" class="pure-u-1 categoryChild">
                    <?php
                    $result = mysql_query("SELECT * FROM category") or die(mysql_error());
                    while($row=mysql_fetch_array($result)){
                        echo '<div class="pure-u-1 pure-u-md-1-4 category pointer" data-id="'.$row['srno'].'" style="position: relative;background: url(\'' . $row['imagepath'] . '\') no-repeat;background-position: 50% 50%;background-size: cover;height: 204px;">';
                        echo '<div class="defocus-panel">';
                        $choices = mysql_query("SELECT * FROM category_user WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
                        while($choice=  mysql_fetch_array($choices)){
                            if($choice['cid']==$row['srno']){
                                echo '<div class="selected"><i class="fa fa-check-circle center-icon fa-4x" style="color:#80FF00;"></i></div>';
                                //echo '<i class="fa fa-check-circle fg-white fa-3x selected" style="position: absolute;top: 10px;right: 10px;text-shadow: 0 0 5px rgba(0,0,0,0.99);"></i>';
                                $arr .= $choice['cid'].",";
                            }
                        }
                        echo '</div>';
                        echo '<div class="hover-gradient">';
                        echo '<h5 class="bold fg-white margin0" style="position: absolute;bottom: 40px;left: 10px;">' . $row['name'] . '</h5>';
                        $count = mysql_query("SELECT COUNT(*) as count FROM category_user WHERE cid=" . $row['srno']) or die(mysql_error());
                        $count = mysql_fetch_array($count);                        
                        echo '<p class="bold fg-white" style="position: absolute;bottom: 5px;left: 10px;">' . $count['count'] . ' people active</p>';
                        echo '</div>';
                        echo '</div>'; 
                    }
                        echo '<input type="hidden" value="'.rtrim($arr,',').'" name="categories" />';
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="editor-help-parent">
            <div class="editor-help-child">
                <div class="pure-g">
                    <div class="pure-u-1 bg-green" style="padding: 10px;">
                        <h6 class="fg-white bold">SOAPBOX</h6>
                    </div>
                    <div class="pure-u-1 bg-white" style="padding: 10px;">
                        <h5 class="txt-center light margin0">Your preferred categories have been updated.</h5>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script>
            $('.fa-th-large').closest('li').addClass('active');
        </script>
        <script src="js/main.js"></script>
        <script src="js/categories.js"></script>
    </body>
</html>