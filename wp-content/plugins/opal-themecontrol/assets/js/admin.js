(function($) {
    /**
    *   Event Click Item demo
    */
    function opal_addons() {
        var $demoItem = $('.addon-item-btn');
       
        $demoItem.each(function(){
            $(this).on('click', function(e) {
                e.preventDefault();
                var element = $(this);
                var key = $(this).data( 'key' );
                var checkbox = element.find('.'+key).val();
                //do acction loading on item here
                var loading = 'loading...';
                $(this).html(loading);
                
                $(this).parent().parent('.addon-item').addClass('active');
                // call ajax download here
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    dataType: 'json', 
                    data: {
                        action:'do_activate_addons',
                        key: key,
                        checkbox: checkbox
                    },
                    async: false,
                    success: function ( data, textStatus, XMLHttpRequest){
                        if (data.status == "activate") {
                            //do acction add class active item here'
                            element.removeClass('button-primary');
                            element.addClass('button-danger');
                            element.html('Deactivate <input class="'+key+'" type="hidden"  name="'+key+'" value="deactivate">');                                        
                        }else{
                            element.parent().parent('.addon-item').removeClass('active');
                            element.addClass('button-primary');
                            element.removeClass('button-danger');
                            element.html('Activate <input class="'+key+'" type="hidden"  name="'+key+'" value="activate">');
                        }
                        return data;
                    },
                    error: function (MLHttpRequest, textStatus, errorThrown){
                        console.error("The following error occured: " + textStatus, errorThrown);
                    }
                }); //end Ajax
            });
        });// End demoItem
    }//end func

    /**
    *   Event Change Post Format 
    */
    function opal_bog() {
        if( $('#cmb2-metabox-post-format-group') ){
            
            var update = function( post_format ){
                $('#post-format-group').show();
                $('#cmb2-metabox-post-format-group > div').hide();
                $('.cmb2-id-blog-format-'+post_format).show();
                if( $('.cmb2-id-blog-format-'+post_format).length <= 0 ){
                    $('#post-format-group').hide();
                }
            }

            update(  $('#post-formats-select input:checked').val()  );
            $('#post-formats-select input').change( function(){
                update( $( this ).val() );
            } );
        }
    }//end func 


	$(document).ready(function($){
		opal_addons();
        opal_bog();
	});
})(jQuery);