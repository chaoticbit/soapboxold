<?php session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    session_destroy();
}
include 'library.php';
dbConnect();
$result = mysql_query("SELECT * FROM extendedinfo WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
if(mysql_num_rows($result)){
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    die();    
}
if ($_POST) {
    dbConnect();
    $fname = safeString($_POST['fname']);
    if (!preg_match("/^[A-Za-z]+$/", $fname)) {
        echo 'fname';
        $error_signup = 'found';
    }
    $lname = safeString($_POST['lname']);
    if (!preg_match("/^[A-Za-z]+$/", $lname)) {
        echo 'lname';
        $error_signup = 'found';
    }
    $email = safeString($_POST['email']);
    if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email)) {
        echo 'email';
        $error_signup = 'found';
    }
    $gender = safeString($_POST['gender']);
    if ($gender != "male" && $gender != "female") {
        echo 'gender';
        $error_signup = 'found';
    }
    $about = safeString($_POST['about']);
    if ($about != "") {
        if (!preg_match("/^[A-Za-z0-9 !.,&()?]|\d+$/", $about)) {
            echo 'about';
            $error_signup = 'found';
        }
    }
    $question = safeString($_POST['question']);
    if ($question != "") {
        if (!preg_match("/^[0-9]+$/", $question)) {
            echo 'question';
            $error_signup = 'found';
        }
    }
    $answer = safeString($_POST['answer']);
    if ($answer != "") {
        if (!preg_match("/^[A-Za-z0-9 ]+$/", $answer)) {
            echo 'answer';
            $error_signup = 'found';
        }
    }
    $answer = md5($answer);
    $hometown = safeString($_POST['hometown']);
    if ($hometown != "") {
        if (!preg_match("/^[A-Za-z ]+$/", $hometown)) {
            echo 'hometown';
            $error_signup = 'found';
        }
    }
    $city = safeString($_POST['city']);
    if ($city != "") {
        if (!preg_match("/^[A-Za-z ]+$/", $city)) {
            echo 'city';
            $error_signup = 'found';
        }
    }
    $profession = safeString($_POST['profession']);
    if ($profession != "") {
        if (!preg_match("/^[A-Za-z .,']+$/", $profession)) {
            echo 'profession';
            $error_signup = 'found';
        }
    }
    $education = safeString($_POST['education']);
    if ($education != "") {
        if (!preg_match("/^[A-Za-z .,']+$/", $education)) {
            echo 'education';
            $error_signup = 'found';
        }
    }
    $college = safeString($_POST['college']);
    if ($college != "") {
        if (!preg_match("/^[A-Za-z ,.']+$/", $college)) {
            $error_signup = 'found';
        }
    }
    $school = safeString($_POST['school']);
    if ($school != "") {
        if (!preg_match("/^[A-Za-z ,.']+$/", $school)) {
            echo 'school';
            $error_signup = 'found';
        }
    }
    $categories = safeString($_POST['categories']);
    if ($categories != "") {
        if (!preg_match("/^[0-9,]+$/", $categories)) {
            echo 'categories';
            $error_signup = 'found';
        }
    }
    if (!isset($error_signup)) {
        if($_FILES['file']['name'] == "") {
            if($gender=="male"){
                $filepath="images/avatar_male.png";
            }
            if($gender=="female"){
                $filepath="images/avatar_female.png";
            }
        }
        else{
            $allowedExts = array("jpeg", "jpg", "png");
            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    $filepath="";
                } 
                else {
                    $filepath = "userdata/" . $_SESSION['userid'] . "/" . $_FILES['file']['name'];
                    move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);
                }
            } 
            else {
                $filepath="";
            }
        }
    }
    if(!isset($error_signup)){
        $result = mysql_query("SELECT * FROM extendedinfo WHERE uid=" . $_SESSION['userid']) or die(mysql_error());
        if(!mysql_num_rows($result)){
            mysql_query("INSERT into extendedinfo values('$fname','$lname','$filepath','$email','$gender[0]','$about', '$question', '$answer' ,'$hometown','$city','$profession','$education','$college','$school'," . $_SESSION['userid'] . ")") or die(mysql_error());
            $array = explode(',', $categories);
            foreach ($array as $value) {
                mysql_query("INSERT INTO category_user values($value," . $_SESSION['userid'] . ")");
            }
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['avatar'] = $filepath;            
            echo '<meta http-equiv="refresh" content="0; url=index.php#intro">';
            die();
        }
    }   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign-up to SoapBox</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
        <link rel="stylesheet" href="css/signup.css" />
    </head>
    <body class="bg-blur">
        <div class="headbar">
            <div style="display: table-row">
                <div style="display: table-cell;padding-left: 20px;">
                    <h5 class="fg-white margin0 light logo">Soapbox</h5>
                </div>
            </div>
        </div>
        <div class="signup-filler"></div>
        <div class="main">
            <div class="container">
                <div class="pure-g" style="overflow: hidden;">
                    <div class="pure-u-1 bg-crimson banner">
                        <p class="light margin0 welcome-note fg-white">Hi there, <?php echo $_SESSION['username']; ?></p>
                    </div>
                    <div class="pure-u-1 filler-text">
                        <p class="toggle-center margin0">You are a few steps away from having your own account.</p>
                    </div>
                    <?php
                    if (isset($error_signup)) {
                        echo '<div class="pure-u-1 error-container">';
                        echo '<div class="error">';
                        echo '<p class="margin0 fg-darkRed bold"><i class="fa fa-exclamation-triangle"></i> Snap! Something went wrong. Please check your details again.<i class="fa fa-times flt-right close-error"></i></p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                    <!-- STEP 1 -->
                    <div class="padded-subcontainer step-1" style="padding: 20px 20px 20px 5px;">
                        <div class="pure-u-1 pure-u-md-1-4">
                            <div class="avatar">
                                <div class="defocus-panel">
                                    <i class="fa fa-camera fa-2x fg-white margin0 center-icon cam"></i>
                                </div>
                            </div>                            
                        </div>
                        <div class="pure-u-1 pure-u-md-3-4">
                            <div class="pure-g">
                                <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                    <input type="text" placeholder="first name" autofocus autocomplete="Off" class="txt-fname" tabindex="1" spellcheck="false" autocorrect="off" autocomplete="off" />
                                    <a href="javascript:;"><span class="status-symbol"><i class="fa fa-asterisk fg-red"></i></span></a>
                                </div>
                                <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                    <input type="text" placeholder="last name" autocomplete="Off" class="txt-lname" tabindex="2" spellcheck="false" autocorrect="off" autocomplete="off" />
                                    <a href="javascript:;"><span class="status-symbol"><i class="fa fa-asterisk fg-red"></i></span></a>
                                </div>
                                <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                    <input type="text" placeholder="email" autocomplete="Off" class="txt-email" tabindex="3" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />
                                    <a href="javascript:;"><span class="status-symbol"><i class="fa fa-asterisk fg-red"></i></span></a>
                                </div>
                                <div class="pure-u-1 pure-u-md-1-2" style="padding: 12px 5px 0 5px;">
                                    <div class="pure-g bg-grayLighter gender-parent">
                                        <div class="pure-u-1-2 txt-center gender male light active-male" style="padding: 1px;">
                                            <i class="fa fa-male fg-grayLight obey"></i> Male
                                        </div>
                                        <div class="pure-u-1-2 txt-center gender female light" style="padding: 1px;">
                                            <i class="fa fa-female fg-grayLight obey"></i> Female
                                        </div>
                                    </div>
                                </div>
                                <div class="pure-u-1"  style="padding: 0 5px 0 5px;position: relative;">
                                    <input type="text" placeholder="about you" class="txt-about" tabindex="5" autocomplete="off" />
                                    <span class="status-symbol"><i></i></span>
                                </div>
                                <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0px 5px;position: relative; margin-top: 11px;">
                                    <select class="security-question" tabindex="6">
                                        <option>-Security question-</option>
                                        <option value="0">What was your childhood nickname?</option>
                                        <option value="1">What is your birthplace?</option>
                                        <option value="2">What is the name of your best friend?</option>
                                        <option value="3">What is your first school's name?</option>
                                        <option value="4">Who is your childhood hero?</option>
                                        <option value="5">In what town was your first job?</option>
                                        <option value="6">What is your pet's name?</option>
                                        <option value="7">What is your father's middle name?</option>
                                        <option value="8">What is your favorite food?</option>
                                        <option value="9">Who was your favorite teacher?</option>
                                    </select>
                                </div>
                                <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                    <input type="text" placeholder="Answer" autocomplete="Off" class="txt-answer" tabindex="7" spellcheck="false" autocorrect="off" autocomplete="off" />
                                    <a href="javascript:;"><span class="status-symbol"><i class="fa fa-asterisk fg-red"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="pure-u-1-1 pure-u-md-1-8 offset-md-7-8" style="padding: 0 5px 0 5px;">
                            <button class="step-btn step-btn-1 bg-crimson fg-white next" tabindex="8">NEXT</button>
                        </div>
                    </div>
                    <!-- STEP 2 -->
                    <div class="padded-subcontainer step-2" style="display: none;">
                        <div class="pure-g">
                            <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                <input type="text" placeholder="hometown" autofocus autocomplete="Off" class="txt-hometown" tabindex="7" spellcheck="false" autocorrect="off" autocomplete="off" />
                                <span class="status-symbol"><i></i></span>
                            </div>
                            <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                <input type="text" placeholder="current city" autocomplete="Off" class="txt-city" tabindex="8" spellcheck="false" autocorrect="off" autocomplete="off" />
                                <span class="status-symbol"><i></i></span>
                            </div>              
                            <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                <input type="text" placeholder="profession" autocomplete="Off" class="txt-profession" tabindex="9" spellcheck="false" autocorrect="off" autocomplete="off" />
                                <span class="status-symbol"><i></i></span>
                            </div>
                            <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                <input type="text" placeholder="education" autocomplete="Off" class="txt-education" tabindex="10" spellcheck="false" autocorrect="off" autocomplete="off" />
                                <span class="status-symbol"><i></i></span>
                            </div>
                            <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                <input type="text" placeholder="college" autocomplete="Off" class="txt-college" tabindex="11" spellcheck="false" autocorrect="off" autocomplete="off" />
                                <span class="status-symbol"><i></i></span>
                            </div>
                            <div class="pure-u-1 pure-u-md-1-2" style="padding: 0 5px 0 5px;position: relative;">
                                <input type="text" placeholder="school" autocomplete="Off" class="txt-school" tabindex="12" spellcheck="false" autocorrect="off" autocomplete="off" />
                                <span class="status-symbol"><i></i></span>
                            </div>
                            <div class="pure-u-1-2" style="padding: 0 5px 0 5px;">
                                <button class="step-btn step-btn-2 bg-crimson fg-white back flt-left" style="width: auto;">BACK</button>
                            </div>                            
                            <div class="pure-u-1-2" style="padding: 0 5px 0 5px;">
                                <button class="step-btn step-btn-2 bg-crimson fg-white next flt-right" style="width: auto;" tabindex="13">NEXT</button>
                                <a href="javascript:;" class="flt-right skip-btn-2" style="margin: 17px 10px 5px 0;">Skip</a>
                            </div>
                        </div>
                    </div>
                    <!-- STEP 3 -->
                    <div class="padded-subcontainer step-3" style="display: none;">
                        <div class="pure-g" style="max-height: 280px;overflow-y: auto;">
                        <?php
                        dbConnect();
                        $result = mysql_query("SELECT * FROM category") or die(mysql_error());
                        if (mysql_num_rows($result)) {
                            while ($row = mysql_fetch_array($result)) {
                                echo '<div class="pure-u-1 pure-u-md-1-4 category">';
                                echo '<div class="background" style="background-image: url(' . $row['imagepath'] . ');">';
                                echo '<div class="defocus-panel">';
                                echo '<i class="fa fa-check-circle fa-3x fg-white margin0 center-icon"></i>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="title bg-steel">';
                                echo '<p class="margin0 txt-center bold fg-white category-name" data-cid="' . $row['srno'] . '">' . $row['name'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                            <!--div class="pure-u-1 pure-u-md-1-5 category">
                                <div class="background" style="background-image: url('images/program.jpg');">
                                    <div class="defocus-panel">
                                        <i class="fa fa-check-circle fa-3x fg-white margin0 center-icon"></i>
                                    </div>
                                </div>
                                <div class="title bg-steel">
                                    <p class="margin0 txt-center bold fg-white">Programming</p>
                                </div>
                            </div-->                              
                        </div>
                        <div class="pure-g">
                            <div class="pure-u-1-2" style="padding: 0 5px 0 5px;">
                                <button class="step-btn step-btn-3 bg-amber fg-white back flt-left" style="width: auto;">BACK</button>
                            </div>
                            <div class="pure-u-1-2" style="padding: 0 5px 0 5px;">
                                <button class="step-btn step-btn-3 bg-amber fg-white next flt-right" style="width: auto;">NEXT</button>
                            </div>                            
                        </div>
                    </div>
                    <!-- STEP 4 -->
                    <div class="padded-subcontainer step-4" style="display: none;">
                        <div class="pure-g">
                            <div class="pure-u-1 pure-u-md-1-4 txt-center checkout-icon">
                                <i class="fa fa-thumbs-o-up fa-5x margin0 fg-white thumbsup"></i>
                            </div>
                            <div class="pure-u-1 pure-u-md-3-4 checkout-message">
                                <h3 class="bold">Awesome!</h3>
                                <p>Make sure you have given us correct information before you proceed. You can always update your information anytime you want.</p>
                            </div>
                        </div>
                        <div class="pure-g">
                            <div class="pure-u-1-2" style="padding: 0 5px 0 5px;">
                                <button class="step-btn step-btn-4 bg-cyan fg-white back flt-left" style="width: auto;">BACK</button>
                            </div>
                            <div class="pure-u-1-2" style="padding: 0 5px 0 5px;">
                                <button class="step-btn step-btn-4 bg-cyan fg-white next flt-right" style="width: auto;" onclick="$('.signupdetailsform').submit();">DONE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" action="signup.php" enctype="multipart/form-data" class="signupdetailsform">
                    <input type="file" name="file" accept='image/*' style="display: none;" />
                    <input type="hidden" name="fname" />
                    <input type="hidden" name="lname" />
                    <input type="hidden" name="email" />
                    <input type="hidden" name="gender" value="male" />
                    <input type="hidden" name="about" />
                    <input type="hidden" name="question">
                    <input type="hidden" name="answer" />
                    <input type="hidden" name="hometown" />
                    <input type="hidden" name="city" />
                    <input type="hidden" name="profession" />
                    <input type="hidden" name="education" />
                    <input type="hidden" name="college" />
                    <input type="hidden" name="school" />
                    <input type="hidden" name="categories" value="" />
                </form>
                <div class="progress-parent">
                    <div class="bg-crimson progress" style="width:10%;"></div>
                </div>
            </div>
        </div>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/signup.js"></script>
    </body>
</html>
