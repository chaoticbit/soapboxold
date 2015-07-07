$(document).ready(function () {
    if($('.signup-form').hasClass('found')){
        $('.login-form').hide();
        $('.signup-form').show();
    }
    /* function def */
    function toggle_submit() {
        if ($('.nun i').hasClass('fa fa-check-circle fg-green') && $('.pwd i').hasClass('fa fa-check-circle fg-green') && $('.cpw i').hasClass('fa fa-check-circle fg-green'))
            $('.signup-submit').removeAttr('disabled');
        else
            $('.signup-submit').attr('disabled', true);
    }
    function toggle_submit2() {
        if ($('.rpwd i').hasClass('fa fa-check-circle fg-green') && $('.rcpw i').hasClass('fa fa-check-circle fg-green'))
            $(document).find('.update-pwd-submit').removeAttr('disabled');
        else
            $(document).find('.update-pwd-submit').attr('disabled', true);
    }

    /* auto show tips */
    $('.signup-username').focusin(function () {
        if (screen.width > 768)
            $('.tips-username').fadeIn('slow');
    });
    $('.signup-username').focusout(function () {
        $('.tips-username').fadeOut();
    });
    $('.signup-password').focusin(function () {
        $('.tips-password').fadeIn('slow');
    });
    $('.signup-password').focusout(function () {
        $('.tips-password').fadeOut();
    });
    $(document).on('focusin','.rst-password',function(){
        $('.tips-password').fadeIn('slow');
    });
    $(document).on('focusin','.rst-pwdcon',function(){
        $('.tips-password').fadeOut();
    });
    $('.show-tips').click(function () {
        alert('Username must not start with number or special character\n\nPassword must be at least 8 characters long');
    });

    /* slide up signup form */
    $('.login-signup').click(function () {
        $(this).parent().slideUp(function () {
            $('body').find('.signup-form').show();
            $('body').find('.signup-form input[type="text"]').focus();
            //$('body').find('.login-signup-tips').fadeIn('slow').delay(3700).fadeOut('slow');
        });
    });
    $('.go-back').click(function () {
        $('body').find('.signup-form').slideUp(function () {
            $('body').find('.login-form').show();
            $('body').find('.login-form input[type="text"]').focus();
        });
    });
    $('.show-tips').click(function () {
        $('body').find('.login-signup-tips').fadeIn('slow').delay(3700).fadeOut('slow');
    });

    /* auto select bg */
    var image = new Array();
    image[0] = "images/himalaya.jpg";
    image[1] = "images/gg.jpg";
    image[2] = "images/london.jpg";
    image[3] = "images/blur.jpg";
    image[4] = "images/home.jpg";
    var size = image.length;
    var x = Math.floor(size * Math.random())
    $('.bg-blur').css('background', 'url(' + image[x] + ') no-repeat center center fixed');
    $('.bg-blur').css('background-size', 'cover');

    /* validate login form */
    $('form[name="loginform"]').submit(function () {
        var isFormValid = true;
        $(this).children("input").each(function () { // Note the :text

            //trim every value
            $(this).val($.trim($(this).val()));

            if ($(this).val().length == 0) {
                $(this).addClass('invalid');
                isFormValid = false;
                $(this).keyup(function () {
                    if ($(this).val().length > 0 && !(/^\s*$/).test($(this).val())) {
                        $(this).removeClass('invalid');
                        isFormValid = true;
                    }
                    else
                        $(this).addClass('invalid');
                });
            }
            else {
                $(this).removeClass('invalid');
            }
        });
        return isFormValid;
    });

    /* validate signup form */
    $(".signup-username").bind('input', function () {

        //trim val
        var username = $.trim($(this).val());

        //regex check
        if (/^[a-z][a-zA-Z0-9_.]{0,14}$/.test(username)) {
            if (username.length < 5) {
                $('.nun').children('i').removeClass();
                $('.nun').hide();
            }
            //check db
            if (username.length >= 5) {
                $.ajax({
                    type: 'POST',
                    url: "request.php?KEY=checkUsername&DATA=" + username,
                    cache: false,
                    beforeSend: function () {
                        $('.nun').children('i').removeClass();
                        $('.nun').children('i').addClass('fa fa-circle-o-notch fa-spin fg-blue');
                        $('.nun').show();
                    },
                    complete: function () {
                    },
                    success: function (result) {
                        if (result === 'false') {
                            $('.nun').children('i').removeClass();
                            $('.nun').children('i').addClass('fa fa-check-circle fg-green');
                        }
                        else if (result === 'true') {
                            $('.nun').children('i').removeClass();
                            $('.nun').children('i').addClass('fa fa-times-circle fg-red');
                        }
                        $('.nun').show();
                        toggle_submit();
                    }});
            }
        }
        else {
            if (username === "") {
                $('.nun').hide();
                return;
            }
            $('.nun').children('i').removeClass();
            $('.nun').children('i').addClass('fa fa-times-circle fg-red');
            $('.nun').show();
            toggle_submit();
        }
    });

    $('.signup-password').bind('input', function () {

        //trim password
        var password = $.trim($(this).val());

        //init confirm password
        $('.signup-pwdcon').val("");
        $('.cpw').children('i').removeClass();
        $('.cpw').hide();

        //regex test
        if (/^[a-zA-Z0-9!@#$%^&*]{8,30}$/.test(password)) {

            //check length
            if (password.length < 8 || password.length > 30) {

                $('.pwd').children('i').removeClass();
                $('.pwd').children('i').addClass('fa fa-times-circle fg-red');
            }
            else {

                $('.pwd').children('i').removeClass();
                $('.pwd').children('i').addClass('fa fa-check-circle fg-green');
            }
            $('.pwd').show();
            toggle_submit();
        }
        else {
            if (password === "") {
                $('.pwd').hide();
                return;
            }
            $('.pwd').children('i').removeClass();
            $('.pwd').children('i').addClass('fa fa-times-circle fg-red');
            $('.pwd').show();
        }

    });

    $('.signup-pwdcon').bind('input', function () {

        var pwdcon = $.trim($(this).val());
        var password = $.trim($('.signup-password').val());

        if (pwdcon === "") {
            $('.cpw').hide();
            return;
        }

        if (pwdcon !== password) {
            $('.cpw').children('i').removeClass();
            $('.cpw').children('i').addClass('fa fa-times-circle fg-red');
        }
        else {
            $('.cpw').children('i').removeClass();
            $('.cpw').children('i').addClass('fa fa-check-circle fg-green');
        }
        $('.cpw').show();
        toggle_submit();
    });
    
    $(document).on('input','.rst-password',function () {
        //trim password
        var password = $.trim($(this).val());

        //init confirm password
        $('.rst-pwdcon').val("");
        $('.rcpw').children('i').removeClass();
        $('.rcpw').hide();

        //regex test
        if (/^[a-zA-Z0-9!@#$%^&*]{8,30}$/.test(password)) {

            //check length
            if (password.length < 8 || password.length > 30) {

                $('.rpwd').children('i').removeClass();
                $('.rpwd').children('i').addClass('fa fa-times-circle fg-red');
            }
            else {

                $('.rpwd').children('i').removeClass();
                $('.rpwd').children('i').addClass('fa fa-check-circle fg-green');
            }
            $('.rpwd').show();
            toggle_submit2();
        }
        else {
            if (password === "") {
                $('.rpwd').hide();
                return;
            }
            $('.rpwd').children('i').removeClass();
            $('.rpwd').children('i').addClass('fa fa-times-circle fg-red');
            $('.rpwd').show();
        }

    });
    $(document).on('input','.rst-pwdcon',function () {

        var pwdcon = $.trim($(this).val());
        var password = $.trim($('.rst-password').val());

        if (pwdcon === "") {
            $('.rcpw').hide();
            return;
        }

        if (pwdcon !== password) {
            $('.rcpw').children('i').removeClass();
            $('.rcpw').children('i').addClass('fa fa-times-circle fg-red');
        }
        else {
            $('.rcpw').children('i').removeClass();
            $('.rcpw').children('i').addClass('fa fa-check-circle fg-green');
        }
        $('.rcpw').show();
        toggle_submit2();
    });
    
    
    $('.reset-pwd').click(function(){
        if( $('input[name="resetPwdUname"]').hasClass('hidden') ){
            $('input[name="resetPwdUname"]').removeClass('hidden');
            $('input[name="resetPwdUname"]').focus();
        }
        else{
            $('input[name="resetPwdUname"]').val("");
            $('input[name="resetPwdUname"]').addClass('hidden');
        }
    });
    $('.resetPwdUname').bind('keydown', function (e) {
        if($.trim($(this).val())!==""){
            if ((e.keyCode === 13)) {
                $.ajax({
                   url: 'request.php',
                   type: 'POST',
                   data: 'KEY=resetAc&DATA='+$(this).val(),
                   success: function(result){
                        if(result==='0') {
                            $('.resetPwdUname').css('border-bottom-color','red');
                        }
                        else{
                            var qid = result.split("&&")[0];
                            var uname = result.split("&&")[1];
                            $('input[name="uname_resetpwd"]').val(uname);
                            var question;
                            $('.login-form').slideUp(function () {
                                switch(qid) {
                                    case '0': question = 'Q : What was your childhood nickname?';
                                        break;
                                    case '1': question = 'Q : What is your birthplace?';
                                        break;                                 
                                    case '2': question = 'Q : What is the name of your best friend?';
                                        break;                                       
                                    case '3': question = 'Q : What is your first school\'s name?';
                                        break;                                    
                                    case '4': question = 'Q : Who is your childhood hero?';
                                        break;                                    
                                    case '5': question = 'Q : In what town was your first job?';
                                        break;                                    
                                    case '6': question = 'Q : What is your pet\'s name?';
                                        break;                                    
                                    case '7': question = 'Q : What is your father\'s middle name?';
                                        break;
                                    case '8': question = 'Q : What is your favorite food?';
                                        break;        
                                    case '9': question = 'Q : Who was your favorite teacher?';
                                        break;               
                                }
                                $('.reset-question').html(question);
                                $('body').find('.resetpwd-form').show();
                                $('body').find('.resetpwd-form input[type="text"]').focus();
                            });                       
                        }
                    }
                });
            }
        }   
    });
    $('.reset-answer').bind('keydown',function(e){
        if($.trim($(this).val())!=="") {
            if(e.keyCode === 13) {
                $.ajax({
                    url: 'request.php',
                    type: 'POST',
                    data: 'KEY=resetAnswer&answer=' + $(this).val() + '&username=' + $('input[name="uname_resetpwd"]').val(),
                    success: function(result){
                        var r = result.split("&&")[0];
                        var u = result.split("&&")[1];
                        if(r==='1'){
                            $('.resetpwd-form').html('<div class="pure-u-1 reset-password" style="position: relative;">\n\
                            <div class="tips tips-password" style="display: none;">\n\
                            <i class="fa fa-caret-right fa-2x fg-lightBlue right-caret" style="top: 4px;"></i>\n\
                            <div class="bg-lightBlue tip" style="top: -11px;">\n\
                                <p class="fg-white bold txt-center margin0" style="font-size: 10pt;">Must contain at least 8 characters.</p>\n\
                            </div>\n\
                        </div>\n\
                        <form method="post" action="login.php" autocomplete="Off" name="resetpwdform">\n\
                            <input type="hidden" name="unameconfirm" value="'+u+'" />\n\
                            <div style="position: relative;">\n\
                                <input type="password" class="login-credential rst-password" name="new_password" placeholder="password" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />\n\
                                <span class="rpwd status-symbol" style="display: none;"><i></i></span>\n\
                            </div>\n\
                            <div style="position: relative;">\n\
                                <input type="password" class="login-credential rst-pwdcon" name="conf_password" placeholder="confirm password" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" />\n\
                                <span class="rcpw status-symbol" style="display: none;"><i></i></span>\n\
                            </div>\n\
                            <div style="position: relative; margin-top: 10px;">\n\
                                <input type="submit" class="btn-general login-submit bg-white fg-grayLight update-pwd-submit" disabled="disabled" name="updatepwd-submit-btn" value="UPDATE" />\n\
                            </div>\n\
                        </form>\n\
                    </div>');
                            $('.rst-password').focus();
                        }
                        else{
                            $('.reset-answer').css('border-bottom-color','red');
                        }
                    }
                });
            }
        } 
    });
});