

var $=jQuery.noConflict();

jQuery(document).ready(function($){

    
    function ValidateID(str){
        //INPUT VALIDATION

        // Just in case -> convert to string
        var IDnum = String(str);

        // Validate correct input
        if ((IDnum.length > 9) || (IDnum.length < 5) ){
            $('#reg_id').after('<span class="error">הכנס ת"ז תקין</span>');
            $('#validate_id').after('<span class="error">הכנס ת"ז תקין</span>');
            $(".all_error_msg").append('<span class="error">הכנס ת"ז תקין</span>');
            check_validate_id = false;
        }

        if (isNaN(IDnum)){
            $('#reg_id').after('<span class="error">הכנס ת"ז תקין</span>');
            $('#validate_id').after('<span class="error">הכנס ת"ז תקין</span>');
            $(".all_error_msg").append('<span class="error">הכנס ת"ז תקין</span>')
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
            $('#validate_id').after('<span class="error">הכנס ת"ז תקין</span>');
            $(".all_error_msg").append('<span class="error">הכנס ת"ז תקין</span>')
            check_validate_id = false;

        }
        else{
            check_validate_id = true;
        }
    }
    
    $('.woocommerce-form-register .send_validation_sms').on('click', function() {
        user_phone = $(this).closest('form').find('.form-row input#reg_username').val();
        user_fname = $(this).closest('form').find('.form-row input#reg_first_name').val();
        user_lname = $(this).closest('form').find('.form-row input#reg_last_name').val();
        user_email = $(this).closest('form').find('.form-row input#reg_email').val();
        user_id = $(this).closest('form').find('.form-row input#reg_id').val();
        user_pswd_field = $(this).closest('form').find('.form-row input#reg_password');
        user_pswd = $(this).closest('form').find('.form-row input#reg_password').val();
        user_birthday = $(this).closest('form').find('.form-row input#reg_birthday').val();
        user_site_condition = $(this).closest('form').find('.condition_accept_wrapper input#read_site_condition').is(":checked");
        console.log("🚀 ~ file: ajax-scripts.js:61 ~ $ ~ user_site_condition:", user_site_condition);
        //user_club_condition = $(this).closest('form').find('.condition_accept_wrapper input#read_club_condition').is(":checked");
        //console.log("🚀 ~ file: ajax-scripts.js:62 ~ $ ~ user_club_condition:", user_club_condition);
        want_club_registration = $(this).closest('form').find('.condition_accept_wrapper input#want_club_registration').is(":checked");
        console.log("🚀 ~ file: ajax-scripts.js:63 ~ $ ~ want_club_registration:", want_club_registration);

        $(".error").remove();
        if (user_site_condition == false) {
            $('#read_site_condition').next("label").after('<span class="error">אישור תקנון אתר שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">אישור תקנון אתר שדה חובה</span>');
            check_validate_site_condition = false;
        }
        else{
            check_validate_site_condition = true;
        }

        // if (user_club_condition == false) {
        //     $('#read_club_condition').next("label").after('<span class="error">אישור תקנון מועדון שדה חובה</span>');
        //     check_validate_club_condition = false;
        // }
        // else{
        //     check_validate_club_condition = true;
        // }
        if (want_club_registration == false) {
            $('#want_club_registration').next("label").after('<span class="error"> הרשמה למועדון שדה חובה</span>');
            $(".all_error_msg").append('<span class="error"> הרשמה למועדון שדה חובה</span>');
            check_want_club_registration = false;
        }
        else{
            check_want_club_registration = true;
        }

        if (user_fname.length == 0) {
            $('#reg_first_name').after('<span class="error">שם פרטי שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">שם פרטי שדה חובה</span>');
            check_validate_fname = false;
        }
        else{
            check_validate_fname = true;
        }
        if (user_birthday.length == 0) {
            $('#reg_birthday').after('<span class="error">תאריך לידה שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">תאריך לידה שדה חובה</span>')
            check_validate_birthday = false;
        }
        else{
            var dateRegex = /^(0[1-9]|1[0-9]|2[0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if(!dateRegex.test(user_birthday)){
                $('#reg_birthday').after('<span class="error">הכנס פורמט תאריך תקין</span>');
                $(".all_error_msg").append('<span class="error">הכנס פורמט תאריך תקין</span>');
                check_validate_birthday = false;
            }   
            else{
                check_validate_birthday = true;
            }
        }
        if(user_pswd_field.length > 0){
            if (user_pswd.length == 0) {
                $('#reg_password').after('<span class="error">סיסמה שדה חובה</span>');
                $(".all_error_msg").append('<span class="error">סיסמה שדה חובה</span>');
                check_validate_pswd = false;
            }
            else{
                var pswdRegex = /^(?=.*[a-zA-Z])(?=.*\d).{7,}$/;
                if(!pswdRegex.test(user_pswd)){
                    $('#reg_password').after('<span class="error">נא להזין סיסמה עם לפחות 7 תווים ולפחות אות אחת ומספר אחד.</span>');
                    $(".all_error_msg").append('<span class="error">נא להזין סיסמה עם לפחות 7 תווים ולפחות אות אחת ומספר אחד.</span>');
                    check_validate_pswd = false;
                }   
                else{
                    check_validate_pswd = true;
                }
            }
        }
        else{
            check_validate_pswd = true;
        }

        if (user_phone.length == 0) {
            $('#reg_username').after('<span class="error">טלפון שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">טלפון שדה חובה</span>');
            check_validate_phone = false;
        }
        else{
            var regEx = /^\+?(972|0)(\-)?0?([5]{1}\d{8})$/;
            var validPhone = regEx.test(user_phone);
            if(!validPhone){
                $('#reg_username').after('<span class="error">הכנס טלפון תקין</span>');
                $(".all_error_msg").append('<span class="error">הכנס טלפון תקין</span>');
                check_validate_phone = false;
            }   
            else{
                check_validate_phone = true;
            }
        }
        if (user_lname.length == 0) {
            $('#reg_last_name').after('<span class="error">שם משפחה שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">שם משפחה שדה חובה</span>');
            check_validate_lname = false;
        }
        else{
            check_validate_lname = true;
        }
        if (user_email.length == 0) {
            $('#reg_email').after('<span class="error">אימייל שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">אימייל שדה חובה</span>');
            check_validate_email = false;
        } 
        else {
            //var regExEmail = /^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/;
            var regExEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            var validEmail = regExEmail.test(user_email);
            if (!validEmail) {
              $('#reg_email').after('<span class="error">הכנס אימייל תקין</span>');
              $(".all_error_msg").append('<span class="error">הכנס אימייל תקין</span>');
              check_validate_email = false;
            }
            else{
                check_validate_email = true;
            }
        }
        if (user_id.length == 0) {
            $('#reg_id').after('<span class="error">ת"ז שדה חובה</span>');
            $(".all_error_msg").append('<span class="error">ת"ז שדה חובה</span>');
            check_validate_id = false;
        } 
        else {
            ValidateID(user_id);

        }
        console.log("check_validate_id", check_validate_id);
        console.log("check_validate_email", check_validate_email);
        console.log("check_validate_fname", check_validate_fname);
        console.log("check_validate_lname", check_validate_lname);
        console.log("check_validate_phone", check_validate_phone);
        console.log("check_validate_birthday:", check_validate_birthday);

        if(check_validate_id == true && check_validate_email == true && check_validate_lname == true && 
            check_validate_fname == true && check_validate_phone == true && check_validate_birthday == true &&
            check_want_club_registration == true && check_validate_site_condition == true && check_validate_pswd == true){
            console.log("send sms");
            $.ajax({
                url: ajax_obj.ajaxurl,
                data: {
                'action': 'send_sms',
                'user_phone': user_phone,
                },
                success: function (data) {
                    console.log('success1');
                    $('.input_wrapper_validation_code').show();
                    $('.modal_content').animate({
                        scrollTop: $(".input_wrapper_validation_code").offset().top
                    }, 1000);
                },
                error: function (errorThrown) {
                    console.log('error');
                    console.log(errorThrown);
                }
            });
        }
    });

    
    $('.login_validation_btn .user_validation_phone_id').on('click', function() {

        user_phone = $(this).closest('form').find('.form-row input#validate_phone').val();
        user_id = $(this).closest('form').find('.form-row input#validate_id').val();
        //$this =  $(this);
        //$(this).attr("data-phone",user_phone); 
        if (user_phone.length == 0) {
            $('#validate_phone').after('<span class="error">טלפון שדה חובה</span>');
            check_validate_phone = false;
        }
        else{
            var regEx = /^\+?(972|0)(\-)?0?([5]{1}\d{8})$/;
            var validPhone = regEx.test(user_phone);
            if(!validPhone){
                $('#validate_phone').after('<span class="error">הכנס טלפון תקין</span>');
                check_validate_phone = false;
            }   
            else{
                check_validate_phone = true;
            }
        }

        if (user_id.length == 0) {
            $('#validate_id').after('<span class="error">ת"ז שדה חובה</span>');
            check_validate_id = false;
        } 
        else {
            ValidateID(user_id);

        }
        console.log("🚀 ~ file: ajax-scripts.js:180 ~ $ ~ check_validate_id:", check_validate_id);
        console.log("🚀 ~ file: ajax-scripts.js:180 ~ $ ~ check_validate_phone:", check_validate_phone);
        if(check_validate_id == true && check_validate_phone == true){

            $.ajax({
                type:"post",
                url: ajax_obj.ajaxurl,
                data: {
                    'action': 'check_user_data_and_club',
                    'user_phone': user_phone,
                    'user_id' : user_id
                },
                success: function (data) {
                    console.log('success');
                    console.log(data.message);
                    
                    $('body').addClass('is_modal_open');

                    if(data.message == 'is_not_club'){
                        $("#check_club_details_msg_modal").addClass('is_modal_showing');
                        $('#check_club_details_msg_modal .modal_content').hide();
                        $('#check_club_details_msg_modal .modal_content#msg_not_club').show();
                    }
                    else if(data.message == 'is_club'){
                        location.reload();
                        $("#validation_phone_modal .send_validation_sms").attr("data-phone",user_phone); 
                        $("#validation_phone_modal").addClass('is_modal_showing');
                        $('body').addClass('is_modal_open');

                        
                    }
                    else if(data.message == 'is_not_match'){
                        $("#check_club_details_msg_modal").addClass('is_modal_showing');
                        $('#check_club_details_msg_modal .modal_content').hide();
                        $('#check_club_details_msg_modal .modal_content#msg_data_not_match').show();
                    }
                    else if(data.message == 'is_not_exist'){
                        $("#check_club_details_msg_modal").addClass('is_modal_showing');
                        $('#check_club_details_msg_modal .modal_content').hide();
                        $('#check_club_details_msg_modal .modal_content#msg_data_not_exist').show();
                    }
           

                },
                error: function (errorThrown) {
                    console.log('error');
                   
                }
            });
            // $.ajax({
            //     url: ajax_obj.ajaxurl,
            //     data: {
            //     'action': 'send_sms',
            //     'user_phone': user_phone,
                
            //     },
            //     success: function (data) {
            //         console.log('success1');
            //         $('.input_wrapper_validation_code').show();
            //     },
            //     error: function (errorThrown) {
            //         console.log('error');
            //         console.log(errorThrown);
            //     }
            // });
        }
    });

    $('#validation_phone_modal .send_validation_sms').on('click', function() {

        var user_phone = $(this).data('phone');
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
    });

    $('#register_modal .check_code_wrapper .check_code').on('click', function() {

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
                // if($('.register_btn').length){
                //     $('.register_btn').remove();
                // }
                //console.log('success');
                console.log(data);
                console.log(data.data);
                console.log(data.data.msg);
                console.log(data.data.response);
                $('.check_code_wrapper').after('<div class="msg_after_validation">'+ data.data.msg +'</div>');
                if(data.data.response == true){
                    $("#register_modal input.validation_sms_code").val(data.data.code);
                    //$('.form-row-submit').append('<button type="submit" class="register_btn" name="register">הרשמה</button>');
                    //$('.woocommerce-form-register .register_btn').trigger('submit');
                    // $('.modal_content').animate({
                    //     scrollTop: $(".register_btn").offset().top
                    // }, 1000);
                    $('header .main_menu_wrapper').addClass('loader_active');
                    $("#register_modal").removeClass('is_modal_showing');
                    $('body').removeClass('is_register_modal_open');
                    $('.register_btn').trigger('click');
                }
                // else{
                //     return;
                // }   
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

    $('#validation_phone_modal .check_code_wrapper .check_code').on('click', function() {

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
                if(data.data.response == true){
                    $("form.edit-account input.edit_account_validation_code").val(data.data.code);
                    $("#validation_phone_modal").removeClass('is_modal_showing');
                    $("#validation_user_details_modal").addClass('is_modal_showing');
                    $('body').addClass('is_modal_open');

                }
                // else{
                //     return;
                // }   
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
    



    $('#edit_details_modal .save_account_details').on('click', function() {
        var searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has('sms_check')) {
        searchParams.delete('sms_check');
        var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        window.location.href = newUrl;
        }
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
            if($('.dropbtn').hasClass('dropdown_open')){
                $('.dropdown_open').next('.dropdown_wrapper').find('.dropdown_box').toggle();
                $('.dropbtn').removeClass('dropdown_open')
            }
            
            $('.filter_reset > button').show();
        }
        //remove page variable from url if exist
        // var uri = window.location.toString();
        // if (uri.indexOf("?") > 0) {
        //     var clean_uri = uri.substring(0, uri.indexOf("?"));
        //     window.history.replaceState({}, document.title, clean_uri);
        // }
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
        var sleeves = [];
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


        // Get the current URL
        var currentURL = window.location.href;
        // Create an array to store the checked values
        var checkedValues = [];

        $("input[type=checkbox].checkbox_size").each(function(){
            var elem = $(this);
            if(elem.prop("checked") )  {
                //$( '.reset_btn' ).show();
                sizes.push(elem.val());
                checkedValues.push($(this).val());
                if(sizes.length  == 1){
                    $('#select_size').text(elem.val());
                }
                else if(sizes.length  > 1){
                    $('#select_size').text(sizes.length  + ' נבחרו');
                }
            }
        });

        var newURL = currentURL.split('?')[0]; // Remove any existing query parameters
        if (checkedValues.length > 0) {
        newURL += '?filter=' + checkedValues.join('+');
        console.log("🚀 ~ file: ajax-scripts.js:609 ~ filter_product ~ newURL:", newURL);
        window.history.pushState({ path: newURL }, '', newURL);

        }

       
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

        $("input[type=checkbox].checkbox_sleeve").each(function(){
            var elem = $(this);
            if(elem.prop("checked") )  {
                //$( '.reset_btn' ).show();
                sleeves.push(elem.val());
                if(sleeves.length  == 1){
                    $('#select_sleeve').text(elem.val());
                }
                else if(sleeves.length  > 1){
                    $('#select_sleeve').text(sleeves.length  + ' נבחרו');
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
                'sleeves' : sleeves,
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

                        window.history.replaceState(null, null, "?page="+newPaged);
                    }
                    
                   
                    if (data.more_items == false) {
                      loadMoreButton.hide();
                    }
                    else {
                        loadMoreButton.attr('data-paged', newPaged);
                        loadMoreButton.show();
                        
                     
                    }
                    if(parseInt(data.found_posts) - parseInt($('.current_number_pdt_in_page').text()) == 1){
                        $('.more_pdt_title').text('מוצר נוסף');
                    }
                    // if((parseInt(data.found_posts) - parseInt($('.current_number_pdt_in_page').text())) < parseInt(post_per_page)){
                    //     $('.more_pdt_to_show').text(parseInt(data.found_posts) - parseInt($('.current_number_pdt_in_page').text()));
                    // }
                    // else{
                    //     $('.more_pdt_to_show').text(post_per_page);
                    // }
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
        $("input[id=radio_sort_popularity]").trigger('change');
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
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            },
            success: function (response) {

                if (response.error) {
                    console.log("error");
                    $('.woocommerce-notices-wrapper').html(response.error_msg);
                    $(document.body).trigger('wc_fragment_refresh');
                    //window.location = response.product_url;
                    return;
                } else {
                    console.log('enter heree');
                    console.log(response);
                    $('.woocommerce-notices-wrapper').html(response);
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    //$('#modal_mini_cart').toggleClass('is_modal_showing');
                    //$('body').toggleClass('is_modal_open');
                    $(document.body).trigger('wc_fragment_refresh');
                    
                }
            },
        });
    });

    // $('.woocommerce-cart-form').on('change', 'select.qty', function(){
	// 	$("[name='update_cart']").trigger("click");
    //     //$('.bag_button a').trigger('click');
	// });
            
    $('.woocommerce-cart-form').submit(function(event) {
        event.preventDefault(); // prevent the form from submitting normally
      
        // perform the update to the cart using AJAX or other means
        var customFieldInputs = $('form.woocommerce-cart-form .cart_item .product-quantity');
        var cartItemArray = [];

        // Loop through custom field input fields
        customFieldInputs.each( function() {
            var product_id = $( this ).data( 'id' );
            var quantity = $( this ).find('select.qty').val();
    
            // Add input field name and value to cart item array
            cartItemArray.push({
                'product_id': product_id,
                'quantity': quantity
            });
        });
        console.log( cartItemArray );
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: {
                action: 'update_transaction_from_cart',
                cart_item_array:  cartItemArray
            },
            beforeSend: function (response) {
                $('header .main_menu_wrapper').addClass('loader_active');
            },
            complete: function (response) {
                $('header .main_menu_wrapper').removeClass('loader_active');
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            },
            success: function (response) {
                console.log( 'AJAX success:', response );  
                localStorage.setItem("transaction_update", JSON.stringify(response));
                //if (!$("body").hasClass("woocommerce-cart")) {
                location.href = ajax_obj.woo_shop_url; 
            },
            error: function( xhr, status, error ) {
                console.log( 'AJAX error:', status, error );
                //window.location.href = ajax_obj.woo_shop_url;
            }
        });
        
        // add code to execute after the update is complete
     
    });

    $('input#coupon_code').on('keypress', function(event) {
        if (event.which === 13) {
          event.preventDefault();
          // do something else here, such as triggering a button click event
        }
    });


    

    $('.bag_button a').click(function(e) {

        console.log('update');
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: {action: "update_bag"},
            beforeSend: function (response) {
                if (!$("body").hasClass("woocommerce-cart")) {
                    $('header .main_menu_wrapper').addClass('loader_active');
                }
                //$('body').trigger('wc_update_cart');
            },
            complete: function (response) {
                console.log('complete');
                if (!$("body").hasClass("woocommerce-cart")) {
                    $('header .main_menu_wrapper').removeClass('loader_active');
                }
                //console.log(response);
                //window.location.reload();
            },
            success: function (response) {
                var msg_error = response.error;
                console.log(response);
                if (msg_error!= null) {
                    console.log("error");
                    $('.woocommerce-notices-wrapper').html(response.error_msg);
                    if (!$("body").hasClass("woocommerce-cart")) {
                        window.location.href = ajax_obj.woo_shop_url;
                    }
  
                }
                else{
                    console.log('update success');
                    console.log(response);
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    localStorage.setItem("transaction_update", JSON.stringify(response));
                    if (!$("body").hasClass("woocommerce-cart")) {
                        window.location.href = ajax_obj.woo_shop_url;
                    }
                }

            },
            error : function( data ) {
                console.log(data);
                console.log( 'Error…' );
            }
        });
    });

   



    if ($("body").hasClass("woocommerce-cart")) {
        $('.bag_button a').trigger('click');
        // setTimeout(function() {
        //     $('.bag_button a').trigger('click');
        // },6000);
        // Retrieve data from local storage
        var transaction_data = JSON.parse(localStorage.getItem("transaction_update"));
        console.log("🚀 ~ file: ajax-scripts.js:902 ~ $ ~ transaction_data:", transaction_data);

        // if (localStorage.getItem('desc_sale') != undefined) {
        //     var desc_sale = localStorage.getItem("desc_sale");
        //     var desc_sale= desc_sale.replace(/['"]+/g, '');
        // }
        // if (localStorage.getItem('sale_sum') != undefined) {
        //     var sale_sum = localStorage.getItem("sale_sum");
        //     $('.fee.coupon_sale th').text(desc_sale);
        //     $('.fee.coupon_sale td').prepend('₪' + sale_sum);
        // }
        

       

        
        
  
      
      
        console.log('enter cart');
        // Do something with the data
        //console.log(transaction_data);
        // console.log(transaction_data.OrderItems);
        jQuery.each(transaction_data.OrderItems, function(index, item) {
           item_sale_desc = item.FirstSaleDescription;
           console.log("🚀 ~ file: ajax-scripts.js:673 ~ jQuery.each ~ item_sale_desc:", item_sale_desc);
           
           item_code  = item.ItemCode;
           item_sale_price = item.TotalPrice;
           $(".product-sale-desc[data-sku='"+item_code+"']").text(item_sale_desc);
        });

    }
    jQuery(document).on('updated_checkout', function() {
        var transaction_data = JSON.parse(localStorage.getItem("transaction_update"));
        console.log("🚀 ~ file: ajax-scripts.js:946 ~ jQuery ~ transaction_data:", transaction_data);

        // if (localStorage.getItem('desc_sale') != undefined) {
        //     var desc_sale = localStorage.getItem("desc_sale");
        //     var desc_sale = desc_sale.replace(/['"]+/g, '');
        // }
        // if (localStorage.getItem('sale_sum') != undefined) {
        //     var sale_sum = localStorage.getItem("sale_sum");
        //     $('.fee.coupon_sale th').text(desc_sale);
        //     $('.fee.coupon_sale td').prepend('₪' + sale_sum);
        // }
        
       
        // Do something with the data
        console.log(transaction_data);
        // console.log(transaction_data.OrderItems);
        jQuery.each(transaction_data.OrderItems, function(index, item) {
           item_sale_desc = item.FirstSaleDescription;
           console.log("🚀 ~ file: ajax-scripts.js:673 ~ jQuery.each ~ item_sale_desc:", item_sale_desc);
           
           item_code  = item.ItemCode;
           item_sale_price = item.TotalPrice;
           $(".product-sale-desc[data-sku='"+item_code+"']").text(item_sale_desc);
        });
    });

   

    //“remove to cart” with Woocommerce and AJAX
    $("body").on("click", ".product-remove", function(e){
        e.preventDefault();
        e.stopPropagation();
        var pd_id_remove = $(this).attr("data-product_id");
        //var remove_url = wc_get_cart_remove_url( product_id );
        console.log("🚀 ~ file: ajax-scripts.js:541 ~ $ ~ product_id", pd_id_remove);
        var data = {
            action: 'product_remove',
            product_id: pd_id_remove,
        };
        console.log(data);
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: data,
            // beforeSend: function (response) {
            //     $('body').trigger('wc_update_cart');
            // },
            beforeSend: function (response) {
                $('header .main_menu_wrapper').addClass('loader_active');
            },
            complete: function (response) {
                console.log( response );
                //$('body').trigger('wc_cart_button_updated');
                console.log('complete1');
                $('header .main_menu_wrapper').removeClass('loader_active');
                window.location.reload();
            },
            // success: function (response) {
            //     //$(document.body).trigger('wc_fragment_refresh');
            //     console.log( response );
            //     console.log('success');
            //     //window.location.reload();
            // },
            error : function( data ) {
                console.log( 'Error…' );
            }
        });
    });

    $("body").on("click", "#delete_all_cart", function(e){
        e.preventDefault();
        e.stopPropagation();
        console.log('click delete all cart');
        var data = {
            action: 'delete_all_cart',
        };
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: data,
            // beforeSend: function (response) {
            //     $('body').trigger('wc_update_cart');
            // },
            beforeSend: function (response) {
                $('header .main_menu_wrapper').addClass('loader_active');
            },
            complete: function (response) {
                console.log( response );
                //$('body').trigger('wc_cart_button_updated');
                console.log('complete delete all cart');
                $('header .main_menu_wrapper').removeClass('loader_active');
                window.location.reload();
            },
            // success: function (response) {
            //     //$(document.body).trigger('wc_fragment_refresh');
            //     console.log( response );
            //     console.log('success');
            //     //window.location.reload();
            // },
            error : function( data ) {
                console.log( 'Error…' );
            }
        });
    });

  




    $("body").on("click", ".fee .remove_coupon", function(e){
        console.log('enter coupon');
        e.preventDefault();
        e.stopPropagation();
        $thisbutton = $(this);
        coupon_code = $thisbutton.data('coupon');
        console.log("🚀 ~ file: ajax-scripts.js:583 ~ $ ~ coupon_code", coupon_code);
        var data = {
            action: 'remove_coupon_programatically',
            coupon_code: coupon_code,
        };
        console.log(data);
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: data,
            // beforeSend: function (response) {
            //     $thisbutton.addClass('loader_active');
            // },
            // complete: function (response) {
            //     $thisbutton.removeClass('loader_active');
            // },
            success: function (response) {
                console.log('success remove coupon');
                console.log(response);
                //localStorage.setItem("transaction_update", JSON.stringify(response));
                //var desc_sale = response.desc_sale;
                //var sale_sum = response.sale;
                localStorage.setItem("transaction_update", JSON.stringify(response.result));
                // localStorage.setItem("desc_sale", JSON.stringify(desc_sale));
                // localStorage.setItem("sale_sum", JSON.stringify(sale_sum));
                //$('.fee').html( response );
                // if ($("body").hasClass("woocommerce-cart"))
                //     $('body').trigger('wc_update_cart');
                // if ($("body").hasClass("woocommerce-checkout"))
                //     $('body').trigger('update_checkout');
                window.location.reload();

                
            },
            error : function( data ) {
                console.log( 'Error…' );
            }
        });
    });

    $("body").on("click", ".club_fee .remove_coupon", function(e){
        console.log('remove club fee');
        $('#checkbox_club').attr('checked', false).trigger('click');
        window.location.reload();
    });

    $("body").on("click", "#birthday_coupon", function(e){
        console.log('enter func');
        
        coupon_code = $(this).data('coupon');
        console.log("🚀 ~ file: ajax-scripts.js:926 ~ $ ~ coupon_code:", coupon_code);
        var data = {
            action: 'apply_coupon_birthday_programatically',
            coupon_code: coupon_code,
        };
        console.log(data);
        $.ajax({
            type: 'post',
            url: ajax_obj.ajaxurl,
            data: data,
            success: function (response) {
                console.log('success1');
                var desc_sale = response.desc_sale;
                var sale_sum = response.sale;
                localStorage.setItem("transaction_update", JSON.stringify(response.result));
                localStorage.setItem("desc_sale", JSON.stringify(desc_sale));
                localStorage.setItem("sale_sum", JSON.stringify(sale_sum));
                window.location.reload();
                // if ($("body").hasClass("woocommerce-cart"))
                //     $('body').trigger('wc_update_cart');
                // if ($("body").hasClass("woocommerce-checkout"))
                //     $('body').trigger('update_checkout');
            },
            error : function( data ) {
                console.log( 'Error…' );
            }
        });
    });

 
    
        

    

   
});