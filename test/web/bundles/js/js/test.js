/**
 * Created by davidsjoo on 15-09-21.
 */
$(function() {
    $('.ajax-task-complete').on({
        click: function(e) {
            e.preventDefault();
            var $href = $(this).attr('href');

            $('<div></div>').load($href+' form', function() {

                var $form = $this.children('form');
                var $url = $form.attr('action');
                var $data = $form.serialize();

                $.ajax({
                    url: $url,
                    data: $data,
                    method: 'post',
                    dataType: 'json',
                    cache: false,
                    success: function(obj) {
                        var $tic = $('#task-complete-'+obj.id+' .ajax-task-complete');

                    }
                })
            });

        }
    });
});