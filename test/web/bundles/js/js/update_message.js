//update message
$(function() {
    
    $("form").submit(function(e) {
        e.preventDefault();
        var $url = $(this).attr('action');
        var $data = $(this).serialize();
        var $form_id = $('#form_id');
        var $id = $form_id.val();
        //var div = document.getElementById("calendar_button");
        //var myData = div.href;
        //console.log(myData);
        console.log(this);

        $.ajax({
            type: "POST",
            url: $url,
            data: $data
        }).done(function( result ) {
            if(result.success) {
                console.log(result);
            }

        });
    });

});
