$(document).ready(function () {
    if(window.location.hash){
        var r = window.location.hash;
        $('html,body').animate({scrollTop: $(r).offset().top},1300,function(){
            $(r).addClass('highlight-bg').delay(700).queue(function(){$(r).removeClass('highlight-bg')}).dequeue();
        });
    }
    $(document).on('click','.options-toggle',function(){
        $(this).closest('.pure-u-1').find('.thread-options').toggle();
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
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-check fg-green"></i> <span class="hidden-for-mobile">Added To Reading List</span></a>');
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
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-check fg-green"></i> <span class="hidden-for-mobile">Tracking this thread</span></a>');
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
                    window.location="index.php";
                }
            });        
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
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-book"></i> <span class="hidden-for-mobile">Add to reading list</span></a>');
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
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-binoculars fa-fw"></i> <span class="hidden-for-mobile">Track this thread</span></a>');
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
    upvote = function(thread, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=upvote&thread=' + thread + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }                
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-heart fg-red"></i> <span class="hidden-for-mobile">You upvoted</span></a>');
            }
        });        
    }; 
    rmUpvote = function(thread, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=rmUpvote&thread=' + thread + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }              
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-fw fa-heart-o"></i> <span class="hidden-for-mobile">Upvote this thread</span></a>');
            }
        });        
    };
    function regex_escape(str) {
        return str.replace(new RegExp('[.\\\\+*?\\[\\^\\]$(){}=!<>|:;\\-\']', 'g'), '\\$&');
    }
    
    /** REPLY ACTIONS **/
    
    $('.btn-submit-reply').bind('click', function(){
        if($.trim($('.editable').text())===""){
            return;
        }
        var ele = $(this);
        $(ele).attr('disabled','disabled');
        var replyDesc = $('.duptarea').val();
        replyDesc = regex_escape(replyDesc);
        var tid = $('.duptarea').attr('data-id');
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: false,
            data: {KEY: 'replyThread', tid: tid, replyDesc: replyDesc},
            beforeSend : function(){},
            success: function(result){
                $('.duptarea').val('');
                $('.editable').html('');
                $('.noreplybox').remove();
                $(ele).removeAttr('disabled');
                if(result==="fail"){
                    alert('Something went wrong.');
                    return;
                }
                if($('.reply').length === 0){
                    $(result).insertAfter('.new-reply');
                }
                else{
                    $(result).insertBefore('.reply:first');
                }
            }
        });
    });  
    markCorrect = function(rid, tid, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=markCorrect&rid=' + rid + '&tid=' + tid + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }                
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-check-circle fa-fw fa-2x fg-green pointer"></i><br/></a><small>Correct</small>');
            }
        });        
    }; 
    rmMarkCorrect = function(rid, tid, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=rmMarkCorrect&rid=' + rid + '&tid=' + tid + '&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }                
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+result+'><i class="fa fa-check-circle fa-fw fa-2x fg-grayLight pointer"></i><br/></a><small>Correct</small>');
            }
        });        
    }; 
    deleteReply = function(rid, username, ele){
        var r = confirm("Are you sure you want to delete this reply?");
        if(r===true){
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: 'KEY=deleteReply&rid=' + rid + '&username=' + username,
                success: function (result) {
                    if(result==='fail'){
                        alert('Something went wrong. Please try again.');
                        return;
                    }
                    $(ele).removeAttr('onclick');
                    if(result==="success"){
                        $(ele).closest('.reply').remove();
                    }
                }
            });
        }
    }; 
    upvoteToReply = function(rid, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=upvoteToReply&rid='+rid+'&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }
                var event = result.split('*')[0];
                var count = result.split('*')[1];
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+event+'><i class="fa fa-fw fa-heart fg-red fa-2x"></i></a><br/><small>'+count+'</small>');
            }
        });        
    }; 
    rmUpvoteToReply = function(rid, username, ele){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=rmUpvoteToReply&rid='+rid+'&username=' + username,
            success: function (result) {
                if(result==='fail'){
                    alert('Something went wrong. Please try again.');
                    return;
                }
                var event = result.split('*')[0];
                var count = result.split('*')[1];
                $(ele).removeAttr('onclick');
                $(ele).parent().html('<a href="javascript:;" '+event+'><i class="fa fa-fw fa-heart fg-grayLight fa-2x"></i></a><br/><small>'+count+'</small>');
            }
        });        
    }; 
    rmReplyToReply = function(rrid, username, ele){
        var r = confirm("Are you sure you want to delete this reply?");
        if(r===true){        
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: 'KEY=rmReplyToReply&rrid=' + rrid + '&username=' + username,
                success: function (result) {
                    if(result==='fail'){
                        alert('Something went wrong. Please try again.');
                        return;
                    }
                    if(result==="success"){
                        $(ele).closest('.r2r').remove();
                    }
                }
            });
        }       
    };
    
    addComment = function(rid, ele, e){
        if(e.keyCode === 13){
            var comment = $(ele).val();
            if($.trim(comment)==="")
                return;
            $(ele).attr('disabled','disabled');
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: false,
                data: 'KEY=replyToReply&comment=' + comment + '&rid=' + rid,
                success: function(result){
                    $(ele).val('');
                    $(ele).removeAttr('disabled');
                    if((($(ele).closest('.reply').find('.reply-replies > .pure-g')).length)===0){
                        ($(ele).closest('.reply').find('.reply-replies')).append(result);
                    }
                    else{
                        $(result).insertBefore($(ele).closest('.reply').find('.reply-replies > .pure-g:first'));
                    }
                }
            });
        }
    };
    var coordinates;
        loadEditThread = function(tid,username) {
            $.ajax({
                url: 'request.php',
                type: 'POST',
                cache: 'false',
                data: 'KEY=loadEditThread&tid='+tid+'&username=' + username,
                success: function (result) {
                    if(result==='fail'){
                        alert('Something went wrong. Please try again.');
                        return;
                    }
                    else{                       
                        //$('body').addClass('offscroll');
                        var title,desc,event;
                        coordinates = $('.featured-thumbnail').css('background-position');
                        title = result.split("$$")[0];
                        desc = result.split("$$")[1];
                        event = result.split("$$")[2];
                        $('.thread-title > h4').hide();
                        $('.thread-title').append('<input type="text" class="txt-general margin0 thread-editor-title" value="' + title + '" />');
                        $('.thread-desc-inner').hide();
                        $('.thread-description').append('<div class="editThreadWrap"><div class="editable edit-thread-editable" id="edit-thread-editable">' + desc + '</div>\n\
                        <textarea class="edit-duptarea" id="edit-duptarea" style="display:none;"></textarea>\n\
                        <div class="pure-u-1">\n\
                        <button class="btn-general bg-gray btn-cancel-edit fg-white flt-right">CANCEL</button>\n\
                        <button class="btn-general bg-cyan btn-save-edit fg-white flt-right" onclick="' + event + '">SAVE</button>\n\
                        </div></div>');
                        new MediumEditor('.editable', {
                            buttonLabels: 'fontawesome',
                            buttons: ['bold', 'italic', 'underline', 'quote', 'anchor', 'pre', 'indent', 'unorderedlist'],
                            disablePlaceholders: true,
                            targetBlank: true,
                            externalInteraction: true,
                            imageDragging: false,
                            cleanPastedHTML: false
                        });
                        $('.featured-thumbnail').addClass('active-reposition');
                        $('.thread-options').hide();
                        $('.thread').addClass('active-edit');
                        $('.edit-thread-editable').focus();
                        editReposition();
                    }
                }
            });     
    };
    $('.thread-editor-title').bind('input', function () {
        if ($(this).val().length >= 100) {
            $(this).addClass('txterr');
            $(this).val($(this).val().slice(0, 100));
            return false;
        }
        else {
            $(this).removeClass('txterr');
        }
    });
    editThread = function(tid,username) {
            var tid = tid;
            var threadTitle = $('.thread-editor-title').val();
            threadTitle = regex_escape(threadTitle);
            var threadDesc = $('.edit-duptarea').val();
            threadDesc = regex_escape(threadDesc);
            var coordinates = $('.active-reposition').css('background-position');
            var username = username;
            $.ajax({
               url: 'request.php',
               type: 'POST',
               cache: false,
               data: {KEY:'editThread',tid:tid,username:username,threadTitle: threadTitle,threadDesc:threadDesc,coordinates: coordinates},
               beforeSend : function(){
                   $('.edit-thread').css('opacity','0.7');
                   $('.edit-thread').append('<i class="fa fa-2x fa-circle-o-notch editNotch fa-spin fg-black" style="top:25%;left:50%;position:absolute;-webkit-transform:translate(-50%,-50%);"></i>');
               },
               success: function(result) {
                   if(result==='fail'){
                        alert('Something went wrong. Please try again.');
                        return;
                   }
                   else{
                        var title = result.split("**")[0];
                        var desc = result.split("**")[1];
                        var coordinates = result.split("**")[2];
                        $('.thread-title').html('<h4 class="bold margin0">' + title + '</h4>');
                        $('.thread-description').html(desc);
                        $('.featured-thumbnail').removeClass('active-reposition');
                        $('.featured-thumbnail').css('background-position',coordinates);
                        $('.thread').removeClass('active-edit');
                   } 
               }
            });
    };
    $(document).on('click','.btn-cancel-edit',function(){
        $('.editThreadWrap').remove();
        $('.thread-desc-inner').show();
        $('.thread-editor-title').remove();
        $('.thread-title > h4').show();
        $('.featured-thumbnail').removeClass('active-reposition');
        $('.featured-thumbnail').css('background-position',coordinates);
        $('.thread').removeClass('active-edit');
    });
    $('.upvotes-toggle').click(function(){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: false,
            data: {KEY: 'getUpvoteList',tid: $(this).attr('data-tid')},
            success: function(result) {
                $('body').addClass('offscroll');
                $('body').append(result);
                var topMargin = (window.innerHeight - 500) / 2;
                $('.stat-defocus').css('margin-top', topMargin + 'px');
            }
        });
    });
    $('.views-toggle').click(function(){
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: false,
            data: {KEY: 'getViewList',tid: $(this).attr('data-tid')},
            success: function(result) {
                $('body').addClass('offscroll');
                $('body').append(result);
                var topMargin = (window.innerHeight - 500) / 2;
                $('.stat-defocus').css('margin-top', topMargin + 'px');
            }
        });
    });
    $('.replies-toggle').click(function(){
        $('html,body').animate({scrollTop: $('.reply:first').offset().top},1000);
    });
    $(document).on('click','.btn-close-defocus',function(){
        $('body').removeClass('offscroll');
        $('.btn-close-defocus').closest('.theatre').remove();
    });
    if(screen.width>480){
    $('.toggleEditHistory').click(function(){
        var tid = $(this).attr('data-tid');
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: false,
            data: {KEY: 'toggleEditHistory',tid: tid},
            success: function(result) {
                $('body').addClass('offscroll');
                $('body').append(result);
                var topMargin = (window.innerHeight - 500) / 2;
                $('.eParentWrap').css('margin-top', topMargin + 'px');                
            }
        });
    });
    }
    else{
        $('.toggleEditHistory').hide();
    }
    $(document).on('click','.cancelEditHistoryTheatre',function(){
        $('body').removeClass('offscroll');
        $('.editHistoryTheatre').remove();
    });
    $(document).on('keyup',function(e){
        if($('.editHistoryTheatre').length){
            if(e.keyCode===27) {
                $('body').removeClass('offscroll');
                $('.editHistoryTheatre').remove();
            }
        }
        if($('.stat-defocus').length){
            if(e.keyCode===27) {
                $('body').removeClass('offscroll');
                $('.stat-defocus').closest('.theatre').remove();
            }
        }
        if($('.image-theatre-wrapper').length){
            if(e.keyCode===27) {
                $('body').removeClass('offscroll');
                $('.image-theatre-wrapper').fadeOut(function(){
                    $('.image-theatre-wrapper').remove();
                });
            }
        }
    });
    editReposition = function() {
    $(document).on('mousedown mouseup', ".active-reposition", function (e) {

        var start = {x: 0, y: 0};
        var move = {x: 0, y: 0};
        var id = $(this).attr('id');
        var origin = {x: 0, y: 0};
        var container = {w: $(this).width(), h: $(this).height()};

        var containerRatio = container.h / container.w;

        var img = new Image;
        img.src = $(this).css('background-image').replace(/url\(|\)$/ig, "");
        var background = {w: img.width, h: img.height};

        var backgroundRatio = background.h / background.w;

        var min = {x: 0, y: 0};
        var max = {x: 0, y: 0};

        if (backgroundRatio < containerRatio) {
            min.y = 0;
            min.x = -((container.h * (1 / backgroundRatio)) - container.w);
        }
        else if (backgroundRatio > containerRatio) {
            min.x = 0;
            min.y = -((container.w * backgroundRatio) - container.h);
        }
        else {
            min.x = 0;
            min.y = 0;
        }
        if (e.type == 'mousedown') {
            $(this).css('border', '1px solid #36c5b9');

            origin.x = e.clientX;
            origin.y = e.clientY;

            var temp = $(this).css('background-position').split(" ");
            start.x = parseInt(temp[0]);
            start.y = parseInt(temp[1]);
            $(this).mousemove(function (e) {
                move.x = start.x + (e.clientX - origin.x);
                move.y = start.y + (e.clientY - origin.y);
                if (move.x <= max.x && move.x >= min.x && move.y <= max.y && move.y >= min.y) {
                    $(this).css('background-position', move.x + 'px ' + move.y + 'px');
                    $("#" + id).val('x:' + move.x + ', y:' + move.y);
                }
                else if (move.x <= max.x && move.x >= min.x) {
                    if (move.y < min.y) {
                        $(this).css('background-position', move.x + 'px ' + min.y + 'px');
                        $("#" + id).val('x:' + move.x + ', y:' + min.y);
                    }
                    else if (move.y > max.y) {
                        $(this).css('background-position', move.x + 'px ' + max.y + 'px');
                        $("#" + id).val('x:' + move.x + ', y:' + max.y);
                    }
                }
                else if (move.y <= max.y && move.y >= min.y) {
                    console.log('y');
                    if (move.x < min.x) {
                        $(this).css('background-position', min.x + 'px ' + move.y + 'px');
                        $("#" + id).val('x:' + min.x + ', y:' + move.y);
                    }
                    else if (move.x > max.x) {
                        $(this).css('background-position', max.x + 'px ' + move.y + 'px');
                        $("#" + id).val('x:' + max.x + ', y:' + move.y);
                    }
                }
                else {
                    console.log('problem');
                }
            });
        }
        else {

            $(this).css('border', '1px solid transparent');

            $(this).off('mousemove');
            $(document.body).focus();
        }
    });
};

   $('.featured-thumbnail').hover(function(){
        //$(this).css('border','1px solid #09f');
        $(this).css('box-shadow','0px 0px 3px 2px #09f inset');
    },function(){
       // $(this).css('border','1px solid transparent');
        $(this).css('box-shadow','');
    });
$(document).on('click','.featured-thumbnail',function(){   
    var img = $('.featured-thumbnail').attr('data-image');
    $('<div class="image-theatre-wrapper">\n\
            <div class="area-photo"><i class="fa fa-2x fa-times-circle fg-white close-image-theatre pointer" style="z-index:99999;position: absolute;right:10px;top:10px;"></i>\n\
                <div class="theatre-photo-container">\n\
                    <img src="" class="theatre-photo" />\n\
                </div>\n\
            </div>\n\
        </div>').insertAfter('.container');
    $('body').addClass('offscroll');
    $('.image-theatre-wrapper').fadeIn("fast", function(){
        $(".theatre-photo").attr("src", img).load(function() {
            $(".theatre-photo-container").fadeIn();
            var h_d = $(this).height();
            var h_p = $(this).parent().height();
            var margin = (h_p - h_d) / 2;
            $(this).css("margin-top", margin+'px');
        });
    });
});
$(document).on('click','.close-image-theatre',function(){
    $('body').removeClass('offscroll');
    $('.image-theatre-wrapper').fadeOut(function(){
        $('.image-theatre-wrapper').remove();
    });
});
});