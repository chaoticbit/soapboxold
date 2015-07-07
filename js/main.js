window.onload = function(){
    $('.search').val('');
};
$(document).ready(function () {
    $('body').attr('ondragstart', 'return false');
    $('body').attr('draggable', 'false');
    $('body').attr('ondragenter', 'event.dataTransfer.dropEffect=\'none\'; event.stopPropagation(); event.preventDefault();');
    $('body').attr('ondragenter', '');
    $('body').attr('ondragover', 'event.dataTransfer.dropEffect=\'none\';event.stopPropagation(); event.preventDefault();');
    $('body').attr('ondrop', 'event.dataTransfer.dropEffect=\'none\';event.stopPropagation(); event.preventDefault();');
    
    if (screen.width < 480) {
        $('body').append('<script src="js/jquery.mobile-1.4.5.min.js" type="text/javascript"> </script>');
//        $('.thread-container, .profile-container').on('swiperight', function () {
//            $('.sidebar').wrap('<div class="sidebar-mobile-parent" />');
//            $('.sidebar').animate({left: '0px'}, 500);
//        });
        $('body').on('swipeleft', function () {
            $('.sidebar').unwrap('<div class="sidebar-mobile-parent" />');
            $('.sidebar').animate({left: '-250px'}, 500, function () {
                
            });
        });
    }
    $('.toggle-notify').click(function () {
        if($('.notifications-popover').css('display')==='none'){
            $('.notifications-popover').fadeIn(function(){
//                $('.bubble').hide();
//                $('.popover-content > ul > li.grayLighter').removeClass('grayLighter');
            });
        }
        else{
            $('.notifications-popover').fadeOut();
        }
    });    
    
    $(document).mouseup(function (e)
    {
        var container = $('.notifications-popover');

        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.fadeOut("fast");
        }
    });
    checkScroll = function () {
        var fromTopPx = 0;
        var scrolledFromtop = $(window).scrollTop();
        if (scrolledFromtop > fromTopPx) {
            $('.headbar').addClass('scrolled');
        } else {
            $('.headbar').removeClass('scrolled');
        }
    };
    $(window).scroll(function () {
        checkScroll();
    });
    
    /** toggle sidebar **/
    $('.toggle-stack').click(function () {
        //$('.sidebar').wrap('<div class="sidebar-mobile-parent" />');
        $('.sidebar').animate({left: '0px'}, 500);
    });    
    
    /** Search bar desktop and mobile and controls **/
    function searchAll(str, c) {
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=searchAll&DATA=' + str + '&C=' + c,
            beforeSend: function () {
                //$('.inner-search-container').html('<i class="fa fa-circle-o-notch search-result-icon fa-4x fa-spin" style="margin: 20% 43%;"></i>');
            },
            success: function (result) {
                //$('.search-result-icon').remove();
                $('.inner-search-container').html(result);
            }
        });
    }
    function searchUsers(str) {
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=searchUsers&DATA=' + str,
            beforeSend: function () {
                //$('.inner-search-container').html('<i class="fa fa-circle-o-notch search-result-icon fa-4x fa-spin" style="margin: 20% 43%;"></i>');
            },
            success: function (result) {
                //$('.search-result-icon').remove();
                $('.inner-search-container').html(result);
            }
        });
    }
    function searchTags(str) {
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=searchTags&DATA=' + str,
            beforeSend: function () {
                //$('.inner-search-container').html('<i class="fa fa-circle-o-notch search-result-icon fa-4x fa-spin" style="margin: 20% 43%;"></i>');
            },
            success: function (result) {
                //$('.search-result-icon').remove();
                $('.inner-search-container').html(result);
            }
        });
    }
    /** NEW **/
    searchMobile = function (str) {
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=searchMobile&DATA=' + str,
            success: function (result) {
                $('.search-container-mobile').html(result);
            }
        });
    };
    $('.search-category').change(function () {
        var x = $('.search').val();
        if (x.charAt(0) !== '>' && x.charAt(0) !== '<') {
            searchAll($('.search').val().toLowerCase(), $(this).val());
            $('.search').focus();
        }
    });
    /** Search bar desktop and mobile and controls **/
    $('.search').bind('keydown', function (e) {
        var $listItems = $('li.thread-search-li');
        var key = e.keyCode,
                $selected = $listItems.filter('.selected'),
                $current;
        if (key !== 40 && key !== 38 && key !== 13 && key !== 8)
            return;
        $listItems.removeClass('selected');
        if (key === 40) {
            if (!$selected.length || $selected.is(':last-child')) {
                $current = $listItems.eq(0);
            }
            else
                $current = $selected.next();
        }
        else if (key === 38) {
            if (!$selected.length || $selected.is(':first-child')) {
                $current = $listItems.last();
            }
            else
                $current = $selected.prev();
        }
        else if (key === 13) {            
            var link = $('.thread-search-li').find('a').attr('href');
            if(link===null){
                return;
            }
            else{
                window.location = link.attr('href');
            }
        }
        else if (e.keyCode === 8 && $(this).val() === "") {
            $('.search-container').hide();
            $(this).parent().removeAttr('style');
            $('body').removeClass('offscroll');
            $('.thread-container, .profile-container, .readinglist-container').removeClass('blur');
            checkScroll();
            $('.inner-search-container').html('');
        }
        $current.addClass('selected');
    });

    $('.search').bind('input', function () {
        if ($(this).val() === "") {
            $('.inner-search-container').html('');
        }
        else {
            $('.search-container').show();
            $('body').addClass('offscroll');
            $(this).parent().removeClass('scrolled');
            $(this).parent().css('background', 'rgba(0,0,0,0.99)');
            $(this).parent().css('border-bottom-color', 'rgba(0,0,0,0.9)');
            $('.thread-container, .profile-container, .readinglist-container').addClass('blur');
            $(this).parent().css('color', '#fff');
            switch ($('input[name="search-option"]').val()) {
                case '2': /** search all **/
                    var x = $(this).val();
                    if (x.charAt(0) !== '>' && x.charAt(0) !== '<') {
                        searchAll($(this).val().toLowerCase(), $('.search-category').val());
                    }
                    break;
                case '1': /** search user **/
                    var x = $(this).val();
                    if (x.charAt(0) !== '>' && x.charAt(0) !== '<') {
                        searchUsers($(this).val().toLowerCase());
                    }
                    break;
                case '0': /** search tags **/
                    var x = $(this).val();
                    if (x.charAt(0) !== '>' && x.charAt(0) !== '<') {
                        searchTags($(this).val().toLowerCase());
                    }
                    break;
            }
        }
    });

    $('.search-switch > small').click(function () {
        if ($(this).parent().hasClass('search-all uncheck-search-switch')) {
            $('input[name="search-option"]').val('2');
            $(this).animate({left: '26px'}, "fast", function () {
                $('.search-all').removeClass('uncheck-search-switch');
                $('.search-user').addClass('uncheck-search-switch');
                $('.search-tags').addClass('uncheck-search-switch');
                $('.search-user > small').animate({left: '0px'});
                $('.search-tags > small').animate({left: '0px'});
                searchAll($('.search').val().toLowerCase(), $('.search-category').val());
                $('.search-category').attr('disabled', false);
                $('.search').focus();
            });
        }
        else if ($(this).parent().hasClass('search-user uncheck-search-switch')) {
            $('input[name="search-option"]').val('1');
            $(this).animate({left: '26px'}, "fast", function () {
                $('.search-user').removeClass('uncheck-search-switch');
                $('.search-all').addClass('uncheck-search-switch');
                $('.search-tags').addClass('uncheck-search-switch');
                $('.search-all > small').animate({left: '0px'});
                $('.search-tags > small').animate({left: '0px'});
                searchUsers($('.search').val().toLowerCase());
                $('.search-category').attr('disabled', true);
                $('.search').focus();
            });
        }
        else if ($(this).parent().hasClass('search-user')) {
            $('input[name="search-option"]').val('2');
            $(this).animate({left: '0px'}, "fast", function () {
                $('.search-user').addClass('uncheck-search-switch');
                $('.search-tags').addClass('uncheck-search-switch');
                $('.search-all').removeClass('uncheck-search-switch');
                $('.search-all > small').animate({left: '26px'});
                searchAll($('.search').val().toLowerCase(), $('.search-category').val());
                $('.search-category').attr('disabled', false);
                $('.search').focus();
            });
        }
        else if ($(this).parent().hasClass('search-tags uncheck-search-switch')) {
            $('input[name="search-option"]').val('0');
            $(this).animate({left: '26px'}, "fast", function () {
                $('.search-tags').removeClass('uncheck-search-switch');
                $('.search-all').addClass('uncheck-search-switch');
                $('.search-user').addClass('uncheck-search-switch');
                $('.search-all > small').animate({left: '0px'});
                $('.search-user > small').animate({left: '0px'});
                searchTags($('.search').val().toLowerCase());
                $('.search-category').attr('disabled', true);
                $('.search').focus();
            });
        }
        else if ($(this).parent().hasClass('search-tags')) {
            $('input[name="search-option"]').val('2');
            $(this).animate({left: '0px'}, "fast", function () {
                $('.search-user').addClass('uncheck-search-switch');
                $('.search-tags').addClass('uncheck-search-switch');
                $('.search-all').removeClass('uncheck-search-switch');
                $('.search-all > small').animate({left: '26px'});
                searchAll($('.search').val().toLowerCase(), $('.search-category').val());
                $('.search-category').attr('disabled', false);
                $('.search').focus();
            });
        }
    });
    /** NEW **/
    $('.search-mobile').bind('focusin', function () {
        $('.toggle-stack').hide();
        $('.toggle-new-question').hide();
        $('.search-container-mobile').show();
        $(this).css('width', '84%');
        $('.toggle-cancel-search').show();
        $('body').addClass('offscroll');
    });
    $('.search-mobile').bind('input', function () {
        if ($(this).val() === "") {
            $('.search-container-mobile').html('');
            $('.cancel-text').hide();
        }
        else {
            $('.cancel-text').show();
            var x = $(this).val();
            if (x.charAt(0) !== '>' && x.charAt(0) !== '<') {
                searchMobile($(this).val().toLowerCase());
            }
        }
    });
    $('.cancel-text').click(function () {
        $('.search-mobile').val('');
        $(this).hide();
        $('.search-mobile').focus();
    });
    $('.toggle-cancel-search').bind('click', function () {
        $('.search-mobile').val('');
        $('.toggle-cancel-search').hide(100);
        $('.search-container-mobile').hide();
        $('.cancel-text').hide();
        $('.toggle-stack').show();
        $('.search-mobile').removeAttr('style');
        $('.toggle-new-question').show();
        $('.search-container-mobile').html('');
    });        
