$(document).ready(function(){
    function regex_escape(str) {
        return str.replace(new RegExp('[.\\\\+*?\\[\\^\\]$(){}=!<>|:;\\-\']', 'g'), '\\$&');
    }

    function validate(input, regex) {
        var val = $.trim($(input).val());
        if (val === "") {
            $(input).parent().find('i').removeClass();
            return 0;
        }        
        if (!regex.test(val)) {
            $(input).parent().find('i').removeClass();
            $(input).parent().find('i').addClass('fa fa-times-circle fg-red');
            return 0;
        }
        else {
            $(input).parent().find('i').removeClass();
            $(input).parent().find('i').addClass('fa fa-check-circle fg-green');
            return 1;
        }
    }
    $('.txt-fname').bind('input', function () {
        validate('.txt-fname', /^[A-Za-z]+$/);
    });
    $('.txt-lname').bind('input', function () {
        validate('.txt-lname', /^[A-Za-z]+$/);
    });    
    $('.txt-about').bind('input', function () {
        validate('.txt-about', /^[A-Za-z0-9 !.,&()?]+$/);
    });
    $('.txt-hometown').bind('input', function () {
        validate('.txt-hometown', /^[A-Za-z ]+$/);
    });
    $('.txt-city').bind('input', function () {
        validate('.txt-city', /^[A-Za-z ]+$/);
    });
    $('.txt-profession').bind('input', function () {
        validate('.txt-profession', /^[A-Za-z .,']+$/);
    });
    $('.txt-education').bind('input', function () {
        validate('.txt-education', /^[A-Za-z .,']+$/);
    });
    $('.txt-college').bind('input', function () {
        validate('.txt-college', /^[A-Za-z ,.']+$/);
    });
    $('.txt-school').bind('input', function () {
        validate('.txt-school', /^[A-Za-z ,.']+$/);
    });
    $('.txt-newpwd').bind('input', function () {
        $('.txt-conpwd').val("");
        $('.txt-conpwd').parent().find('i').removeClass();
        validate('.txt-newpwd', /^[a-zA-Z0-9!@#$%^&*]{8,30}$/);
    });    
    $('.txt-conpwd').bind('input', function () {
        if($(this).val()===$('.txt-newpwd').val() && $.trim($(this).val())!==""){
            $(this).parent().find('i').removeClass();
            $(this).parent().find('i').addClass('fa fa-check-circle fg-green');
        }
        else{
            $(this).parent().find('i').removeClass();
            $(this).parent().find('i').addClass('fa fa-times-circle fg-red');            
        }
    });
    $('.txt-email').bind('input', function () {
        if(validate('.txt-email',  /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/)===1){
            var val = $.trim($(this).val());
            $.ajax({
                type: 'post',
                url: 'request.php?KEY=checkEmail&DATA='+val,
                cache: false,
                success: function(result){
                    if(result==="false"){
                        $('.txt-email').parent().find('i').removeClass();
                        $('.txt-email').parent().find('i').addClass('fa fa-check-circle fg-green');
                        return;
                    }
                    if(result==="true"){
                        $('.txt-email').parent().find('i').removeClass();
                        $('.txt-email').parent().find('i').addClass('fa fa-times-circle fg-red');
                        return;
                    }
                }
            });
        }
    });
    $('.update-one').click(function(){
        var ele = $(this);
        if(validate('.txt-email',  /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/)===1){
            var val = $.trim($('.txt-email').val());
            $.ajax({
                type: 'post',
                url: 'request.php?KEY=checkEmail&DATA='+val,
                cache: false,
                success: function(result){
                    if(result==="false"){
                        $('.txt-email').parent().find('i').removeClass();
                        $('.txt-email').parent().find('i').addClass('fa fa-check-circle fg-green');
                        $.ajax({
                            type: 'post',
                            url: 'request.php?KEY=updateEmail&DATA='+val,
                            cache: false,
                            success: function(status){
                                if(status==="true"){
                                    $(ele).parent().html('<span class="fg-green">Done!</span>');
                                }
                                else{
                                    alert('Something went wrong. Please try again later');
                                }
                            }
                        });
                    }
                    if(result==="true"){
                        $('.txt-email').parent().find('i').removeClass();
                        $('.txt-email').parent().find('i').addClass('fa fa-times-circle fg-red');
                        alert('This email address is already being used by someone.');
                        return;
                    }
                }
            });
        }
    });
    $('.update-three').click(function(){
        var ele = $(this);
        var fname = $.trim($('.txt-fname').val());
        var lname = $.trim($('.txt-lname').val());
        var gender = $.trim($('input[name="gender"]:checked').val());
        var about = $.trim($('.txt-about').val());
        
        $.ajax({
            type: 'post',
            url: 'request.php?KEY=updateInfoSetOne&fname='+fname+'&lname='+lname+'&gender='+gender+'&about='+about,
            cache: false,
            success: function(result){
                if(result==="true"){
                    $(ele).parent().html('<span class="fg-green">Done!</span>');
                }
                else{
                    alert(result);
                }
            }
        });
    });
    $('.update-four').click(function(){
        var ele = $(this);
        var hometown = $.trim($('.txt-hometown').val());
        var city = $.trim($('.txt-city').val());
        var profession = $.trim($('.txt-profession').val());
        var education = $.trim($('.txt-education').val());
        var college = $.trim($('.txt-college').val());
        var school = $.trim($('.txt-school').val());
        $.ajax({
            type: 'post',
            url: 'request.php?KEY=updateInfoSetTwo&hometown='+hometown+'&city='+city+'&profession='+profession+'&education='+education+'&college='+college+'&school='+school,
            cache: false,
            success: function(result){
                if(result==="true"){
                    $(ele).parent().html('<span class="fg-green">Done!</span>');
                }
                else{
                    alert(result);
                }
            }
        });
    });
    //avatar defocus panel
    $('.new-avatar').on('mouseover', function () {
        $('.defocus-panel').show();
    });
    $('.new-avatar').on('mouseout', function () {
        $('.defocus-panel').hide();
    });

    //camera icon click
    $('.cam').click(function () {
        $('input[name="file"]').click();
    });

    //avatar display
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.new-avatar').removeAttr('style');
                $('.new-avatar').css('opacity', '0');
                $('.new-avatar').css('background', 'url(' + e.target.result + ') no-repeat').animate({opacity: '1'});
                $('.new-avatar').css('background-position', '50% 50%');
                $('.new-avatar').css('background-size', 'cover');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[name="file"]').change(function () {
        readURL(this);
    });
    
});
