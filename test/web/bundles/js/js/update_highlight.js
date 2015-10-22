
$('a').click(function() {
    $(this).addClass('highlight_active');
});

function highlight(id) 
{
    var $id = id;
    var $add_user = '<i class="fa fa-user-plus"></i>';
    var $flag = '<i class="fa fa-flag" id="red_flag"></i>';
    var $before_href = '<a data-toggle="modal" data-target="#gameModal" href="';
    var $after_href = '">';
    var $link = 'testgame/highlight/';
    //initial user
    var $user = document.getElementById('highlight_user').value;
    //initial value from checkbox
    var $checkedValue1 = $('#highlight_trade:checked').val();

    //set highlight to game and post to database
    $(function() 
    {
        $('#modal_save').hide();
        $('#highlight_user, #highlight_trade').change(function() {
            var $current_user = document.getElementById('highlight_user').value;
            var $current_checkedValue = $('#highlight_trade:checked').val();
            if ($user == $current_user && $current_checkedValue == $checkedValue1) {
                console.log("Such user, many checkbox, wow..");
                $('#modal_save').hide();
            }
            else {
                $('#modal_save').show();
            }

            if ($user != $current_user) {
                document.getElementById('highlight_trade').checked = false;
                document.getElementById('highlight_trade_message').value = null;   
            }
            
        })
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
                    $('#gameModal').modal('hide');
                    console.log(result);
                    if (result.highlight.trade === false) {
                        document.getElementById(
                            'game-'+result.highlight.id).innerHTML = 
                        $before_href+$link+result.highlight.id+$after_href+result.highlight.user+'</a>';
                    }
                    else {
                        document.getElementById(
                            'game-'+result.highlight.id).innerHTML = 
                        $before_href+$link+result.highlight.id+$after_href+result.highlight.user+' '+$flag+'</a>';   
                    }
                    $("#game-"+result.highlight.id).addClass("update_success");
                    setTimeout(function() {
                        $("#game-"+result.highlight.id).removeClass("update_success");
                    }, 3000);
                }
                else {
                    console.log('Något gick fel.. :(');
                    //location.reload(true);
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

    //remove highligt user from game
    $(function() 
    {
        $('#remove_highlight_button').click(function() {
            $.ajax({
                type: 'POST',
                url: 'testgame/highlight/remove/'+$id
            }).done(function (result) {
                if (result.success) {
                    $("#game-"+result.highlight.id).hide();
                    $('#gameModal').modal('hide');
                    console.log(result);
                    document.getElementById(
                        'game-'+result.highlight.id).innerHTML = 
                    $before_href+'testgame/highlight/'+result.highlight.id+$after_href+$add_user+'</a>';
                    $("#game-"+result.highlight.id).fadeIn().addClass("update_success");
                    setTimeout(function() {
                        $("#game-"+result.highlight.id).removeClass("update_success");
                    }, 3000);
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
            });
        });
    });

    //empty modal on close
    $(document).on("hidden.bs.modal", ".modal:not(.local-modal)", function (e) {
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
        $('a').removeClass('highlight_active');
    });
}

//hide trade and trade message if no user is set on highlight
function hide() {
    $('#trade').hide();
    $('#trade_message').hide();
} 