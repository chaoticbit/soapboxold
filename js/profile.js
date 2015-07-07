$(document).ready(function(){
   $('.tab-container .nav-tabs li').click(function(){
       if($(this).hasClass('tab1toggle')){
           $('.nav-tabs li').removeClass('active');
           $('.tab-1').show();
           $('.tab-2').hide();
           $('.tab1toggle').addClass('active');
       }
       else if($(this).hasClass('tab2toggle')){
           $('.tab-container .nav-tabs li').removeClass('active');
           $('.tab-1').hide();
           $('.tab-2').show();
           $('.tab2toggle').addClass('active');
       } 
    }); 
    $('.pr').click(function(){
        var rid = $(this).attr("id").split("&")[0];
        var tid = $(this).attr("id").split("&")[1];
        window.location = "thread.php?tid=" + tid + "#r" + rid;
    });
    
    $('.loadMoreTimeline').click(function(){
        var t = $('#hdnTimelineT').val();
        var uname = $(this).attr('data-uname');
        var ele = $(this);
        $.ajax({
            url: 'request.php',
            type: 'POST',
            data: {KEY:'loadMoreTimeline',t:t,username:uname},
            beforeSend: function(){
                $(ele).html('<i class="fa fa-fw fa-circle-o-notch fa-spin txt-center" style="margin:0 0 20px 80px;"></i>');
            },
            success: function(result) { 
               if(result==='0') {
                   $(ele).remove();
               }
               else{
                   $(ele).html('<i class="fa fa-refresh txt-center" style="margin:0 0 20px 80px;"></i> Load More');
                   var timel = result.split("****")[0];
                   var timehdn = result.split("****")[1];
                   $(timel).insertBefore('.loadMoreTimeline').fadeIn("slow");
                   $('#hdnTimelineT').val(timehdn);
               }
            }
        });
    });
});