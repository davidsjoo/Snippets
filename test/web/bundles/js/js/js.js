 $(function() {
    $('#div_highlight').hide();
    $('#div_cmh').hide();
})

$(function() {

    var $user = $('#form_user');
    var $start_date_month = $('#form_start_date_month');
    var $start_date_day = $('#form_start_date_day');
    var $start_date_year = $('#form_start_date_year');
    var $end_date_month = $('#form_end_date_month');
    var $end_date_day = $('#form_end_date_day');
    var $end_date_year = $('#form_end_date_year');
    var $highlights = $('#show_highlight');
    var $cmhs = $('#show_cmh');
    
$('.rapport_submit').on('click', function(event) {
        event.preventDefault();

        $("#show_cmh").empty().show();

        $.ajax({
            type: 'GET',
            url: '/rapport/highlight',
            data: {
                user: $user.val(),
                start_date: $start_date_year.val() + '-' + $start_date_month.val() + '-' + $start_date_day.val(),
                end_date: $end_date_year.val() + '-' + $end_date_month.val() + '-' + $end_date_day.val() + ' ' + '23:00:00',
            },
            success: function (highlights) {
                if (highlights.length == 0) {
                    $("#div_highlight").hide();
                }
                else {
                    $("#show_highlight").empty();
                    $("#div_highlight").show();
                    $highlights.append('<th>Match</th><th>Datum</th>');
                    console.log(highlights);
                    console.log(highlights.length);
                    document.getElementById('rapport_highlights_count').innerHTML = 'Highlights ('+highlights.length+')';
                    $.each(highlights, function (i, highlight) {
                        $highlights.append('<tr><td>' + highlight.game_name + '</td><td>' + highlight.gamedates.date.toString().substr(0, 16) + '</td></tr>');
                    });
                }

            },
            error: function () {
                console.log('error');
            }
        });

        $.ajax({
            type: 'GET',
            url: '/rapport/cmh',
            data: {
                user: $user.val(),
                start_date: $start_date_year.val() + '-' + $start_date_month.val() + '-' + $start_date_day.val(),
                end_date: $end_date_year.val() + '-' + $end_date_month.val() + '-' + $end_date_day.val() + ' ' + '23:00:00',
            },
            success: function (cmhs) {
                if (cmhs.length == 0) {
                    $('#div_cmh').hide();
                }
                else {
                    $('#show_cmh').empty();
                    $('#div_cmh').show();
                    $cmhs.append('<th>Match</th><th>Datum</th>');
                    console.log(cmhs);
                    document.getElementById('rapport_cmh_count').innerHTML = 'CMH ('+cmhs.length+')';
                    $.each(cmhs, function (i, cmh) {
                        $cmhs.append('<tr><td>' + cmh.game_name + '</td><td>' + cmh.gamedates.date.toString().substr(0, 16) + '</td></tr>');
                    });
                }

            },
            error: function () {
                console.log('error');
            }
        })
    });

});


