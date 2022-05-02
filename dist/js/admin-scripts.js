var $=jQuery.noConflict();

jQuery(document).ready(function($){
    $("form#edittag").attr("id","edit_cat_wrap");

    $('.set_pdt_imgs').click(function(e) { 
        var loader = $(this).next('.loader_wrap');
        loader.addClass('active');
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
            'action': 'set_pdt_imgs',
            },
            success: function (data) {
                console.log('success');
                loader.removeClass('active');
            },
            error: function (errorThrown) {
                loader.removeClass('active');
                console.log(errorThrown);
            }
        });

        
    });


    $('.set_product_long_desc').click(function(e) { 
        console.log('click long desc');
        var loader = $(this).siblings('.loader_wrap');
        loader.addClass('active');
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
            'action': 'set_pdt_long_desc',
            },
            success: function (data) {
                console.log('success');
                loader.removeClass('active');
            },
            error: function (errorThrown) {
                loader.removeClass('active');
                console.log(errorThrown);
            }
        });

        
    });


    $('.set_product_short_desc').click(function(e) { 
        var loader = $(this).next('.loader_wrap');
        loader.addClass('active');
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
            'action': 'set_pdt_short_desc',
            },
            success: function (data) {
                console.log('success');
                loader.removeClass('active');
            },
            error: function (errorThrown) {
                loader.removeClass('active');
                console.log(errorThrown);
            }
        });

        
    });
});