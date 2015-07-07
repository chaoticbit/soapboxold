<?php
session_start();
include 'library.php';
if (isset($_SESSION['userid'])) {
    dbConnect();
    $result = mysql_query("SELECT * FROM extendedinfo WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
    if (!mysql_num_rows($result)) {
        echo '<meta http-equiv="refresh" content="0; url=signup.php">';
        die();
    } else {
        if (!isset($_SESSION['fname']) && !isset($_SESSION['lname'])) {
            $row = mysql_fetch_array($result);
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['avatar'] = $row['avatarpath'];
        }
    }
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    die();
}
if (isset($_POST['login-submit-btn'])) {
    dbConnect();
    $username = safeString($_POST['uname']);
    $password = safeString($_POST['pword']);
    $password = md5($password);
    $result = mysql_query("SELECT * FROM useraccounts WHERE username='$username' AND password='$password'") or die(mysql_error());
    if (mysql_num_rows($result)) {
        $row = mysql_fetch_array($result);
        $_SESSION['userid'] = $row['srno'];
        $_SESSION['username'] = $row['username'];
        echo '<meta http-equiv="refresh" content="0; url=login.php">';
        die();
    } else {
        $error = " invalid";
    }
    mysql_close($conn);
} else if (isset($_POST['signup-submit-btn'])) {
    dbConnect();
    $nusername = safeString($_POST['nusername']);
    $npassword = safeString($_POST['npassword']);
    $cpassword = safeString($_POST['cpassword']);
    if (!preg_match("/^[a-z][a-zA-Z0-9_.]{0,14}$/", $nusername)) {
        $error_signup = 'found';
    }
    if (!preg_match("/^[a-zA-Z0-9!@#$%^&*]{8,30}$/", $npassword)) {
        $error_signup = 'found';
    }
    if ($npassword != $cpassword) {
        $error_signup = 'found';
    }
    if (!isset($error_signup)) {
        $npassword = md5($npassword);
        mysql_query("INSERT INTO useraccounts(username, password) values('$nusername','$npassword')") or die(mysql_error());
        $_SESSION['userid'] = mysql_insert_id();
        $_SESSION['username'] = $nusername;
        mkdir("userdata/" . $_SESSION['userid'], 0700, true);
        chmod("userdata/" . $_SESSION['userid'], 0777);
        echo '<meta http-equiv="refresh" content="0; url=signup.php">';
        die();
    }
} else if(isset ($_POST['updatepwd-submit-btn'])) {
    dbConnect();
    $new_password = safeString($_POST['new_password']);
    $conf_password = safeString($_POST['conf_password']);
    $username = safeString($_POST['unameconfirm']);
    $u = mysql_query("SELECT srno from useraccounts where username='$username'") or die(mysql_error());
    if(mysql_num_rows($u)){
        $rr = mysql_fetch_array($u);
        if (!preg_match("/^[a-zA-Z0-9!@#$%^&*]{8,30}$/", $new_password)) {
            $error_signup = 'found';
        }
        if (!preg_match("/^[a-zA-Z0-9!@#$%^&*]{8,30}$/", $conf_password)) {
            $error_signup = 'found';
        }
        if($new_password == $conf_password) {
            $new_password = md5($new_password);
            mysql_query("UPDATE useraccounts SET password= '$new_password' where srno = " . $rr['srno']);
        }
    }
    else{
        $error_signup = 'found';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log-in to SoapBox</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
        <link rel="stylesheet" href="css/login.css" />
    </head>
    <body class="bg-blur">
        <div class="top-nav hide-mobile">
            <ul class="navbar">
                <li><a href="javascript:;">Upcoming</a></li>
                <li><a href="javascript:;">About</a></li>
                <li><a href="javascript:;">FAQs</a></li>
                <li><a href="javascript:;">Contact</a></li>
                <li><a href="javascript:;">Developers</a></li>
            </ul>
        </div>
        <div class="title txt-center">
            <h1><span class="bold">SOAP</span><span class="light">BOX</span></h1>
        </div>
        <div class="container">
            <p class="subtitle">Question Everything</p>
            <div class="transparent-panel">
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-1-2 login-form">
                        <form name="loginform" method="post" action="login.php" autocomplete="off">
                            <input type="text" class="login-credential <?php if (isset($error)) echo $error; ?>" name="uname" placeholder="username" autofocus spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                            <input type="password" class="login-credential <?php if (isset($error)) echo $error; ?>" name="pword" placeholder="password" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                            <p class="txt-right flt-right"><a class="reset-pwd" href="javascript:;">Forgot Password?</a></p>
                            <input type="submit" class="btn-general login-submit bg-white fg-grayLight" name="login-submit-btn" value="LOGIN" />                            
                        </form>
                        <input type="text" class="login-credential hidden resetPwdUname" name="resetPwdUname" placeholder="username [press enter]" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                        <p class="light txt-center mobile-filler">Start a conversation, explore your<br />interests, and be in the know.</p>
                        <p class="light txt-center desktop-filler">Start a conversation, explore your interests,<br />and be in the know.</p>
                        <button class="btn-general login-signup bg-crimson fg-white">JOIN SOAPBOX NOW</button>
                    </div>
                    <div class="pure-u-1 pure-u-md-1-2 resetpwd-form" style="display: none;">
                        <div style="position: relative;" class="qa">
                            <div style="position: relative;">
                                <p class="margin0 bold reset-question" style="padding:5px;"></p>
                            </div>
                            <div style="position: relative;">
                                <input type="text" class="login-credential reset-answer" name="answer" maxlength="15" placeholder="ANSWER [press enter]" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                                <span class="nun status-symbol" style="display: none;"><i></i></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="uname_resetpwd" />
                    <div class="pure-u-1 pure-u-md-1-2 signup-form <?php if (isset($error_signup)) echo $error_signup; ?>" style="display: none;">
                        <div class="tips tips-username" style="display: none;">
                            <i class="fa fa-caret-right fa-2x fg-lightBlue right-caret" style="top: 8px;"></i>
                            <div class="bg-lightBlue tip" style="top: -5px;">
                                <p class="fg-white bold txt-center margin0" style="font-size: 10pt;">Cannot start with a number or any special character.</p>
                            </div>
                        </div>
                        <div class="tips tips-password" style="display: none;">
                            <i class="fa fa-caret-right fa-2x fg-lightBlue right-caret" style="top: 48px;"></i>
                            <div class="bg-lightBlue tip" style="top: 35px;">
                                <p class="fg-white bold txt-center margin0" style="font-size: 10pt;">Must contain at least 8 characters.</p>
                            </div>
                        </div>
                        <form method="post" action="login.php" autocomplete="Off" name="signupform">
                            <div style="position: relative;">
                                <input type="text" class="login-credential signup-username <?php if (isset($error_signup)) echo ' invalid'; ?>" name="nusername" maxlength="15" placeholder="NEW USERNAME" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                                <span class="nun status-symbol" style="display: none;"><i></i></span>
                            </div>
                            <div style="position: relative;">
                                <input type="password" class="login-credential signup-password <?php if (isset($error_signup)) echo ' invalid'; ?>" name="npassword" placeholder="password" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                                <span class="pwd status-symbol" style="display: none;"><i></i></span>
                            </div>
                            <div style="position: relative;">
                                <input type="password" class="login-credential signup-pwdcon <?php if (isset($error_signup)) echo ' invalid'; ?>" name="cpassword" placeholder="confirm password" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                                <span class="cpw status-symbol" style="display: none;"><i></i></span>
                            </div>
                            <div style="position: relative;">
                                <input type="submit" name="signup-submit-btn" disabled class="btn-general signup-submit bg-white fg-grayLight" value="SIGN UP" />
                                <span class="signup-help bold"><a href="javascript:;" class="show-tips">[?]</a></span>
                            </div>
                        </form>
                        <p class="txt-center margin0" style="padding-top: 5px;"><a href="javascript:;" class="go-back">Go Back</a></p>                        
                    </div>
                    <div class="pure-u-1 pure-u-md-1-2 info">
                        <p class="bold">It is so easy to use that it's hard to explain</p>
                        <p class="light txt-justify" style="margin-top: 15px;">We made it really, really simple for people to ask any question and get answers from real people with first-hand experience.</p>
                        <p class="bold">You already know how this works</p>
                        <p class="light txt-justify">Choose from the topics of your interest to create a feed of information tuned to your interests. Create a thread to share knowledge.</p>
                        <button class="btn-general login-guest bg-lightBlue fg-white">ENTER AS GUEST</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>