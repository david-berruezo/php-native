if( typeof(console) == 'object' ) {
    console.log( 'script loaded' );
}

(function($) {
    $('.more-link').click(function(){
        var link = this;
        $(link).html('loading...');
        // href="' . get_permalink() . "#more-{$post->ID}"
        var post_id = $(link).attr('href').replace(/^.*#more-/, '');
        var data = {
            action: 'boj_arm_ajax',
            post_id: post_id
        };
        $.get(boj_arm.ajaxurl, data, function(data){
            $(link).after(data).remove();
        });
        return false;
    });
})(jQuery);

