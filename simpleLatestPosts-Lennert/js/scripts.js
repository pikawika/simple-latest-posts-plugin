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
            //remove load more button since a new one will replace it
            document.getElementById('load_more_button').remove();
            // place the html in the container
            var div = document.getElementById('slp_container');
            div.innerHTML += response;
            //rerun linking function
            onAjaxClick($);
        });
        return false;
    });
});