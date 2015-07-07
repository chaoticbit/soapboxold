$(document).ready(function(){ 
    
   $(document).keydown(function(e){
        var $listItems = $('.readlist ul > li');
        var key = e.keyCode,
                $selected = $listItems.filter('.active-readlist'),
                $current;
        if (key !== 40 && key !== 38 && key !== 13)
            return;
        $listItems.removeClass('active-readlist');
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
            $selected.find('a').click();
        }
        $current.addClass('active-readlist');
       
   });
    
   $('.fa-book').closest('li').addClass('active'); 
   if(screen.width > 480){
   var h = $('.right-pane').height();
   h = h - 120;
   $('.readlist').css('height',h+'px');
   $('.readlist').scroll(function(){
        var fromTopPx = 0;
        var scrolledFromtop = $('.readlist').scrollTop();
        if (scrolledFromtop > fromTopPx) {
            $('.readhead').css('box-shadow','0px 0px 3px rgba(235,235,235,0.5)');
        } else {
            $('.readhead').css('box-shadow','');
        }
   });
   }
   else{
       var h = $('.mobile-reading-list').height();
       h = h - 50;
   $('.readlist').css('height',h+'px');
   $('.readlist').scroll(function(){
        var fromTopPx = 0;
        var scrolledFromtop = $('.readlist').scrollTop();
        if (scrolledFromtop > fromTopPx) {
            $('.readhead').css('box-shadow','0px 0px 3px rgba(235,235,235,0.5)');
        } else {
            $('.readhead').css('box-shadow','');
        }
   });
   }
   $('.toggleread').click(function(){
      var tid = $(this).attr('data-tid') ;
      var ele = $(this);
      $.ajax({
          url: 'request.php',
            type: 'POST',
            cache: false,
            data: 'KEY=loadReadingList&tid=' + tid,
            beforeSend : function(){
                $('.readingparent').css('opacity','0.5');
                $('.readinglist-container').append('<i class="fa fa-4x fa-circle-o-notch readerNotch fa-spin fg-black" style="top:50%;left:46%;position:absolute;-webkit-transform:translate(-50%,-50%);"></i>')
            },
            success: function(result){
                $('.readingparent').css('opacity','');
                $('.readerNotch').remove();
                $('.toggleread').removeClass('activeread');
                $(ele).addClass('activeread');
                $('.readingparent').html(result);
            }
      });
   });
   
});