//    InitBeeper = function(){
//        $.ajax({
//           url: 'request.php',
//           type: 'GET',
//           cache: false,
//           async: true,
//           data: 'KEY=InitBeeper',
//           dataType: 'json',
//           success: function(result){
//               $.each(result, function(key, val) {
//                    var desc = val.text;
//                    var uid = val.uid;
//                    if(desc!==""){
//                    $('body').find('.beeper-wrapper > ul').append('\n\
//                        <li class="beeper" id="'+key+'"><a href="javascript:;">\n\
//                        <i class="beeper-close fa fa-times"></i>\n\
//                        <div class="thumb-beeper-pic generic-pic flt-left bg-white" style="background-image: url(\'images/avatar_male.png\')"></div>\n\
//                        <div class="beeper-desc flt-left"><p class="margin0 txt-left">'+desc+'</p></div>\n\
//                        </a></li>');
//                    $('.beeper-wrapper').fadeIn("slow");
//                    }
//               });  
//               document.getElementById("beep").play();
//           }
//        });
//    };    
function waitForNotification (){
        var t;
        $.ajax({
           url: 'request.php',
           type: 'GET',
           data: 'KEY=waitForNotification',
           dataType: 'json',
           success: function(result){
               clearInterval(t);
               $.each(result, function(key, val) {
                    var desc = val.text;
                    var uid = val.uid;
                    var cnt = val.cnt;
                    var type = val.type;
                    var avatar = val.avatar;
                    var link = val.link;                        
                    if(desc!==""){
                        if(screen.width < 480){
                            $('body').find('.beeper-wrapper > ul').append('\n\
                            <li class="beeper bid_'+key+'" id="beeper_'+key+'" style="display:none;"><a href="'+link+'" rel="external">\n\
                            <i class="beeper-close fa fa-times"></i>\n\
                            <div class="thumb-beeper-pic generic-pic flt-left bg-white" style="background-image: url('+avatar+')"></div>\n\
                            <div class="beeper-desc flt-left"><p class="margin0 txt-left">'+desc+'</p></div>\n\
                            </a></li>');
                            var w = $('.container').width();
                            $('.beeper-wrapper > ul > li.beeper > a').css('width',w +'px');
                            $('.bid_'+key).slideDown();
                            $('.bid_'+key).delay(3500).slideUp(function(){$(this).remove();});
                            document.getElementById("beep").play();
                            if($('body').find('.mobile-bubble').css('display') === "none") {
                                $('body').find('.mobile-bubble').html(cnt).fadeIn();
                            }
                            else {
                                var cnt1 = $('body').find('.mobile-bubble').html();
                                cnt1 = parseInt(cnt1);
                                var total = cnt + cnt1;
                                $('body').find('.mobile-bubble').html(total);
                            }
                        }
                        else{
                            $('body').find('.beeper-wrapper > ul').append('\n\
                            <li class="beeper bid_'+key+'" id="beeper_'+key+'"><a href="'+link+'" rel="external">\n\
                            <i class="beeper-close fa fa-times"></i>\n\
                            <div class="thumb-beeper-pic generic-pic flt-left bg-white" style="background-image: url('+avatar+')"></div>\n\
                            <div class="beeper-desc flt-left"><p class="margin0 txt-left">'+desc+'</p></div>\n\
                            </a></li>');
                            $('.bid_'+key).delay(3500).fadeOut(function(){$(this).remove();});
                            document.getElementById("beep").play();
                            $('body').find('.notify-null').remove();
                            $('body').find('#popovercontent_'+uid+' > ul').prepend('<li id="'+key+'" class="bg-grayLighter"><a href="'+link+'"><div class="pure-u-1-6"><div class="thumb-beeper-pic generic-pic" style="background-image: url(' + avatar + ');"></div></div><div class="pure-u-19-24" style="display: -webkit-inline-box;padding: 10px;">'+desc+'</div></a></li>');
                            if($('body').find('.bubble').css('display') === "none") {
                                $('body').find('.bubble').html(cnt).fadeIn();
                            }
                            else {
                                var cnt1 = $('body').find('.bubble').html();
                                cnt1 = parseInt(cnt1);
                                var total = cnt + cnt1;
                                $('body').find('.bubble').html(total);
                            }
                        }
                        document.title = "(" + cnt + ") New Notification";
                    }
                    $.ajax({
                        url: 'request.php',
                        type: 'POST',
                        data: 'KEY=resetNotification'
                    });
//                    t = setInterval(function(){waitForNotification();},1000);
               });
               t = setTimeout(function(){
                        waitForNotification();
                    },1000);
           }
        });
    };
    waitForNotification();
    
    $(document).on('click','.readAll',function(){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            data: 'KEY=readAll',
            success: function(result){
                $('#popovercontent_'+result+' > ul > li').css('background','#fff');
                $('.bubble').html('0');
                $('.bubble').fadeOut();
            }
        });
    });
});