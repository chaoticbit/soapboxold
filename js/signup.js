$(document).ready(function () { 
    window.emailFlag = false;
    function changePaint(btn, curColor, nxtColor, flrColor, width) {
        $('.banner').removeClass(curColor).addClass(nxtColor).animate(100);
        $('.filler-text').css('background', flrColor).animate(100);
        $('.progress').removeClass(curColor).addClass(nxtColor).animate({width: width}, 100);
        $(btn).removeClass(curColor).addClass(nxtColor).animate(100);
    }
    function validate(input, regex, mode) {
        var val = $.trim($(input).val());
        if (mode === 1 && val === "") {
            $(input).parent().find('i').removeClass();
            $(input).parent().find('i').addClass('fa fa-asterisk fg-red');
            return 0;
        }
        if (mode === 0 && val === "") {
            $(input).parent().find('i').removeClass();
            return 1;
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
        validate('.' + $(this).attr('class'), /^[A-Za-z]+$/, 1);
    });
    $('.txt-lname').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z]+$/, 1);
    });
    $('.txt-email').bind('input', function () {
        if(validate('.' + $(this).attr('class'),  /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/, 1)===1){
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
    $('.txt-about').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z0-9 !.,&()?]+$/, 0);
    });
    $('.security-question').on('change', function () {
        $('input[name="question"]').val($('.security-question').val());
    });
    $('.txt-answer').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z0-9 ]{0,20}$/, 1);
    });
    $('.txt-hometown').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z ]+$/, 0);
    });
    $('.txt-city').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z ]+$/, 0);
    });
    $('.txt-profession').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z .,']+$/, 0);
    });
    $('.txt-education').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z .,']+$/, 0);
    });
    $('.txt-college').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z ,.']+$/, 0);
    });
    $('.txt-school').bind('input', function () {
        validate('.' + $(this).attr('class'), /^[A-Za-z ,.']+$/, 0);
    });

    //step-1
    $('.step-btn-1').click(function () {
        if ($(this).hasClass('next')) {
            if (validate('.txt-fname', /^[A-Za-z]+$/, 1) === 0)
                return;
            else
                $('input[name="fname"]').val($('.txt-fname').val());

            if (validate('.txt-lname', /^[A-Za-z]+$/, 1) === 0)
                return;
            else
                $('input[name="lname"]').val($('.txt-lname').val());

            var val = $.trim($('.txt-email').val());
            $('input[name="email"]').val($('.txt-email').val());
//            $.ajax({
//                type: 'post',
//                url: 'request.php?KEY=checkEmail&DATA=' + val,
//                cache: false,
//                success: function (result) {
//                    if (result === "false") {
//                        if(validate('.txt-email', /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/, 1) === 1){
//                            $('.txt-email').parent().find('i').removeClass();
//                            $('.txt-email').parent().find('i').addClass('fa fa-check-circle fg-green');
//                            window.emailFlag = true;
//                        }
//                    }
//                    if (result === "true") {
//                        $('.txt-email').parent().find('i').removeClass();
//                        $('.txt-email').parent().find('i').addClass('fa fa-times-circle fg-red');
//                        window.emailFlag = false;
//                    }
//                }
//            });
//            if(!window.emailFlag)
//                return;

            if (validate('.txt-about', /^[A-Za-z0-9 !.,&()?']+$/, 0) === 0)
                return;
            else
                $('input[name="about"]').val($('.txt-about').val());
            
            if(validate('.security-question' , /^[0-9]+$/ , 1) === 0)
                return;
            else
                $('input[name="question"]').val($('.security-question').val());
            
            if(validate('.txt-answer' , /^[A-Za-z0-9 ]+$/ , 1) === 0)
                return;
            else
                $('input[name="answer"]').val($('.txt-answer').val());    
            
            $('.step-1').animate({
                marginLeft: '-100%'
            }, "slow", function () {
                $(this).closest('.step-1').hide();
                $('body').find('.step-2').fadeIn(function () {
                    changePaint('.step-btn-2', 'bg-crimson', 'bg-amber', '#fef6e7', '40%');
                });
            });
        }
    });
    //step-2
    $('.step-btn-2').click(function () {
        if ($(this).hasClass('next')) {
            if (validate('.txt-hometown', /^[A-Za-z ]+$/, 0) === 0)
                return;
            else
                $('input[name="hometown"]').val($('.txt-hometown').val());

            if (validate('.txt-city', /^[A-Za-z ]+$/, 0) === 0)
                return;
            else
                $('input[name="city"]').val($('.txt-city').val());

            if (validate('.txt-profession', /^[A-Za-z ,.']+$/, 0) === 0)
                return;
            else
                $('input[name="profession"]').val($('.txt-profession').val());

            if (validate('.txt-education', /^[A-Za-z .,']+$/, 0) === 0)
                return;
            else
                $('input[name="education"]').val($('.txt-education').val());

            if (validate('.txt-college', /^[A-Za-z ,.']+$/, 0) === 0)
                return;
            else
                $('input[name="college"]').val($('.txt-college').val());

            if (validate('.txt-school', /^[A-Za-z ,.']+$/, 0) === 0)
                return;
            else
                $('input[name="school"]').val($('.txt-school').val());

            $('.step-2').animate({
                marginLeft: '-100%'
            }, "slow", function () {
                $(this).closest('.step-2').hide();
                $('body').find('.step-3').fadeIn(function () {
                    changePaint('.step-btn-3', 'bg-amber', 'bg-cyan', '#ecf7fd', '80%');
                });
            });
            $('.txt-hometown').focus();
        }
        if ($(this).hasClass('back')) {
            $('.step-1').css('margin-left', '0px');
            $('.step-2').fadeOut(function () {
                $('.step-1').fadeIn(function () {
                    changePaint('.step-btn-1', 'bg-amber', 'bg-crimson', '#fff0f4', '10%');
                });
            });

        }
    });

    $('.skip-btn-2').click(function () {
        $('.step-2').animate({
            marginLeft: '-100%'
        }, "slow", function () {
            $(this).closest('.step-2').hide();
            $('body').find('.step-3').fadeIn(function () {
                changePaint('.step-btn-3', 'bg-amber', 'bg-cyan', '#ecf7fd', '80%');
            });
        });
    });

    //step-3
    $('.step-btn-3').click(function () {
        if ($(this).hasClass('next')) {
            if($('input[name="categories"]').val()==""){
                alert("Select at least one category to proceed.");
                return;
            }
            $('.step-3').animate({
                marginLeft: '-100%'
            }, "slow", function () {
                $(this).closest('.step-3').hide();
                $('body').find('.step-4').fadeIn(function () {
                    $('.progress').css('border-bottom-right-radius', '3px');
                   changePaint('.step-btn-4', 'bg-cyan', 'bg-green', '#e9ffd4', '100%');
                });
            });
        }
        if ($(this).hasClass('back')) {
            $('.step-2').css('margin-left', '0px');
            $('.step-3').fadeOut(function () {
                $('.step-2').fadeIn(function () {
                    changePaint('.step-btn-2', 'bg-cyan', 'bg-amber', '#fef6e7', '40%');
                });
            });
        }
    });

    //step-4
    $('.step-btn-4').click(function () {
        if ($(this).hasClass('next')) {
            //
        }
        if ($(this).hasClass('back')) {
            $('.step-3').css('margin-left', '0px');
            $('.step-4').fadeOut(function () {
                $('.step-3').fadeIn(function () {
                    changePaint('.step-btn-3', 'bg-green', 'bg-cyan', '#ecf7fd', '80%');
                });
            });
        }
    });

    //avatar defocus panel
    $('.avatar').on('mouseover', function () {
        $('.defocus-panel').show();
    });
    $('.avatar').on('mouseout', function () {
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
                $('.avatar').removeAttr('style');
                $('.avatar').css('opacity', '0');
                $('.avatar').css('background', 'url(' + e.target.result + ') no-repeat').animate({opacity: '1'});
                $('.avatar').css('background-position', '50% 50%');
                $('.avatar').css('background-size', 'cover');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[name="file"]').change(function () {
        readURL(this);
    });

    //gender select
    $('.gender').click(function () {
        if ($(this).hasClass('male')) {
            $(this).parent().find('.active-female').removeClass('active-female');
            $(this).addClass('active-male');
            $('input[name="gender"]').val('male');
        }
        if ($(this).hasClass('female')) {
            $(this).parent().find('.active-male').removeClass('active-male');
            $(this).addClass('active-female');
            $('input[name="gender"]').val('female');
        }
    });

    $('.status-symbol').click(function () {
        alert('This field is mandatory');
    });

    //category defocus panel
    $('.category').click(function () {
        if ($(this).hasClass('selected')) {

            //update hdn input
            var val = $(this).find('.category-name').attr('data-cid');
            var array = $('input[name="categories"]').val().split(",");
            var newstr = "";
            for (var i = 0; i < array.length; i++) {
                if(array[i]===val)
                    continue;
                if (newstr==="") {
                    newstr = newstr + array[i];
                }
                else {
                    newstr = newstr + "," + array[i];
                }
            }
            $('input[name="categories"]').val(newstr);

            //apply effect
            $(this).find('.title').removeClass('bg-green').addClass('bg-steel');
            $(this).find('.defocus-panel').fadeOut(100);
            $(this).removeClass('selected');
        }
        else {
            var value = $('input[name="categories"]').val();
            if (value !== "") {
                var array = $('input[name="categories"]').val().split(",");
                if ($.inArray($(this).find('.category-name').attr('data-cid'), array) === -1) {
                    $('input[name="categories"]').val($('input[name="categories"]').val() + ',' + $(this).find('.category-name').attr('data-cid'));
                }
            }
            else {
                $('input[name="categories"]').val($(this).find('.category-name').attr('data-cid'));
            }

            $(this).find('.title').removeClass('bg-steel').addClass('bg-green');
            $(this).find('.defocus-panel').fadeIn(100);
            $(this).addClass('selected');
        }
    });
});