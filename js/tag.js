$(document).ready(function () {
    $('.load-more-post-tag').bind('click', function () {
        var tag = $(this).attr('data-tag');
        $.ajax({
            url: 'request.php',
            type: 'POST',
            cache: 'false',
            data: 'KEY=loadMorePostsTag&t=' + $('#hdnT').val() + '&tag=' + tag,
            beforeSend: function () {
                $('.load-more-post-tag').html('<i class="fa fa-circle-o-notch fa-spin fg-black"></i>');
            },
            success: function (result) {
                if (result === '0') {
                    $('<div class="full-span" style="padding-bottom: 20px;"><h3 class="txt-center light">That\'s all we could find :)</h3></div>').insertAfter('.thread:last').fadeIn();
                    $('.load-more-post-tag').parent().parent().remove();
                }
                else {
                    $(result).insertAfter('.thread:last').fadeIn("slow");
                    $('.load-more-post-tag').html('LOAD MORE POSTS');
                }
            }
        });
    });

});