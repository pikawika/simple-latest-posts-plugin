jQuery(document).ready( function onAjaxClick($) {
    $(".load_more_button_slp").click( function() {
        var data = {
            action: 'load_more',
            amount_to_load: $(this).attr('load-more-amount'),
            amount_to_skip: $(this).attr('amount-to-skip'),
            read_more_text: $(this).attr('read-more-text'),
            load_more_text: $(this).attr('load-more-text'),
        };
        // the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
        $.post(the_script.ajaxurl, data, function(response) {
            //make the response elemen a dom element so we can query it
            var xmlString = response
                , parser = new DOMParser()
                , DOMResponse = parser.parseFromString(xmlString, "text/html");

            //replace the load more button with the new one
            $( "#load_more_button" ).replaceWith( DOMResponse.getElementById('load_more_button') );

            // place the new blogposts into the old container
            document.getElementById('slp_container').innerHTML += DOMResponse.getElementById('slp_container').innerHTML;


            //rerun linking function
            onAjaxClick($);
        });
        return false;
    });
});