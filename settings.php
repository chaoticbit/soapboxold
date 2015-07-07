<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
    die();
}
include 'library.php';
dbConnect();
if($_POST || isset($_POST['submit'])){
    if(isset($_REQUEST['mode'])){
        switch($_REQUEST['mode']){
            case "pwd": echo 'hi';
                        $newpwd = safeString($_POST['newpwd']);
                        $conpwd = safeString($_POST['conpwd']);
                        if (!preg_match("/^[a-zA-Z0-9!@#$%^&*]{8,30}$/", $newpwd)) {
                            $error_pwd = 'Please try another password.';
                        }
                        if ($newpwd != $conpwd) {
                            $error_pwd = 'Please confirm your password again.';
                        }
                        if(!isset($error_pwd)){
                            $pwd=md5($newpwd);
                            mysql_query("UPDATE useraccounts set password='" . $pwd ."' WHERE srno=" . $_SESSION['userid']) or die(mysql_error());
                            $success='<span class="fg-green">Done!</span>';
                        }
                        break;
                        
            case "avt": $allowedExts = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
                        $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                        if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
                            if ($_FILES["file"]["error"] > 0) {
                                $error_avatar="Something went wrong";
                            } 
                            else {
                                $temp = explode(".",$_FILES["file"]["name"]);
                                $newfilename = $temp[0] . rand(1,99999) . '_-_'. time() . '.' .end($temp);
                                $filepath = "userdata/" . $_SESSION['userid'] . "/" . $newfilename;
                                move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);
                                if (file_exists($filepath)) {
                                    mysql_query("UPDATE extendedinfo SET avatarpath='" . $filepath . "' WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
                                    $_SESSION['avatar']=$filepath;
                                    $error_avatar="<span class=\"fg-green\">Done!</span> ";
                                }
                            }
                        } else {
                            $error_avatar="<span class=\"fg-red\">Something went wrong</span>";
                        }
                        break;
        }
    }
    
}
$extendedinfo = mysql_query("SELECT * FROM extendedinfo WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
$ei = mysql_fetch_array($extendedinfo);
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
        <link rel="stylesheet" href="css/settings.css" />
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
    </head>
    <body>
        <?php include 'sidebar.php'; ?>
        <div class="container">
            <?php include 'headbar.php'; ?>
            <div class="thread-container">
                <div class="pure-g">
                    <div class="pure-u-1 bg-white" style="padding: 20px;">
                        <h5 class="light" style="padding-bottom: 5px;border-bottom: 1px solid #eee;">Change Avatar</h5>
                        <div class="pure-g" style="margin-bottom: 20px;">
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <div class="new-avatar" style="background-image: url('<?php echo $_SESSION['avatar']; ?>')">
                                            <div class="defocus-panel">
                                                <i class="fa fa-camera fa-2x fg-white margin0 center-icon cam"></i>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2">
                                        <form method="post" action="settings.php?mode=avt" enctype="multipart/form-data">
                                            <input type="file" name="file" accept="image/*" style="display: none;" />
                                            <input type="submit" name="submit" id="avatarform" style="display: none;" />
                                        </form>
                                    </div>                                    
                                </div>
                            </div>                            
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Action</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <label><?php if(isset($error_avatar)){ echo $error_avatar;} else { echo '<a href="javascript:;" onclick="document.getElementById(\'avatarform\').click();">Update</a>';} ?></label>
                                    </div>                                    
                                </div>                                
                            </div>
                        </div>                        
                        <h5 class="light" style="padding-bottom: 5px;border-bottom: 1px solid #eee;">Change Email</h5>
                        <div class="pure-g" style="margin-bottom: 20px;">
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Email</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-email" value="<?php echo $ei['email']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>
                            </div>                            
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Action</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <label><a href="javascript:;" class="update-one">Update</a></label>
                                    </div>                                    
                                </div>                                
                            </div>
                        </div>
                        <h5 class="light" style="padding-bottom: 5px;border-bottom: 1px solid #eee;">Change Password</h5>
                        <div class="pure-g" style="margin-bottom: 20px;">
                            <div class="pure-u-1 info-subgroup">
                                <form method="post" action="settings.php?mode=pwd" autocomplete="off" id="pwd">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">New Password</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="password" name="newpwd" class="new-info txt-newpwd" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Confirm Password</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="password" name="conpwd" class="new-info txt-conpwd" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Action</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <label><?php if(isset($success)) { echo $success;} else {echo '<a href="javascript:;" onclick="document.getElementById(\'pwd\').submit();" class="update-two">Update </a>';} if(isset($error_pwd)){ echo '<small class="fg-red">(' . $error_pwd . ')</small>'; }?></label>
                                    </div>                                    
                                </div>                                
                                </form>
                            </div>
                        </div>
                        <h5 class="light" style="padding-bottom: 5px;border-bottom: 1px solid #eee;">Account Settings</h5>
                        <div class="pure-g" style="margin-bottom: 20px;">
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">First Name</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-fname" value="<?php echo $ei['fname']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>                            
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Last Name</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-lname" value="<?php echo $ei['lname']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Gender</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <div class="pure-g">
                                            <div class="pure-u-1-2">
                                                <input type="radio" name="gender" <?php if($ei['gender']=="m"){echo 'checked="true"';}?> class="margin0" style="display: inline-block;" value="m" /> Male
                                            </div>
                                            <div class="pure-u-1-2">
                                                <input type="radio" name="gender" <?php if($ei['gender']=="f"){echo 'checked="true"';}?> class="margin0" style="display: inline-block;" value="f" /> Female
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">About</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-about" value="<?php echo $ei['about']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Action</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <label><a href="javascript:;" class="update-three">Update</a></label>
                                    </div>                                    
                                </div>                                
                            </div>                            
                        </div>
                        <h5 class="light" style="padding-bottom: 5px;border-bottom: 1px solid #eee;">General Info Settings</h5>
                        <div class="pure-g">
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Hometown</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-hometown" value="<?php echo $ei['hometown']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Current City</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-city" value="<?php echo $ei['city']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div> 
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Profession</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-profession" value="<?php echo $ei['profession']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Education</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-education" value="<?php echo $ei['education']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">College</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-college" value="<?php echo $ei['college']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">School</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <input type="text" class="new-info txt-school" value="<?php echo $ei['school']; ?>" spellcheck="false" autocorrect="off" autocomplete="off" />
                                        <span class="status-symbol"><i></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="pure-u-1 info-subgroup">
                                <div class="pure-g">
                                    <div class="pure-u-1 pure-u-md-1-4">
                                        <p class="margin0 bold">Action</p>
                                    </div>
                                    <div class="pure-u-1 pure-u-md-1-2" style="position: relative;">
                                        <label><a href="javascript:;" class="update-four">Update</a></label>
                                    </div>                                    
                                </div>                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script>
            $('.fa-cog').closest('li').addClass('active');
        </script>
        <script src="js/main.js"></script>
        <script src="js/settings.js"></script>
    </body>
</html>