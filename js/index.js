$(document).ready(function () {    
    if(window.location.hash){
        if (screen.width > 480) {
            changeIntro = function(type) {
            switch(type) {
                case '1':   $('.intro-btn').attr('data-next','2');
                            $('.sidebar').removeClass('introside');
                            $('.editor-wrapper').wrap('<div class="intro-wrapper" />');
                            $('.editor-wrapper').slideDown(function(){
                                $('.intro-wrapper').addClass('introside');
                            });
                            var w = $('.thread-parent').width();
                            w=w+280;
                            $('.fluid-content').animate({top: '75px',left: w+'px'},"slow");
                            $('.editable').html('Select this text!');  
                            $('.fl-cont').html('<b>Soapbox Editor</b><br/> Select the text to<br/>enable formatting options.');
                            $('.intro-btn').html('Exit');
                            break;
                case '2':   $('.intro').remove();
                            window.location = 'index.php';
                            break;

            }
            };
            $(document).on('click','.intro-btn',function(){
                var type = $('.intro-btn').attr('data-next');
                changeIntro(type);
            });
            $('body').append('<div class="intro">\n\
                            <div class="fluid-content" style="display:none;"><div class="full-span fl-cont"><b>Sidebar</b><br>You may navigate through here.</div><div class="full-span"><a href="javascript:;" data-next="1" class="fg-darker flt-right intro-btn">Next</a></div></div>\n\\n\
                            <div class="editor-help-parent intro-note" style="background: rgba(0,0,0,0.5);">\n\
                                <div class="editor-help-child" style="height: auto;">\n\
                                    <div class="pure-g">\n\
                                        <div class="pure-u-1 bg-globalColor" style="padding: 10px;">\n\
                                            <h5 class="fg-white bold">WELCOME TO SOAPBOX</h5>\n\
                                        </div>\n\
                                        <div class="pure-u-1 bg-white" style="padding: 10px;">\n\
                                            <h5 class="txt-center light margin0">First we will give you a brief tour of what you can do here.</h5>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                            </div>');   
            $('body').addClass('offscroll');
            var topMargin = (window.innerHeight - 500) / 2;
            $('.editor-help-child').css('margin-top', topMargin + 'px');
            $('.intro-note').fadeIn().delay(3000).fadeOut(function(){
                $('.sidebar').addClass('introside');
                $('.fluid-content').fadeIn();
            });
            if($('.intro').length){
                $(document).keydown(function(e){
                    if(e.keyCode === 39 && $('.intro-btn').attr('data-next') === '1') {
                        $('.intro-btn').click();
                    }
                });
            }
        }
    }
    
    window.globalDraftFlag = false;
    //
    // Dear maintainer:
    //
    // When i wrote this code, only I and God
    // knew what it was.
    // Now, only God knows !
    //
    // So if you are done trying to 'optimize'
    // this routine (and failed).
    // please increment the following counter
    // as a warning
    // to the next guy:
    //
    // total_hours_wasted_here = 67
    //
    var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
    var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
    var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
    var is_safari = navigator.userAgent.indexOf("Safari") > -1;
    var is_opera = navigator.userAgent.toLowerCase().indexOf("op") > -1;
    if ((is_chrome)&&(is_safari)) {is_safari=false;}
    if ((is_chrome)&&(is_opera)) {is_chrome=false;}
    askConfirm = function() {
        if(window.globalDraftFlag) {
            return "You haven't finished your post yet. Do you want to leave without finishing?";
        }
    };
    if (is_safari) {
        window.onunload = function(e){
            if(window.globalDraftFlag) {
                alert("You haven't finished your post yet. Do you want to leave without finishing?");
            }
        };
    }
    else{
        window.onbeforeunload = askConfirm; 
    }

    /** New Post Actions mobile**/
    $('.toggle-new-question').bind('click', function () {
        $('.mobile-new-thread-container').animate({top: '0px'});
        $('.loadingstatmobile').removeAttr("style");
        $('body').addClass('offscroll');
    });
    $('.cancel-new-thread').bind('click', function () {
        askConfirm();
        $('.mobile-new-thread-container').animate({top: '-100%'}, function () {
            $('body').removeClass('offscroll');
            $('.mobile-thread-title').val('');
            $('.mobile-thread-description').val('');
            $('.mobiletags').val('');
            $('.mobiletags').attr('data-cnt', '0');
            $('.tag-mobile').remove();
            $('.thread-mobile-image').val("");
            $('input[name="mobile-filename"]').val("");
            $('.mobile-filename-span').removeClass('fg-green').html('Upload Image');
            $('.btn-remove-img-mobile').hide();
        });
        window.globalDraftFlag = false;
    });

    /** toggle sidebar **/
    $('.toggle-stack').click(function () {
        $('.sidebar').wrap('<div class="sidebar-mobile-parent" />');
        $('.sidebar').animate({left: '0px'}, 500);
    });

    /** new question toggle desktop and tablet **/
    $('.new-thread-toggle').click(function () {
        $(this).parent().hide();
        $('.cancel-toggle').show();
        $('.post-thread').parent().show();
        $('.editor-wrapper').slideDown(function () {
            $(this).find('.thread-title').focus();
        });
        $('.loadingstat').removeAttr("style");
    });
    $('.cancel-new-thread-toggle').click(function () {
        $(window).scrollTop(0);
        $('.cancel-toggle').hide();
        $('.post-thread').parent().hide();
        $('.new-thread-toggle').parent().show();
        $('.editor-wrapper').slideUp(500, function () {
            $(this).find('.duptarea').val("");
            $(this).find('.thread-editor-title').val("");
            $(this).find('.editable').html("");
            $(this).find('.tags').val("");
            $(this).find('.tags').attr('data-cnt', '0');
            $('.tag').remove();
            removeimage();
        });
        window.globalDraftFlag = false;
    });
    
    /** post thread **/
    $('.post-thread').bind('click', function () {
        var threadTitle = $('input[name="new-thread-title"]').val();
        threadTitle = regex_escape(threadTitle);
        var fileName = $('input[name="filename"]').val();
        var coordinates = $('.image-preview').css('background-position');
        var threadDesc = $('.duptarea').val();
        threadDesc = regex_escape(threadDesc);
        var threadCategory = $('.new-thread-category').val();
        var tags = $('.tags').val();

        if ($.trim(threadTitle) !== "") {
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: {KEY: 'createNewThread', threadtitle: threadTitle, filename: fileName, coordinates: coordinates, threaddesc: threadDesc, threadcategory: threadCategory, tags: tags},
                beforeSend: function () {
                    $(window).scrollTop(0);
                    $('.loadingstat').animate({width: '100%'}, "slow");
                },
                success: function (result) {
                    window.globalDraftFlag = false;
                    $('.cancel-toggle').hide();
                    $('.post-thread').parent().hide();
                    $('.new-thread-toggle').parent().show();
                    $('.editor-wrapper').slideUp(function () {
                        $(this).find('.thread-editor-title').val("");
                        $('.image-preview').css('background-image', '');
                        $('.image-preview').css('background-position', '');
                        $(this).find('.editable').html("");
                        $(this).find('.duptarea').val("");
                        $(this).find('.tags').val("");
                        $(this).find('.tags').attr('data-cnt', '0');
                        $('.tag').remove();
                        $(result).insertAfter('.threadactions').fadeIn("slow");
                    });
                }
            });
        }
        else {
            $('input[name="new-thread-title"]').focus();
        }
    });
    
    /** NEW **/
    $('.mobile-file-upload-toggle').click(function(){
        $('.thread-mobile-image').click();
    });
    $('.thread-mobile-image').change(function(e){
        if(!$(this).prop('files')[0]){
            window.globalDraftFlag = false;
            return;        
        }
        var file_data = $('.thread-mobile-image').prop('files')[0];
        var form_data = new FormData();
        form_data.append('filemobile', file_data);
        $.ajax({
            url: 'request.php?KEY=uploadImageMobile',
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (result) {
                if (result === '0') {
                    alert('denied');
                }
                else {
                    window.globalDraftFlag = true;
                    $('input[name="mobile-filename"]').val(result);
                    $('.mobile-filename-span').addClass('fg-green').html('Uploaded');
                    $('.btn-remove-img-mobile').show();
                }
            }
        });
        e.preventDefault();
    });
    removeimageMobile = function () {
        $.ajax({
            url: 'request.php',
            cache: false,
            data: 'KEY=deleteImage&DATA=' + $('input[name="mobile-filename"]').val(),
            type: 'POST',
            success: function () {
                window.globalDraftFlag = false;
                $('.thread-mobile-image').val("");
                $('input[name="mobile-filename"]').val("");
                $('.mobile-filename-span').removeClass('fg-green').html('Upload Image');
                $('.btn-remove-img-mobile').hide();
            }
        });
    };

    $('.btn-remove-img-mobile').click(function () {
        removeimageMobile();
    });
    $('.post-thread-mobile').bind('click', function () {
        var mobileThreadTitle = $('.mobile-thread-title').val();
        mobileThreadTitle = regex_escape(mobileThreadTitle);
        var mobileThreadDesc = $('.mobile-thread-description').val();
        mobileThreadDesc = regex_escape(mobileThreadDesc);
        var mobileFileName = $('input[name="mobile-filename"]').val();
        var mobileThreadCategory = $('.mobile-thread-category option:selected').val();
        var mobileTags = $('.mobiletags').val();
        
        if ($.trim(mobileThreadTitle) !== "") {
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: {KEY: 'createNewThreadMobile', mobileThreadTitle: mobileThreadTitle, mobileFilename: mobileFileName, mobileThreadDesc: mobileThreadDesc, mobileThreadCategory: mobileThreadCategory, mobileTags: mobileTags},
                beforeSend: function () {
                    $(window).scrollTop(0);
                    $('.loadingstatmobile').animate({width: '100%'}, "slow");
                },
                success: function(result) {
                    window.globalDraftFlag = false;
                    $('.mobile-new-thread-container').animate({top: '-100%'},function(){
                        $('body').removeClass('offscroll');
                        $('.mobile-thread-title').val('');
                        $('.mobile-thread-description').val('');
                        $('.mobiletags').val('');
                        $('.mobiletags').attr('data-cnt','0');
                        $('.tag-mobile').remove();
                        $('.thread-mobile-image').val("");
                        $('input[name="mobile-filename"]').val("");
                        $('.mobile-filename-span').removeClass('fg-green').html('Upload Image');
                        $('.btn-remove-img-mobile').hide();
                        $(result).insertBefore('.thread:first').fadeIn("slow");
                    });
                }
            });
        }
        else {
            $('.mobile-thread-title').focus();
        }
    });
    
    //** thread options toggle **/
    $(document).on('click', '.thread-options-toggle', function () {
        $('.thread-options').fadeOut("fast");
        if ($(this).parent().find('.thread-options').css('display') === 'none')
            $(this).parent().find('.thread-options').fadeIn("fast");
        else
            $(this).parent().find('.thread-options').fadeOut("fast");
    });
    $(document).mouseup(function (e)
    {
        var container = $('.thread-options');

        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.fadeOut("fast");
        }
    });

    /** editor actions **/
    var type;
    function wrap(type)
    {
        var u = $('.question-description').val();
        var start = $('.question-description').get(0).selectionStart;
        var end = $('.question-description').get(0).selectionEnd;
        if (u.substring(start) === "") {
            switch (type) {
                case 'b':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-bold').addClass('unbold');
                    break;
                case '/b':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-bold').removeClass('unbold');
                    break;
                case 'i':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-italic').addClass('unbold');
                    break;
                case '/i':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-italic').removeClass('unbold');
                    break;
                case 'u':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-underline').addClass('unbold');
                    break;
                case '/u':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-underline').removeClass('unbold');
                    break;
                case 'blockquote':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-quote').addClass('unbold');
                    break;
                case '/blockquote':
                    $('.question-description').val([u.substring(0, start) + '<' + type + '>']);
                    $('.btn-quote').removeClass('unbold');
                    break;
            }
        }
        else if (type === 'link') {
            $('.question-description').val([u.substring(0, start) + '<a href="' + u.substring(start) + '" target="_blank">' + u.substring(start) + '</a>']);
            $('.editor-description').html($('.question-description').val());
        }
        else if (type === 'blockquote') {
            $('.question-description').val([u.substring(0, start) + '<' + type + '>' + u.substring(start) + '</' + type + '>']);
            $('.editor-description').html($('.question-description').val());
        }
        else if (type === 'code') {
            $('.question-description').val([u.substring(0, start) + '<' + type + '>' + u.substring(start) + '</' + type + '>']);
        }
        else if (type === 'b' || type === 'i' || type === 'u') {
            $('.question-description').val([u.substring(0, start) + '<' + type + '>' + u.substring(start) + '</' + type + '>']);
            $('.editor-description').html($('.question-description').val());
        }
        $('.question-description').focus();
    }
    $('.thread-editor-title').bind('input', function () {
        if($(this).val().length > 1){
            window.globalDraftFlag = true;
            if ($(this).val().length >= 100) {
                $(this).addClass('txterr');
                $(this).val($(this).val().slice(0, 100));
                return false;
            }
            else {
                $(this).removeClass('txterr');
            }
        }
        else {
            window.globalDraftFlag = false;
        }
    });
    /** NEW **/
    $('.mobile-thread-title').bind('input',function(){
        if($(this).val().length > 1){
            window.globalDraftFlag = true;
            if ($(this).val().length >= 100) {
                $(this).addClass('txterr');
                $(this).val($(this).val().slice(0, 100));
                return false;
            }
            else {
                $(this).removeClass('txterr');
            }
        }
        else {
            window.globalDraftFlag = false;
        }
    });
    $('.question-description').bind('keydown', function (e) {
        if ((e.keyCode === 66 && e.ctrlKey)) {
            if ($('.btn-bold').hasClass('unbold')) {
                wrap(regex_escape('/b'));
            }
            else {
                wrap('b');
            }
            return false;
        }
        else if ((e.keyCode === 73 && e.ctrlKey)) {
            wrap('i');
            return false;
        }
        else if ((e.keyCode === 85 && e.ctrlKey)) {
            wrap('u');
            return false;
        }
        else if ((e.keyCode === 81 && e.ctrlKey)) {
            wrap('blockquote');
            return false;
        }
        else if ((e.keyCode === 76 && e.ctrlKey)) {
            wrap('link');
            return false;
        }
        else if ((e.keyCode === 68 && e.ctrlKey)) {
            wrap('code');
        }
        else if ((e.keyCode === 13)) {
            e.preventDefault();
            $(this).val($(this).val().substring(0, this.selectionStart) + "<br />" + $(this).val().substring(this.selectionEnd));
        }
        else if ((e.keyCode === 9)) {
            e.preventDefault();
            $(this).val($(this).val().substring(0, this.selectionStart) + "<tab />" + $(this).val().substring(this.selectionEnd));
        }
    });
    $('.question-description').bind('input', function () {
        if ($('.editor-description').html().search(/^int/g))
            $('.editor-description').html($(this).val().split(/^int/g).join('<span class="typ">int</span>'));
    });
    $('.btn-group > button').bind('click', function () {
        if ($(this).hasClass('unbold')) {
            switch ($(this).attr('class')) {
                case 'btn-bold unbold':
                    wrap(regex_escape('/b'));
                    break;
                case 'btn-italic unbold':
                    wrap(regex_escape('/i'));
                    break;
                case 'btn-underline unbold':
                    wrap(regex_escape('/u'));
                    break;
                case 'btn-link':
                    wrap('link');
                    break;
                case 'btn-quote unbold':
                    wrap(regex_escape('/blockquote'));
                    break;
                case 'btn-code':
                    wrap('code');
                    break;
            }
        }
        else {
            switch ($(this).attr('class')) {
                case 'btn-bold':
                    wrap('b');
                    break;
                case 'btn-italic':
                    wrap('i');
                    break;
                case 'btn-underline':
                    wrap('u');
                    break;
                case 'btn-link':
                    wrap('link');
                    break;
                case 'btn-quote':
                    wrap('blockquote');
                    break;
                case 'btn-code':
                    wrap('code');
                    break;
            }
        }
    });

    $('.btn-help').click(function () {
        var topMargin = (window.innerHeight - 500) / 2;
        $('.editor-help-child').css('margin-top', topMargin + 'px');
        $('.editor-help-parent').fadeIn("fast", function () {
            $('.editor-help-child').fadeIn("fast", function () {
                $('body').addClass('offscroll');
            });
        });
    });
    $('.close-help').click(function () {
        $('.editor-help-parent').fadeOut("fast", function () {
            $('.slideone').css('margin-left', '');
            $('.slidetwo').css('margin-left', '');
            $('.slideone').show();
            $('.editor-help-child').css('background-image','url(\'images/cb.png\')');
            $('body').removeClass('offscroll');
        });
    });
    $('.next-help').click(function () {
        $('.editor-help-child').css('background-image','');
        $('.slideone').animate({marginLeft: '-100%'}, "slow", function () {
            $('.slidetwo').fadeIn();
        });
    });
    $('.next-help-2').click(function () {
        $('.slideone').hide();
        $('.slidetwo').animate({marginLeft: '-100%'}, "slow", function () {
            $('.slidethree').fadeIn();
        });
    });
    $('.next-help-3').click(function () {
        $('.editor-help-parent').fadeOut();
        $('.slideone').css('margin-left', '');
        $('.slidetwo').css('margin-left', '');
        $('.slideone').show();
        $('.editor-help-child').css('background-image','url(\'images/cb.png\')');
        $('body').removeClass('offscroll');
    });

    /** File Upload and Delete **/

    $('.btn-image').click(function () {
        $('.thread-image').click();
    });
    $('.thread-image').change(function (e) {
        if(!$(this).prop('files')[0]){
            window.globalDraftFlag = false;
            return;        
        }
        var file_data = $('.thread-image').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: 'request.php?KEY=uploadImage',
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            beforeSend: function () {
                $('.image-preview').find('.fa-camera').hide();
                $('.image-preview').append('<i class="fa fa-circle-o-notch uploader-icon fa-spin" style="font-size: 75px;position: absolute;left:45%;top:30%;"></i>');
            },
            complete: function () {
            },
            success: function (result) {
                if (result === '0') {
                    alert('denied');
                }
                else {
                    window.globalDraftFlag = true;
                    $('.uploader-icon').remove();
                    $('.image-preview').find('.fa-camera').show();
                    $('.image-preview').css('background-image', 'url(' + '../soapbox/' + result + ')');
                    $('.image-preview').show();
                    $('input[name="filename"]').val(result);
                }
            }
        });
        e.preventDefault();
    });
    removeimage = function () {
        $.ajax({
            url: 'request.php',
            cache: false,
            data: 'KEY=deleteImage&DATA=' + $('input[name="filename"]').val(),
            type: 'POST',
            success: function () {
                window.globalDraftFlag = false;
                $('.thread-image').val("");
                $('input[name="filename"]').val("");
                $('.image-preview').css('background-image', '');
                $('.image-preview').css('background-position', '');
                $('.image-preview').css('background-size', '');
            }
        });
    };

    $('.btn-remove-img').click(function () {
        removeimage();
    });
    $('.btn-fullscreen').click(function () {
        $('.fullscreeneditorparent').show(function () {
            $(this).animate({top: 0, left: 0, width: '100%', height: '100%', padding: '5px'}, 50);
            $('body').addClass('offscroll');
            $('.container').addClass('blur');
            $('.sidebar').addClass('blur');
        });
    });
    $('.btn-compress').click(function () {
        $('.fullscreeneditorparent').animate({top: '50%', left: '50%', height: '0px', width: '0px', padding: '0px'}, 100);
        $('body').removeClass('offscroll');
        $('.container').removeClass('blur');
        $('.sidebar').removeClass('blur');


    });
    /** help slider **/
    $('.help-next').click(function () {
        if ($(this).hasClass('help1')) {
            $('.himg0').animate({marginLeft: '-100%'}, "slow", function () {
                $('.himg0').hide();
                $('.himg1').show();
            });
            $(this).removeClass('help1').addClass('help2');
            $('.help-prev').addClass('h0');
        }
        else if ($(this).hasClass('help2')) {
            $('.himg1').animate({marginLeft: '-100%'}, "slow", function () {
                $('.himg1').hide();
                $('.himg2').show();
            });
            $(this).removeClass('help2').addClass('help3');
            $('.help-prev').addClass('h1');
        }
        else if ($(this).hasClass('help3')) {
            $('.himg2').animate({marginLeft: '-100%'}, "slow", function () {
                $('.himg2').hide();
                $('.himg3').show();
            });
            $(this).removeClass('help3').addClass('help4');
            $('.help-prev').addClass('h2');
        }
        else if ($(this).hasClass('help4')) {
            $('.himg3').animate({marginLeft: '-100%'}, "slow", function () {
                $('.himg3').hide();
                $('.himg0').css('margin-left', '0px');
                $('.himg0').show();
            });
            $(this).removeClass('help4').addClass('help1');
            $('.help-prev').addClass('h3');
        }
    });

    /** tags **/
    function addtags(tag, where) {
        if (where === 'desktop-enter') {
            var value = $('.tags').val();
            var cnt = $('.tags').attr('data-cnt');
            if (cnt !== '5') {
                if (value !== "") {
                    var array = $('.tags').val().split(",");
                    if ($.inArray(tag, array) === -1) {
                        $('<div class="tag" id="tag-' + tag + '">' + tag + '</div>').insertBefore($('.tag-enter-txt'));
                        $('.tags').attr('data-cnt', cnt);
                        $('.tags').val(value + ',' + tag);
                        $('.tag-enter-txt').focus();
                        $('.tag-enter-txt').val('');
                        cnt++;
                        $('.tags').attr('data-cnt', cnt);
                    }
                    else {
                        //
                    }
                }
                else {
                    $('<div class="tag" id="tag-' + tag + '">' + tag + '</div>').insertBefore($('.tag-enter-txt'));
                    $('.tags').val(tag);
                    $('.tag-enter-txt').focus();
                    $('.tag-enter-txt').val('');
                    cnt++;
                    $('.tags').attr('data-cnt', cnt);
                }
            }
            else
                $('.tag-enter-txt').val('');
        }
        else if (where === 'mobile-enter') {
            var value = $('.mobiletags').val();
            var cnt = $('.mobiletags').attr('data-cnt');
            if (cnt !== '5') {
                if (value !== "") {
                    var array = $('.mobiletags').val().split(",");
                    if ($.inArray(tag, array) === -1) {
                        $('<div class="tag-mobile" id="tag-' + tag + '">' + tag + '</div>').insertBefore($('.mobile-tag-enter-txt'));
                        $('.mobiletags').attr('data-cnt', cnt);
                        $('.mobiletags').val(value + ',' + tag);
                        $('.mobile-tag-enter-txt').focus();
                        $('.mobile-tag-enter-txt').val('');
                        cnt++;
                        $('.mobiletags').attr('data-cnt', cnt);
                    }
                    else {
                        //
                    }
                }
                else {
                    $('<div class="tag-mobile" id="tag-' + tag + '">' + tag + '</div>').insertBefore($('.mobile-tag-enter-txt'));
                    $('.mobiletags').val(tag);
                    $('.mobile-tag-enter-txt').focus();
                    $('.mobile-tag-enter-txt').val('');
                    cnt++;
                    $('.mobiletags').attr('data-cnt', cnt);
                }
            }
            else
                $('.mobile-tag-enter-txt').val('');
        }
    }
    function regex_escape(str) {
        return str.replace(new RegExp('[.\\\\+*?\\[\\^\\]$(){}=!<>|:;\\-\']', 'g'), '\\$&');
    }
    /** NEW **/
    $('.tag-enter-txt').bind('input',function(){
        $(this).val($(this).val().replace(/\s/g, '')); 
    });
    $('.mobile-tag-enter-txt').bind('input',function(){
        $(this).val($(this).val().replace(/\s/g, '')); 
    });
    
    $('.tag-enter-txt').bind('keydown', function (e) {
        if (e.keyCode === 13) {
            if ($(this).val() !== "") {
                addtags($(this).val(), 'desktop-enter');
            }
            return false;
        }
        if (e.keyCode === 8 && $(this).val() === "") {
            var array = $('.tags').val().split(",");
            var cnt = $('.tags').attr('data-cnt');
            var newstr = "";
            $('.tag-enter-parent').find('#tag-' + regex_escape(array[array.length - 1])).remove();
            for (var i = 0; i < array.length - 1; i++) {
                if (i === 0) {
                    newstr = newstr + array[i];
                }
                else {
                    newstr = newstr + "," + array[i];
                }
            }
            cnt--;
            $('.tags').attr('data-cnt', cnt);
            $('.tags').val(newstr);
            return false;
        }
    });
    $('.mobile-tag-enter-txt').bind('keydown', function (e) {
        if (e.keyCode === 13) {
            if ($(this).val() !== "") {
                addtags($(this).val(), 'mobile-enter');
            }
            return false;
        }
        if (e.keyCode === 8 && $(this).val() === "") {
            var array = $('.mobiletags').val().split(",");
            var cnt = $('.mobiletags').attr('data-cnt');
            var newstr = "";
            $('.mobile-tag-enter-parent').find('#tag-' + regex_escape(array[array.length - 1])).remove();
            for (var i = 0; i < array.length - 1; i++) {
                if (i === 0) {
                    newstr = newstr + array[i];
                }
                else {
                    newstr = newstr + "," + array[i];
                }
            }
            cnt--;
            $('.mobiletags').attr('data-cnt', cnt);
            $('.mobiletags').val(newstr);
            return false;
        }
    });

    $(".image-preview").on('mousedown mouseup', function (e) {

        //declare some vars
        var start = {x: 0, y: 0};
        var move = {x: 0, y: 0};
        var id = $(this).attr('id');

        //pointer coordinates on mousedown
        var origin = {x: 0, y: 0};

        //container dimensions
        var container = {w: $(this).width(), h: $(this).height()};

        //container ratio
        var containerRatio = container.h / container.w;

        //background image dimensions, note: this gets dimensions of unscaled image
        var img = new Image;
        img.src = $(this).css('background-image').replace(/url\(|\)$/ig, "");
        var background = {w: img.width, h: img.height};

        //background ratio
        var backgroundRatio = background.h / background.w;

        //max x and y position, aka boundary
        var min = {x: 0, y: 0};
        var max = {x: 0, y: 0};

        //move x
        if (backgroundRatio < containerRatio) {
            min.y = 0;
            min.x = -((container.h * (1 / backgroundRatio)) - container.w);
        }

        //move y
        else if (backgroundRatio > containerRatio) {
            min.x = 0;
            min.y = -((container.w * backgroundRatio) - container.h);
        }

        //ratios are equal, don't move anything
        else {
            min.x = 0;
            min.y = 0;
        }

        //activate
        if (e.type == 'mousedown') {

            //add border so it's easier to visualize
            $(this).css('border', '1px solid #1ba1e2');

            //get current position of mouse pointer
            origin.x = e.clientX;
            origin.y = e.clientY;

            //get current background image starting position
            var temp = $(this).css('background-position').split(" ");
            start.x = parseInt(temp[0]);
            start.y = parseInt(temp[1]);

            //mouse is dragged while mousedown
            $(this).mousemove(function (e) {

                //move position
                move.x = start.x + (e.clientX - origin.x);
                move.y = start.y + (e.clientY - origin.y);

                //if it's in the bounds, move it
                if (move.x <= max.x && move.x >= min.x && move.y <= max.y && move.y >= min.y) {

                    //alter css
                    $(this).css('background-position', move.x + 'px ' + move.y + 'px');

                    //update input
                    $("#" + id).val('x:' + move.x + ', y:' + move.y);
                }

                //in x bound,
                else if (move.x <= max.x && move.x >= min.x) {

                    //below min.y
                    if (move.y < min.y) {
                        $(this).css('background-position', move.x + 'px ' + min.y + 'px');

                        //update input
                        $("#" + id).val('x:' + move.x + ', y:' + min.y);
                    }
                    //above max.y
                    else if (move.y > max.y) {
                        $(this).css('background-position', move.x + 'px ' + max.y + 'px');

                        //update input
                        $("#" + id).val('x:' + move.x + ', y:' + max.y);
                    }
                }

                //in y bound
                else if (move.y <= max.y && move.y >= min.y) {

                    console.log('y');

                    //below min.x
                    if (move.x < min.x) {
                        $(this).css('background-position', min.x + 'px ' + move.y + 'px');

                        //update input
                        $("#" + id).val('x:' + min.x + ', y:' + move.y);
                    }

                    //above max.x
                    else if (move.x > max.x) {
                        $(this).css('background-position', max.x + 'px ' + move.y + 'px');

                        //update input
                        $("#" + id).val('x:' + max.x + ', y:' + move.y);
                    }
                }

                //out of both bounds
                else {
                    console.log('problem');
                }
            });
        }

        //deactivate
        else {

            //remove border
            $(this).css('border', '1px solid transparent');

            //remove mousemove
            $(this).off('mousemove');
            $(document.body).focus();
        }

    });
    hideThread = function (thread, username, ele) {
        var r = confirm("Are you sure you want to hide this thread?");
        if (r === true) {
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: 'KEY=hideThread&thread=' + thread + '&username=' + username,
                success: function (result) {
                    if (result === 'fail') {
                        alert('Something went wrong. Please try again.');
                        return;
                    }
                    $(ele).closest('.thread').attr('id', 'hdn' + thread);
                    $(ele).closest('.thread').fadeOut(function () {
                        $('<div class="pure-u-1 bg-white block-flat unhide-thread-box" style="margin: 0 0 20px 0;padding: 10px;">\n\
                    <p class="margin0">Your thread has been hidden. Do you want to unhide it ? <button onclick="unhideThread(\'' + thread + '\',\'' + $('.hdnuname').val() + '\',this);" class="flt-right btn-general bg-white fg-lightBlue">UNHIDE</button> <button onclick="$(this).parent().parent().remove();" class="flt-right btn-general bg-white fg-gray">IGNORE</button></p>\n\
                    </div>').insertBefore($(ele).closest('.thread'));
                    });
                }
            });
        } else {
            return;
        }
    };   
    $('.load-more-post').bind('click', function(){
        $.ajax({
           url:'request.php',
           type:'POST',
           cache: 'false',
           data:'KEY=loadMorePosts&t=' + $('#hdnT').val(),
           beforeSend : function(){
               $('.load-more-post').html('<i class="fa fa-circle-o-notch fa-spin fg-black"></i>');
           },
           success : function(result){
               if(result==='0') {
                   $('<div class="full-span" style="padding-bottom: 20px;"><h3 class="txt-center light">That\'s all we could find :)</h3></div>').insertAfter('.thread:last').fadeIn();
                   $('.load-more-post').parent().parent().remove();
               }
               else{
                   $(result).insertAfter('.thread:last').fadeIn("slow");
                   $('.load-more-post').html('LOAD MORE POSTS');
               }
           }
        });
    });
   
    $(document).on('mouseover','.thread',function(){
            $(this).find('.featured-thumbnail, .thread-owner-thumb').addClass('enhanced-image');
            $(this).find('.thread-title > p').addClass('enhanced-title');
    });
    $(document).on('mouseout','.thread',function(){
            $(this).find('.featured-thumbnail, .thread-owner-thumb').removeClass('enhanced-image');
            $(this).find('.thread-title > p').removeClass('enhanced-title');
    });
    
    var h = window.innerHeight - 70;
    $('.right-pane').css('height',h +'px');
    
    readingList = function(thread, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=readingList&thread=' + thread + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }                
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-check"></i> Added to reading list</a>').addClass('bg-green fg-white');
            }
        });        
    };
    trackThread = function(thread, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=trackThread&thread=' + thread + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }                
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-check"></i> Tracking this thread</a>').addClass('bg-green fg-white');
            }
        });        
    }; 
    deleteThread = function(thread, username, ele){
        var r = confirm("Are you sure you want to delete this thread?");
        if(r===true){
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: 'KEY=deleteThread&thread=' + thread + '&username=' + username,
                success: function (result) {
                    if (result === 'fail') {
                        alert('Something went wrong. Please try again.');
                        return;
                    }
                    $(ele).closest('.thread').remove();
                }
            });        
        }
        else{
            
        }
    };    
    rmReadingList = function(thread, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=rmReadingList&thread=' + thread + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }                
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-book"></i> Add To Reading List</a>').removeClass('bg-green fg-white');
            }
        });        
    };
    rmTrackThread = function(thread, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=rmTrackThread&thread=' + thread + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-binoculars fa-fw"></i> Track This Thread</a>').removeClass('bg-green fg-white');
            }
        });        
    };
    
    unhideThread = function(thread,username,ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=unhideThread&thread=' + thread + '&username=' + username,
            success: function(result){
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return; 
                }
                $('#hdn'+ thread).fadeIn();
                $(ele).parent().parent().remove();
            }
        });
    };
   $('.load-more-post-tag').bind('click', function(){
       var tag = $(this).attr('data-tag');
        $.ajax({
           url:'request.php',
           type:'POST',
           cache: 'false',
           data:'KEY=loadMorePostsTag&t=' + $('#hdnT').val() + '&tag=' + tag,
           beforeSend : function(){
               $('.load-more-post-tag').html('<i class="fa fa-circle-o-notch fa-spin fg-black"></i>');
           },
           success : function(result){
               if(result==='0') {
                   $('<div class="full-span" style="padding-bottom: 20px;"><h3 class="txt-center light">That\'s all we could find :)</h3></div>').insertAfter('.thread:last').fadeIn();
                   $('.load-more-post-tag').parent().parent().remove();
               }
               else{
                   $(result).insertAfter('.thread:last').fadeIn("slow");
                   $('.load-more-post-tag').html('LOAD MORE POSTS');
               }
           }
        });
    }); 
$('.load-more-post-mythreads').bind('click', function(){
        $.ajax({
           url:'request.php',
           type:'POST',
           cache: 'false',
           data:'KEY=loadMorePostsMyThreads&t=' + $('#hdnT').val(),
           beforeSend : function(){
               $('.load-more-post-mythreads').html('<i class="fa fa-circle-o-notch fa-spin fg-black"></i>');
           },
           success : function(result){
               if(result==='0') {
                   $('<div class="full-span" style="padding-bottom: 20px;"><h3 class="txt-center light">That\'s all we could find :)</h3></div>').insertAfter('.thread:last').fadeIn();
                   $('.load-more-post-mythreads').parent().parent().remove();
               }
               else{
                   $(result).insertAfter('.thread:last').fadeIn("slow");
                   $('.load-more-post-mythreads').html('LOAD MORE POSTS');
               }
           }
        });
    });    
});