$(document).ready(function(){
    $('.category').click(function(){
       if ($(this).find('.defocus-panel > .selected').length) {

            //update hdn input
            var val = $(this).attr('data-id');
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
            $(this).find('.defocus-panel').children('div').remove();
        }
        else {
            var value = $('input[name="categories"]').val();
            if (value !== "") {
                var array = $('input[name="categories"]').val().split(",");
                if ($.inArray($(this).attr('data-id'), array) === -1) {
                    $('input[name="categories"]').val($('input[name="categories"]').val() + ',' + $(this).attr('data-id'));
                }
            }
            else {
                $('input[name="categories"]').val($(this).attr('data-id'));
            }

            $(this).find('.defocus-panel').append('<div class="selected"><i class="fa fa-check-circle center-icon fa-4x" style="color:#80FF00;"></i></div>');
        }
    });
    $('.update-category').click(function(){
        if($.trim($('input[name="categories"]').val())===""){
            alert('Something Went Wrong');
        }
        else{
            $.ajax({
                url: 'request.php',
                type: 'POST',
                data: 'KEY=updateCategories&DATA=' + $('input[name="categories"]').val(),
                beforeSend: function(){
                    $('.update-category').attr('disabled', true);
                },
                success: function(){
                    $('.update-category').removeAttr('disabled');
                    var topMargin = (window.innerHeight - 122) / 2;
                    topMargin = topMargin - 95;
                    $('.editor-help-child').css('margin-top', topMargin + 'px');
                    $('.editor-help-parent').fadeIn("slow", function () {
                        $('.editor-help-child').fadeIn("fast", function () {
                            $('body').addClass('offscroll');
                        });
                    }).delay(1200).fadeOut("slow",function(){
                        $('body').removeClass('offscroll');
                    });
                }
            });
        }
    });
});