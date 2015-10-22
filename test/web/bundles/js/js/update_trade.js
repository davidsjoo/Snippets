
function trade(id) 
{
    $('#trade_success').hide();
    $('#trade_fail').hide();
    $('#modal_close_button').hide();
    $('#spin').hide();
    
    $(function() 
    {
        var $id = id;
        var $link = 'testgame/trade/highlight/';
        $("form").submit(function (e) {
            $('#modal_save').hide();
            $('#modal_form').hide();
            $('#spin').show();
            e.preventDefault();
            var $data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: $link + $id,
                data: $data
            })
            .done(function (result) {
                if (result.success) {
                    $('#modal_form').hide();
                    console.log(result);
                    console.log($id);
                    $('#spin').hide();
                    $('#trade_success').fadeIn();
                    $('#modal_close_button').show();
                }
                else {
                    $('#spin').hide();
                    $('#trade_fail').fadeIn();
                    $('#modal_close_button').show();
                }
            })
            .fail(function(err) {
                console.log(err);
                alert('Status: '+err.status+' '+err.statusText+', Readystate: '+err.readyState);
                $('#gameModal').modal('hide');
                location.reload(false);
            })
        });
    });
    //empty modal on close
    $(document).on("hidden.bs.modal", ".modal:not(.local-modal)", function (e) {
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
        location.reload(true);
    });
}