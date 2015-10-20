
function trade(id) 
{
    $('#trade_success').hide();
    $('#modal_close_button').hide();



    $(function() 
    {
        var $id = id;
        var $link = 'testgame/trade/highlight/';
        $("form").submit(function (e) {
            e.preventDefault();
            var $data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: $link + $id,
                data: $data
            })
            .done(function (result) {
                if (result.success) {
                    console.log(result);
                    console.log($id);
                    $('#trade_success').fadeIn();
                    $('#modal_close_button').show();
                }
                else {
                    alert('Något gick fel.. :(');
                    location.reload(true);
                }
            })
            .fail(function(err) {
                console.log(err);
                alert('Något gick fel.. :( \nStatus: '+err.status+' '+err.statusText+', Readystate: '+err.readyState);
                $('#gameModal').modal('hide');
                location.reload(true);
            })
        });
    });
    //empty modal on close
    $(document).on("hidden.bs.modal", ".modal:not(.local-modal)", function (e) {
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
        location.reload(true);
    });
}