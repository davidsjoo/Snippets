

$(document).ready(function() {

	var $messages = $('#message_json');
    var $1 = "<a data-toggle='modal'";
    var $1_2 = " data-target='#myModal' href=\"";
    var $7 = "\">o</a";
    var $8 = ">";
    $.ajax({
        type: "GET",
        url: "message/get/json",
        success: function(messages) {
            //console.log('success', messages);
            $.each(messages, function (i, message) {
                //console.log(message.id);
                $messages.append('<tr><td>' + message.headline + '</td><td>' +
                    $1+$1_2+'message/update_message/'+message.id+$7+$8+ '</td></tr>')
            });
        },
        error: function() {
            console.log('Error loading messages')

        }
    });

});

//empty modal on close
$(document).on("hidden.bs.modal", ".modal:not(.local-modal)", function (e) {
    $(e.target).removeData("bs.modal").find(".modal-content").empty();
});