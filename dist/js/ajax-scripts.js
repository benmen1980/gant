

var $=jQuery.noConflict();

jQuery(document).ready(function($){
    
    function ValidateID(str){
        //INPUT VALIDATION

        // Just in case -> convert to string
        var IDnum = String(str);

        // Validate correct input
        if ((IDnum.length > 9) || (IDnum.length < 5)){
            $('#reg_id').after('<span class="error">הכנס ת"ז תקין</span>');
            check_validate_id = false;
        }

        if (isNaN(IDnum)){
            $('#reg_id').after('<span class="error">הכנס ת"ז תקין</span>');
            check_validate_id = false;
        }
        // The number is too short - add leading 0000
        if (IDnum.length < 9){
            while(IDnum.length < 9){
                IDnum = '0' + IDnum;
            }
        }

        // CHECK THE ID NUMBER
        var mone = 0, incNum;
        for (var i=0; i < 9; i++)
        {
            incNum = Number(IDnum.charAt(i));
            incNum *= (i%2)+1;
            if (incNum > 9)
            incNum -= 9;
            mone += incNum;
        }
        if (mone%10 != 0){
            $('#reg_id').after('<span class="error">הכנס ת"ז תקין</span>');
            check_validate_id = false;

        }
        else{
            check_validate_id = true;
        }
    }
    
    $('.send_validation_sms').on('click', function() {
        console.log('enter click565');
        user_phone = $(this).closest('form').find('.form-row input#reg_username').val();
        user_fname = $(this).closest('form').find('.form-row input#reg_first_name').val();
        user_lname = $(this).closest('form').find('.form-row input#reg_last_name').val();
        user_email = $(this).closest('form').find('.form-row input#reg_email').val();
        user_id = $(this).closest('form').find('.form-row input#reg_id').val();
        user_birthday = $(this).closest('form').find('.form-row input#reg_birthday').val();
        $(".error").remove();
        if (user_fname.length == 0) {
            $('#reg_first_name').after('<span class="error">שם פרטי שדה חובה</span>');
            check_validate_fname = false;
        }
        else{
            check_validate_fname = true;
        }
        if (user_birthday.length == 0) {
            $('#reg_birthday').after('<span class="error">תאריך לידה שדה חובה</span>');
            check_validate_birthday = false;
        }
        else{
            check_validate_birthday = true;
        }
        if (user_phone.length == 0) {
            $('#reg_username').after('<span class="error">טלפון שדה חובה</span>');
            check_validate_phone = false;
        }
        else{
            var regEx = /^\+?(972|0)(\-)?0?([5]{1}\d{8})$/;
            var validPhone = regEx.test(user_phone);
            if(!validPhone){
                $('#reg_username').after('<span class="error">הכנס טלפון תקין</span>');
                check_validate_phone = false;
            }   
            else{
                check_validate_phone = true;
            }
        }
        if (user_lname.length == 0) {
            $('#reg_last_name').after('<span class="error">שם משפחה שדה חובה</span>');
            check_validate_lname = false;
        }
        else{
            check_validate_lname = true;
        }
        if (user_email.length == 0) {
            $('#reg_email').after('<span class="error">אימייל שדה חובה</span>');
            check_validate_email = false;
        } 
        else {
            //var regExEmail = /^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/;
            var regExEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            var validEmail = regExEmail.test(user_email);
            if (!validEmail) {
              $('#reg_email').after('<span class="error">הכנס אימייל תקין</span>');
              check_validate_email = false;
            }
            else{
                check_validate_email = true;
            }
        }
        if (user_id.length == 0) {
            $('#reg_id').after('<span class="error">ת"ז שדה חובה</span>');
            check_validate_id = false;
            console.log('enter if');
        } 
        else {
            ValidateID(user_id);

        }
        console.log("check_validate_id", check_validate_id);
        console.log("check_validate_email", check_validate_email);
        console.log("check_validate_fname", check_validate_fname);
        console.log("check_validate_lname", check_validate_lname);
        console.log("check_validate_phone", check_validate_phone);
        console.log("check_validate_birthday", check_validate_birthday);

        if(check_validate_id == true && check_validate_email == true && check_validate_lname == true && 
            check_validate_fname == true && check_validate_phone == true && check_validate_birthday == true){
            $.ajax({
                url: ajax_obj.ajaxurl,
                data: {
                'action': 'send_sms',
                'user_phone': user_phone,
                },
                success: function (data) {
                    console.log('success');
                    $('.input_wrapper_validation_code').show();
                },
                error: function (errorThrown) {
                    console.log('error');
                    console.log(errorThrown);
                }
            });
        }
    });

    $('.check_code_wrapper .check_code').on('click', function() {

        var enter_code = $(this).prev('#validation_code').val();
        $.ajax({
            url: ajax_obj.ajaxurl,
            data: {
            'action': 'check_code',
            'enter_code': enter_code,
            },
            dataType: 'json',
            method: 'POST',
            success: function (data) {
                if($(".msg_after_validation").length)
                    $(".msg_after_validation").remove();
                if($('.register_btn').length){
                    $('.register_btn').remove();
                }
                //console.log('success');
                console.log(data);
                console.log(data.data);
                console.log(data.data.msg);
                console.log(data.data.response);
                $('.check_code_wrapper').after('<div class="msg_after_validation">'+ data.data.msg +'</div>');
                if(data.data.response == true)
                    $('.form-row-submit').append('<button type="submit" class="register_btn" name="register">הרשמה</button>')
                    //$('.register_btn').show();
            },
            error: function (errorThrown) {
                if($(".msg_after_validation").length)
                    $(".msg_after_validation").remove();
                if($('.register_btn').length){
                    $('.register_btn').remove();
                }
                console.log('error');
                console.log(errorThrown);
                $('.check_code_wrapper').after('<div class="msg_after_validation">אירעה שגיאה, נסה שנית</div>');
            }
        });
    });



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
        var pdts_shown = parseInt($('.current_number_pdt_in_page').text());
        console.log("🚀 ~ file: ajax-scripts.js ~ line 68 ~ $ ~ pdts_shown", pdts_shown);
        window.history.replaceState(null, null, "?pdts="+pdts_shown);


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
                'substainility' : substainility,
                'current_pdt_in_page' : current_pdt_in_page,
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
                      var searchParams = new URLSearchParams(window.location.search);
                      var param = searchParams.get('pdts')
                      console.log("🚀 ~ file: ajax-scripts.js ~ line 242 ~ filter_product ~ param", param);
                      if(searchParams.has('pdts')){
                        var newPaged = parseInt(param/post_per_page);
                        console.log("🚀 ~ file: ajax-scripts.js ~ line 246 ~ filter_product ~ newPaged", newPaged);
                        window.history.replaceState(null, null, window.location.href.split('?')[0]);
                      }
                      $('.count_result').text(parseInt(data.found_posts));
                      $('.count_wrapper #count').text(data.found_posts);
                      $('.search_suggestions_products_wrapper').html(data.result);
                      $('.current_number_pdt_in_page').text(parseInt(data.total_results));
                    }
                    if(query_type == 'load_more') {
                        var newPaged = parseInt(paged) + 1;
                        $('.search_suggestions_products_wrapper').append(data.result);
                        $('.current_number_pdt_in_page').text(parseInt(current_pdt_in_page) + parseInt(data.total_results));
                        // var url = '';
                        // current_url = url + '?' + 'pdt_to_show' + '=' + parseInt(current_pdt_in_page) + parseInt(data.total_results);
                        // window.history.replaceState(null, null, current_url);
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