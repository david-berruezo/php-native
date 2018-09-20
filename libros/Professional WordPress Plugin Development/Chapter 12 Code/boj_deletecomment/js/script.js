jQuery(document).ready(function($) {
    
    $('.boj_idc_link').click(function(){
        var link = this;
        // get comment id and nonce
        var href = $(link).attr( 'href' );
        var id =    href.replace(/^.*c=(\d+).*$/, '$1');
        var nonce = href.replace(/^.*_wpnonce=([a-z0-9]+).*$/, '$1');

        var data = {
            action: 'boj_idc_ajax_delete',
            cid: id,
            nonce: nonce
        }
        
        $.post( boj_idc.ajaxurl, data, function(data){
            var status  = $(data).find('response_data').text();
            var message = $(data).find('supplemental message').text();
            if( status == 'success' ) {
                $(link).parent().after( '<p><b>'+message+'</b></p>' ).remove();
            } else {
                alert( message );
            }
        });

        return false;
        
    });

});
