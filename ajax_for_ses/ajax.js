	$("form").submit(function(e) {
             e.preventDefault();
             var $url = $(this).attr('action');
             var $data = $(this).serialize();
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