

var $=jQuery.noConflict();

jQuery(document).ready(function($){
    var timer = null;
    $('#searchform > input').keydown(function(){
        
        clearTimeout(timer); 
        timer = setTimeout(search_term, 1000)
    });

    function search_term(){
        
        //if($(this).val().length > 2){
            var sterm = $('#searchform > input').val();
            console.log(sterm);
            var loader = $('#l_side').find('.loader_wrap');
            loader.addClass('active');
            if(sterm != ''){
                $.ajax({
                    url: ajax_obj.ajaxurl,
                    data: {
                    'action': 'get_search_ajax_query',
                    'sterm': sterm,
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log('success');
                        loader.removeClass('active');
                        if(data.result == null){
                            $('.top_results').hide();
                            jQuery('.results_list').empty();
                            $('.msg_no_result').show();
                            jQuery('.msg_no_result span.search_term').html(sterm);
                        }
                        else{
                            $('.msg_no_result').hide();
                            jQuery('.msg_no_result span.search_term').empty();
                            $('.top_results').css('display','flex');
                            //$('.results_list').empty();
                            $('.results_list').html(data.result);
                        }
                        
     
                    },
                    error: function (errorThrown) {
                    loader.removeClass('active');
                    console.log(errorThrown);
                    }
                });
            }

        //}
    }


    $('.load_more_pdts').on('click', function() {
        filter_product('load_more');
    });

    $('.menu_item_checkbox .radio_wrapper input.radio_sort').on('change', function() {
        checked_val = $(this).next("label").text();
        console.log(checked_val);
        $('.sort_wrapper .selected_order').text(checked_val);
        $('.sort_wrapper .selected_order').attr('aria-label',checked_val);
    });
    $('.menu_item_checkbox .checkbox_wrapper input[type="checkbox"],.menu_item_checkbox .radio_wrapper input[type="radio"]').on('change', function() {
        if($(this).is(":not(:checked)")){
            $(this).closest('.dropdown_wrapper').prev('.dropbtn').find('.selected_choices').text('');
        }
    });
    $('.menu_item_checkbox .checkbox_wrapper input[type="checkbox"],.menu_item_checkbox .radio_wrapper input[type="radio"]').on('change', function() {
        if($('.menu_item_checkbox .radio_wrapper input[type="radio"]:checked').length < 1 && $('.menu_item_checkbox .checkbox_wrapper input[type="checkbox"]:checked').length < 1) {
            filter_product('clean_query');
        } else {
            filter_product('filter');
            $('.filter_reset > button').show();
        }
    });

    function filter_product(query_type){
        var query_type = query_type;

        if(query_type == 'load_more') {
            $('button.load_more_pdts').addClass('loader_active');
        }
        
        if(query_type == 'filter' || query_type == 'clean_query') {
            $('.search_suggestions_products_wrapper').addClass('loader_active');
            if($(window).width() < 1024){
                $('#filter_modal .modal_content').addClass('loader_active');
            }
        }

        var colors = [];
        var sizes = [];
        var cuts = [];
        var substainility ;
        var categories = [];
        var prices;
        var order;
        var loadMoreButton = $('.load_more_pdts');
        var paged = $('.load_more_pdts').attr('data-paged');
        var post_per_page  = $('.load_more_pdts').attr('posts_per_page');
        //var total_pdts  = $(this).attr('total_pdts');
        var current_pdt_in_page =  $('.current_number_pdt_in_page').text();
        var pdt_cat = $('.child_category_wrapper').attr('id').substr(5);
        //var total_in_page = parseInt(current_pdt_in_page) + parseInt(post_per_page);
        //var page = $(this).attr('data-paged');


        
        $("input[type=checkbox].checkbox_size").each(function(){
            var elem = $(this);
            if(elem.prop("checked") )  {
                //$( '.reset_btn' ).show();
                sizes.push(elem.val());
                if(sizes.length  == 1){
                    $('#select_size').text(elem.val());
                }
                else if(sizes.length  > 1){
                    $('#select_size').text(sizes.length  + ' נבחרו');
                }
            }
        });

       
        if($("input[type=radio].radio_price").is(":checked") )  {
            //$( '.reset_btn' ).show();
            prices = $("input[type=radio].radio_price:checked").val();
            $('#select_price').text($("input[type=radio].radio_price:checked").next('label').text());
            
  
        }

        if($("input[type=checkbox]#checkbox_substainable").is(":checked") )  {
            //$( '.reset_btn' ).show();
            substainility = $("input[type=checkbox]#checkbox_substainable:checked").val();
            $('#select_sub').text($("input[type=checkbox]#checkbox_substainable:checked").next('label').text());
        }

        if($("input[type=radio].radio_sort").is(":checked") )  {
            //$( '.reset_btn' ).show();
            order = $("input[type=radio].radio_sort:checked").val();
        }
        

        $("input[type=checkbox].checkbox_cut").each(function(){
            var elem = $(this);
            if(elem.prop("checked") )  {
                //$( '.reset_btn' ).show();
                cuts.push(elem.val());
                if(cuts.length  == 1){
                    $('#select_cut').text(elem.val());
                }
                else if(cuts.length  > 1){
                    $('#select_cut').text(cuts.length  + ' נבחרו');
                }
            }
        });

        $("input[type=checkbox].checkbox_color").each(function(){
            var elem = $(this);
            if(elem.prop("checked") )  {
                //$( '.reset_btn' ).show();
                colors.push(elem.val());
                if(colors.length  == 1){
                    $('#select_color').text(elem.val());
                }
                else if(colors.length  > 1){
                    $('#select_color').text(colors.length  + ' נבחרו');
                }
            }
        });
      
  
        $("input[type=checkbox].checkbox_category").each(function(){
            var elem = $(this);
            if(elem.prop("checked") )  {
                //$( '.reset_btn' ).show();
                categories.push(elem.attr('data-catid'));
                if(categories.length  == 1){
                    $('#select_cat').text(elem.val());
                }
                else if(categories.length  > 1){
                    $('#select_cat').text(categories.length  + ' נבחרו');
                }
            }
           
        });
        if((categories.length == 0)){
            categories.push(pdt_cat);
        }

        var filters = true;
        if($('input[type=checkbox]:checked').length < 1 && $('input[type=radio]:checked').length < 1) {
            filters = false;
        }

        $.ajax({
            url: ajax_obj.ajaxurl,
            data : {
                'action' : 'filter_products',
                'cuts' : cuts,
                'colors' : colors,
                'sizes' : sizes,   
                'categories' : categories,  
                'prices' : prices,
                'paged' : paged,
                'filters': filters,
                'query_type': query_type,
                'order' : order,
                'substainility' : substainility
            },
            dataType: "json",
            //type : "POST",
            success : function( data ) {
            console.log("🚀 ~ file: ajax-scripts.js ~ line 205 ~ filter_product ~ data", data);
                $('button.load_more_pdts').removeClass('loader_active');
                $('.search_suggestions_products_wrapper').removeClass('loader_active');
                $('#filter_modal .modal_content').removeClass('loader_active');
                if(data.no_results) {
                    $('.load_more_pdts_wrapper').hide();
                    $('#back_to_top').hide();
                    $('.search_suggestions_products_wrapper').html('<p>'+data.no_results+'</p>');
                    $('.count_wrapper #count').text(0);
                    
                } 
                else {
                    $('.load_more_pdts_wrapper').show();
                    $('#back_to_top').show();
                    if(query_type == 'filter' || query_type == 'clean_query') {
                      var newPaged = 1;
                      $('.count_result').text(parseInt(data.found_posts));
                      $('.count_wrapper #count').text(data.found_posts);
                      $('.search_suggestions_products_wrapper').html(data.result);
                      $('.current_number_pdt_in_page').text(parseInt(data.total_results));
                    }
                    if(query_type == 'load_more') {
                        var newPaged = parseInt(paged) + 1;
                        $('.search_suggestions_products_wrapper').append(data.result);
                        $('.current_number_pdt_in_page').text(parseInt(current_pdt_in_page) + parseInt(data.total_results));
                        
                    }
                    
                   
                    if (data.more_items == false) {
                      loadMoreButton.hide();
                    } else {
                      loadMoreButton.attr('data-paged', newPaged);
                      loadMoreButton.show();
                     
                    }
                    if(parseInt(data.found_posts) - parseInt($('.current_number_pdt_in_page').text()) == 1){
                        $('.more_pdt_title').text('מוצר נוסף');
                    }
                    if((parseInt(data.found_posts) - parseInt($('.current_number_pdt_in_page').text())) < parseInt(post_per_page)){
                        $('.more_pdt_to_show').text(parseInt(data.found_posts) - parseInt($('.current_number_pdt_in_page').text()));
                    }
                    else{
                        $('.more_pdt_to_show').text(post_per_page);
                    }
                }
            },
            error : function( data ) {
                $('button.load_more_pdts').removeClass('loader_active');
                $('.search_suggestions_products_wrapper').removeClass('loader_active');
                $('#filter_modal .modal_content').removeClass('loader_active');
                
                console.log( 'Error…' );
            }
            
        });
    }
    
    // reset filter
    $('.filter_reset > button').on('click', function() {
        $('.selected_choices').text('');
        if($('.menu_item_checkbox .radio_wrapper input[type="radio"]:checked')) {
            $('.menu_item_checkbox .radio_wrapper input[type="radio"]:checked').prop("checked", false);
            $('.menu_item_checkbox .radio_wrapper input[type="radio"]').closest('.menu_item_checkbox').attr('aria-checked','false');
        }
        if($('.menu_item_checkbox .checkbox_wrapper input[type="checkbox"]:checked')) {
            $('.menu_item_checkbox .checkbox_wrapper input[type="checkbox"]').prop("checked", false);
            $('.menu_item_checkbox .checkbox_wrapper input[type="checkbox"]').closest('.menu_item_checkbox').attr('aria-checked','false');
        }

        filter_product('clean_query');
        $(this).hide();
    });

    //“Add to cart” with Woocommerce and AJAX
    $('.single_add_to_cart_button').click(function(e) { 
        e.preventDefault();
        $thisbutton = $(this),
        $form = $thisbutton.closest('form.cart'),
                id = $thisbutton.val(),
                product_qty = $form.find('select.qty').val() || 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input[name=variation_id]').val() || 0;
        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,
        };
        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: data,
            beforeSend: function (response) {
                $thisbutton.addClass('loader_active');
            },
            complete: function (response) {
                $thisbutton.removeClass('loader_active');
            },
            success: function (response) {

                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    console.log(response);
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    $('#modal_mini_cart').toggleClass('is_modal_showing');
                    $('body').toggleClass('is_modal_open');
                        //$(document.body).trigger('wc_fragment_refresh');
                    
                }
            },
        });
    });


 
    
        

    

   
});