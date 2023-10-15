var $=jQuery.noConflict();
jQuery(document).on("ready", function(){

    $('img').attr('loading', 'lazy');

    $( ".showlogin" ).on("click", function(event){
        event.preventDefault();
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        window.location.href= baseUrl+"/my-account";
        
    });
    if (!$("body").hasClass("page-template-register")) {
        if($('.slider_benefits').length){
            $('.slider_benefits').slick({
                infinite: false,
                slidesToShow: 3.4,
                slidesToScroll: 1,
                arrows: true,
                rtl: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2.4,
                            arrows: false,
                        }
                    },
                    {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1.4,
                        arrows: false,
                    }
                },
                    
                ]
            });
            
    
        }
    }

    ///slider product image for mobile only
    if($(window).width() < 1024){
        if($('.slider_gallery_wrapper').length){
            $('.slider_gallery_wrapper .gallery-thumbnail-slider').slick({
                infinite: false,
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: true,
                rtl: true,
                responsive: [
                    // {
                    //     breakpoint: 1024,
                    //     settings: {
                    //     slidesToShow: 2.4,
                    //     arrows: false,
                    //     }
                    // },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }



    }

    //open account menu
    $( ".account_menu_wrapper" ).on("click", function(event){
        event.stopPropagation();
        console.log('enter login menu');
        $(this).find('.popup_login_wrapper .popup_login').toggle();
        if($(window).width() < 1024){
            $(this).toggleClass('open_menu_account_mobile');
            if($('.search_popup_wrapper').hasClass('search_popup_active')){
                $('.search_popup_wrapper').removeClass('search_popup_active');
            }
        }
    });
    //open dropdown
    $( ".dropbtn" ).on("click", function(event){
        event.stopPropagation();
        $(this).closest('.dropdown').siblings().find('.dropdown_wrapper .dropdown_box').hide();
        $(this).closest('.dropdown').siblings().find('.dropbtn').removeClass('dropdown_open');
        $(this).toggleClass('dropdown_open');
        $(this).next('.dropdown_wrapper').find('.dropdown_box').toggle();
    });
    //close dropdown
    
    $(".dropdown_header .close" ).on("click", function(event){
        //if($(this).closest(".dropdown_box").is(":visible")){
            $(this).closest(".dropdown_box").hide();
            $(this).closest('.dropdown').find('.dropbtn').removeClass('dropdown_open');
        //}
    });
    

    $( ".search_button" ).on("click", function(event){
        event.stopPropagation();
        if($('.account_menu_wrapper').hasClass('open_menu_account_mobile')){
            $('.account_menu_wrapper').removeClass('open_menu_account_mobile');
            $('.popup_login_wrapper .popup_login').hide();
        }
        $('.search_popup_wrapper').toggleClass('search_popup_active');
        $('body').toggleClass('is_modal_open');
        if(!$('.search_popup_wrapper').hasClass('search_popup_active')){
            $('#searchform input').val('');
            $('.top_results').hide();
            $('.msg_no_result').hide();
            jQuery('.results_list').empty();
        }
    });

    $("body").on("click", function(){
        if($(window).width() < 1024){
            if( $(".mobile_menu_open").is(":visible")){
                //$(".mobile_menu_open").hide(); 
                //$('.right-navigation.main-navigation').removeClass('header_mobile_nav_open'); 
            }

        }

        if( $(".popup_login").is(":visible")){
            $(".popup_login").hide(); 
        }
        if( $(".dropdown_box").is(":visible")){
            $(".dropdown_box").hide();
            $('.dropbtn').removeClass('dropdown_open');
        }
        
        if( $(".search_popup_wrapper").is(":visible")){
            $(".search_popup_wrapper").removeClass('search_popup_active');
            $('body').removeClass('is_modal_open');
        }
        // if( $(".modal:not(#modal_address)").is(":visible")){
        //     $(".modal").removeClass('is_modal_showing');
        //     $('body').removeClass('is_modal_open');
        // }
        if( $(".modal:not(#validation_phone_modal,#modal_address)").is(":visible")){
            $(this).removeClass('is_modal_showing');
            $('body').removeClass('is_modal_open');
        }


    });

    $( ".search_popup_wrapper,.dropdown_box,.modal .modal_container, .modal .modal_container_minicart, .popup_login" ).on("click", function(event){
        event.stopPropagation();

    });


    $( ".modal .close" ).on("click", function(event){
        $(this).closest('.modal').removeClass('is_modal_showing');
        $('body').removeClass('is_modal_open');
    });

    $( ".modal#validation_user_details_modal .confirmation_btn" ).on("click", function(event){
        $(this).closest('.modal').removeClass('is_modal_showing');
        $('body').removeClass('is_modal_open');
    });

    // $( ".modal#check_club_details_msg_modal .confirmation_btn" ).on("click", function(event){
    //     $(this).closest('.modal').removeClass('is_modal_showing');
    //     $('body').removeClass('is_modal_open');
    // });

    $( ".modal#modal_address .close" ).on("click", function(event){
        //window.location.href = '/my-account/edit-account';
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        window.location.href= baseUrl+"/my-account/edit-account";
        $('body').removeClass('is_modal_open');
    });


    $( ".modal .redirect_my_account" ).on("click", function(event){
        //var redirect_url = "/my-account";
        //window.location.href= redirect_url;
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        window.location.href= baseUrl+"/my-account";
    });



    $( ".top_results a" ).on("click", function(event){
        event.stopPropagation();
        event.preventDefault();
        $( "#searchform > #searchsubmit" ).trigger('click');
    });
    //clear input
    $('.input_icon_clear').on("click", function(event){
        $('#searchform input').val('');
    });

    //If input field is empty, disable submit button
    $('#searchform > #searchsubmit').attr('disabled',true);
    $('#searchform input').on("keyup", function(event){
        if($(this).val().length !=0)
            $('#searchform > #searchsubmit').attr('disabled', false);            
        else
            $('#searchform > #searchsubmit').attr('disabled',true);
    });

    $(window).on("scroll", function(event){
        if(!$('.header_mobile_nav_open').length){
            console.log('enter scroll');   
            //scroll trigger manually
            if (event.originalEvent) {
                var scroll = $(window).scrollTop();    
                if (scroll > 0) {
                    $(".site-header").addClass("header_hidden");
                    if($('.hero_wrapper').length){
                        $('.hero_wrapper').css("height", "100vh");
                    }
                    if($('.hero_type_1').length){
                        $('.hero_type_1').css("height", "100vh");
                    }
                }
                else{
                    $(".site-header").removeClass("header_hidden");
                    if($('.hero_wrapper').length){
                        $('.hero_wrapper').css("height", "calc(100vh - "+$('header').height()+"px)");
                    }
                    if($('.hero_type_1').length){
                        $('.hero_type_1').css("height", "calc(100vh - "+$('header').height()+"px)");
                    }
                }
            }
        }
    });
    if($('.hero_wrapper').length){
        if (!$('.hero_wrapper').hasClass("header_hidden")) {
            $('.hero_wrapper').css("height", "calc(100vh - "+$('header').height()+"px)");
        }else{
            $('.hero_wrapper').css("height", "100vh");
        }
    }

      //define banner height according to header

      if($('.hero_type_1').length){
        if (!$('.hero_type_1').hasClass("header_hidden")) {
            $('.hero_type_1').css("height", "calc(100vh - "+$('header').height()+"px)");
        }
        else{
            $('.hero_type_1').css("height", "100vh");
        }
    }
 

    if($('.search_popup_wrapper').length){
        if($('.promotion_banner').length){
            $('.search_popup_wrapper').css("top", "calc(100% - "+$('.promotion_banner').outerHeight()+"px)");
        }
        else{
            $('.search_popup_wrapper').css("top", "100%");
        }
    }

    if($('.slider_pdts').length){
        $('.slider_pdts').slick({
            infinite: false,
            slidesToShow: 3.4,
            slidesToScroll: 1,
            arrows: true,
            rtl: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                    slidesToShow: 2.4,
                    arrows: false,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1.4,
                        arrows: false,
                    }
                }
            ]
        });
    }





    $('.tabs_wrapper.simple a').on("mouseenter", function(){
        //alert('test');
        $(this).siblings().css('opacity', '0.3');
    });
    $('.tabs_wrapper.simple a').on("mouseleave", function(){
        //alert('test');
        $(this).siblings().css('opacity', '1');
    });



    $('.lost_password a').on("click", function(event){
        event.preventDefault();
        event.stopPropagation();
        $("#password_reset_modal").toggleClass('is_modal_showing');
        $('body').toggleClass('is_modal_open');
    });

    $('.size_chart_button').on("click", function(event){
        event.preventDefault();
        event.stopPropagation();
        $("#size_chart_modal").toggleClass('is_modal_showing');
        $('body').toggleClass('is_modal_open');
    });


    $('.open_language_modal').on("click", function(event){
        event.preventDefault();
        event.stopPropagation();
        $("#language_modal").toggleClass('is_modal_showing');
        $('body').toggleClass('is_modal_open');
    });

    $('.open_filter_modal').on("click", function(event){
        event.preventDefault();
        event.stopPropagation();
        $("#filter_modal").toggleClass('is_modal_showing');
        $('body').toggleClass('is_modal_open');
    });

    $('.count_wrapper_mobile').on("click", function(event){
        console.log('clode');
        $("#filter_modal").trigger('click');
    });

    // $('.modal_address').on("click", function(event){
    //     event.preventDefault();
    //     event.stopPropagation();
    //     console.log('elich');
    //     $("#modal_address").toggleClass('is_modal_showing');
    //     $('body').toggleClass('is_modal_open');
    // });

    if($("#password_confirmation_modal").is(":visible")){
        $('body').css('overflow','hidden');
    }

    var url_param       = $(location).attr('href').split("?");
    var param           = (url_param[1]);
   
    if(param == 'sms_check=true'){
        console.log("🚀 ~ file: scripts.js:302 ~ jQuery ~ param:", param);
        if($("#edit_details_modal").length == 1){
            $("#edit_details_modal").addClass('is_modal_showing');
        }
        else{
            $("#validation_phone_modal").addClass('is_modal_showing');
        }   
        
        $('body').toggleClass('is_modal_open');
    }
    // if(param == 'need_edit=true'){
    //     $("#edit_details_modal").toggleClass('is_modal_showing');
    //     $('body').toggleClass('is_modal_open');
    // }
    

    // $( ".modal .register_btn" ).click(function( event ) {
    //     //event.preventDefault();
    //     console.log('ente here1');
    //     if ($('.woocommerce-error').length){
    //         console.log('ente here');
    //         $("#register_modal").addClass('is_modal_showing');
    //     }
    // });
    $('.register_btn').click(function(e) {
        console.log('click register');
        if ($('body.page-template-register').length > 0)
        {
            if ($('.woocommerce-error').length > 0){
                $("#register_modal").toggleClass('is_modal_showing');
                $('body').toggleClass('is_modal_open');
            }
        }
    });

    //accordion
    $('.section-title').click(function(e) {
        // Get current link value
        console.log(e);
        var currentLink = $(this).attr('href');
        if($(this).is('.active')) {
            close_section();
        }else {
            close_section();
            // Add active class to section title
            $(this).addClass('active');
            // Display the hidden content
            $('.accordion ' + currentLink).slideDown(350).addClass('open');
        }
        e.preventDefault();
    });
        
    function close_section() {
        $('.accordion .section-title').removeClass('active');
        $('.accordion .section-content').removeClass('open').slideUp(350);
    }

    //on mobile, open description accordion by default
    if ($('body.single-product').length > 0 && ($(window).width() <= 768)){
        $(".top_details + .accordion_wrapper #product-description-accordion > .section-title").trigger("click");
    }

    //redirect edit address billing to edit account
    $('form.edit_address_form').bind('DOMSubtreeModified',function(){
        if ($('ul.woocommerce-error').length) {
          $('ul.woocommerce-error').insertAfter('#modal_address .modal_container .section_header')//where you want to place 
        }
    });

    if($('.tabs_wrapper.rounded_btn .btn_holder').length){
        var btns = $('.tabs_wrapper.rounded_btn .btn_holder a:not(:first)');
        var bg_color = btns.css( "background-color" );
        var txt_color = btns.css( "color" );
        btns.hover(function(){
            $(this).css('background-color',txt_color);
            $(this).css('color',bg_color);
        });
        btns.mouseout(function(){
            $(this).css('background-color',bg_color);
            $(this).css('color',txt_color);
        });
        
    }
    if($('#back_to_top').length){
        $("#back_to_top").click(function () {
            $("html, body").animate({scrollTop: 0}, 1000);
        });
    }

    $('.menu_item_checkbox  input[type="checkbox"]').click(function(e){
        console.log($(this));
        if($(this).is(":checked")){
            console.log('checked');
            $(this).closest('.menu_item_checkbox').attr('aria-checked','true');
            
                    
        }
        else if($(this).is(":not(:checked)")){
            console.log('unchecked');
            $(this).closest('.menu_item_checkbox').attr('aria-checked','false');
            
         
        }
      });

    //change select size to radio button
    $(document).on('change', '.variation-radios input', function() {
        $('.variation-radios input:checked').each(function(index, element) {
          var $el = $(element); 
          var thisName = $el.attr('name');
          var thisVal  = $el.attr('value');
          $('select[name="'+thisName+'"]').val(thisVal).trigger('change');
          
        });
      });
    $(document).on('woocommerce_update_variation_values', function() {
        $('.variation-radios input').each(function(index, element) {
            var $el = $(element);
            var thisName = $el.attr('name');
            var thisVal  = $el.attr('value');
            $el.removeAttr('disabled');
            if($('select[name="'+thisName+'"] option[value="'+thisVal+'"]').is(':disabled')) {
                $el.prop('disabled', true);
            }

        });

        if($('.variation-radios input:checked').length == 0){
            if($('.variation-radios input').length == $('.variation-radios input:disabled').length){
                $('button.single_add_to_cart_button .button_label').text('נמכר');
            }
            else{
                $('button.single_add_to_cart_button .button_label').text('בחר מידה');
            }
            
        }
        else{
            $('button.single_add_to_cart_button .button_label').text('הוספה לסל');
        }
       
      });
      $(document).on('click', '.reset_variations', function() {
        if($('.variation-radios input[type="radio"]:checked')) {
            $('.variation-radios input[type="radio"]:checked').prop("checked", false);
            if($('.variation-radios input').length == $('.variation-radios input:disabled').length){
                $('button.single_add_to_cart_button').html('<span class="button_label">נמכר</span>');
            }
            else{
                $('button.single_add_to_cart_button').html('<span class="button_label">בחר מידה</span>');
            }
        }
      });

      $('.woocommerce-product-details__short-description p').each(function() {
        if($(this).html().replace(/\s|&nbsp;/g, '').length === 0){
          $(this).remove();
        }
      });

    if($(window).width() < 1024){

    }
    else{
        
    }

    if($(window).width() < 1024){
    }
    else{
        $(".small_img_slider .product_zoom_thumbnail_item a").click(function(e) {
            e.preventDefault();
            $(".small_img_slider .product_zoom_thumbnail_item a").removeClass("small_img_active");
            $(this).addClass("small_img_active");
            var hash  = $(this).attr("data_main_slider");
            var containerTop = $('.slider_gallery_wrapper').scrollTop(); 
            var containerBottom = containerTop + $('.slider_gallery_wrapper').height(); 
            var elemTop = $('#' + hash).get(0).offsetTop;
            var elemBottom = elemTop + $('#' + hash).height();
            
            if (elemTop < containerTop) {
                //$('.slider_gallery_wrapper').scrollTop(elemTop);
                $('.slider_gallery_wrapper').animate({scrollTop:elemTop},2000);
            } else if (elemBottom > containerBottom) {
                //$('.slider_gallery_wrapper').scrollTop(elemBottom - $('.slider_gallery_wrapper').height() - 68);
                $('.slider_gallery_wrapper').animate({scrollTop: elemBottom - $('.slider_gallery_wrapper').height() - $("header").height()},2000);
            }
        });
    }



    $(".slider_gallery_wrapper").scroll(function() {
        var sections = $(this).find('.gallery-thumbnail-slider .gallery-thumbnail');
        sections.each(function(i) {
            viewportTop = $(this).scrollTop();
            viewportBottom = viewportTop + $(this).height();
            slide_id = $(this).attr('id');
            elementTop = $(this).offset().top;
            elementBottom = elementTop + $(this).outerHeight();
            if(elementBottom > viewportTop && elementTop < viewportBottom){
                console.log(slide_id+ 'on the view');
                $('.small_img_slider .product_zoom_thumbnail_item > a').removeClass('small_img_active');
                $('.small_img_slider .product_zoom_thumbnail_item > a[data_main_slider = '+slide_id+']').addClass('small_img_active');

            }
        });
    });


    

    
    $('body').addClass('gallery_close');


    $('.gallery_close .gallery-thumbnail img').click(function(e) {
        var number_slide = $(this).attr('data-slide');
        console.log(number_slide);
        if($(window).width() < 1024){
            console.log('enter mobile');
            if($('#gallery_modal .gallery_content .modal-content').length){
                $('#gallery_modal .gallery_content .modal-content').slick({
                    slidesToScroll: 1,
                    slidesToShow: 1,
                    arrows: true,
                    dots: false,
                    rtl: true,
                    //edgeFriction: 0,
                    infinite: false,
                    fade: true,
                    //focusOnSelect: true,
                    asNavFor: '.slider_gallery',
                });
            }
            if($('.slider_gallery').length){
                $('.slider_gallery').slick({
                    slidesToShow: 4.5,
                    rtl: true,
                    infinite: false,
                    slidesToScroll: 1,
                    asNavFor: '#gallery_modal .gallery_content .modal-content',
                    //focusOnSelect: true,
                    arrows: false,
                });
            }
        }
        else{
            if($('.slider_gallery').length){
                $('.slider_gallery').slick({
                    infinite: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: true,
                    vertical: true,
                    verticalSwiping:true,
                    focusOnSelect: true,
                });   
            }
        }
   

        //$('.slider_gallery').slick('slickGoTo', number_slide - 1);
        //$('.slider_gallery .slick-slide').eq(0).addClass('slick-current');
        $(".slider_gallery").find(".slick-slide").removeClass('slick-current'); 
        $(".slider_gallery").find(".slick-slide[data-slick-index='"+ parseInt(number_slide - 1)+"']").addClass('slick-current'); 
        $('.slider_gallery').slick('slickGoTo', number_slide - 1);
        $('body').removeClass('gallery_close');
        $('body').addClass('gallery_open');
        $('#gallery_modal').show();
    });
   

    $('.product_zoom_thumbnail_item').click(function(e) {
        if($(window).width() < 1024){
            e.preventDefault();
            e.stopPropagation();
            var  index_thumb = $(this).attr('data-slick-index');
            //console.log(index_thumb);
            $(".slider_gallery").find(".slick-slide").removeClass('slick-current'); 
            $(this).addClass('slick-current'); 
            $('.slider_gallery').slick('slickGoTo', index_thumb);
        }
    });

    // $('.gallery_open .product_zoom_image_wrapper img').click(function(e) {
    //     if($(window).width() < 1024){
    //     console.log('click thumb_img');
    //     var  index_thumb_img = $(this).attr('data-slide');
    //     $('.slider_gallery').slick('slickGoTo',index_thumb_img - 1);
    //     }
    // });
    
    $('#gallery_modal .modal_button_close').click(function(e) {
        $('#gallery_modal').hide();
        $('body').removeClass('gallery_open');
        $('body').addClass('gallery_close');
        var uri = window.location.toString();
        if(uri.indexOf("#")> 0){
        var clean_uri = uri.substring(0, uri.indexOf("#"));
        window.history.replaceState({}, document.title, clean_uri);
    }
     });

    //  $('.product_zoom_thumbnail_item > a').click(function(e) {

    //     e.preventDefault();
    //     var aid = $(this).attr("href");
    //     $('#gallery_modal').animate({scrollTop: $(aid).offset().top},'slow');

    // });
    

    if($(window).width() < 1024){
        // $( ".product_zoom_image_wrapper" ).each(function(index) {
        //     $(this).on("click", function(){
        //         var slideno = $(this).data('slide');
        //         console.log('slideno');
        //         console.log(slideno);
        //         $('.slider_gallery').slick('slickGoTo', slideno -1);
        //     });
        // });
    }
    else{
        $("#gallery_modal").scroll(function() {
            var fixed_position = $("#gallery_modal").offset().top;
            var fixed_height = $("#gallery_modal").height();
            $( ".product_zoom_image_wrapper" ).each(function( index ) {
                var id_elem = $(this).attr('id');
                var slideno = $(this).data('slide');
                var toCross_position = $("#"+id_elem).offset().top;
                var toCross_height = $("#"+id_elem).height();
                if (fixed_position + fixed_height  < toCross_position) {
                    } else if (fixed_position > toCross_position + toCross_height) {
                    } else {
                        $('.slider_gallery').slick('slickGoTo', slideno -1);
                    }
            });      
        });
    }

    $('.show_more_color').click(function(e) {
        $('.checkbox_color_wrapper').show();
        $(this).hide();
    });

    
    $('.product_detail_more_details').click(function(e) {

        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top},2000);

    });

    // on hover single product, change image
    if($('.product_details_hover').length){
        $('.product_details_hover .colors_wrapper a').each(function(index, element) {
            var current_slug =  $(this).closest('.search_suggestions_product').find('.box_product > a').attr('href');
            var current_img =  $(this).closest('.search_suggestions_product').find('.box_product > a >.thumbnail > img').attr('src');
            var current_img_hover =  $(this).closest('.search_suggestions_product').find('.box_product > a >.thumbnail-hover > img').attr('src');
            $(this ).mouseenter(function(e) {
               
                var slug_hover = $(this).attr('data-slug');
                //console.log("🚀 ~ file: scripts.js ~ line 376 ~ $ ~ slug_hover", slug_hover);
                var slug_img = $(this).attr('data-img');
                //console.log("🚀 ~ file: scripts.js ~ line 378 ~ $ ~ slug_img", slug_img);
                $(this).closest('.search_suggestions_product').find('.box_product > a').attr('href',slug_hover);
                $(this).closest('.search_suggestions_product').find('.box_product > a >.thumbnail-hover > img').attr('src',slug_img);
                console.log(  $(this).closest('.search_suggestions_product').find('.box_product > a').attr('href'));
            });
            $(this).mouseleave(function(e) {
                $(this).closest('.search_suggestions_product').find('.box_product > a').attr('href',current_slug);
                $(this).closest('.search_suggestions_product').find('.box_product > a >.thumbnail-hover > img').attr('src',current_img_hover);
                
            });
        });
    }

    // $('.woocommerce-cart-form').on('change', 'select.qty', function(){
	// 	$("[name='update_cart']").trigger("click");
	// });

    $('body').on('click', '.display_coupon_btn', function(e){
        $(this).hide();
        $('.coupon').css('display','flex');
    });

    $('.coupon button[type="submit"]').click(function(e){
        if(!$('.coupon input#coupon_code').val()){
            e.preventDefault();
            e.stopPropagation();
            console.log('enter');

            $('.error_msg_coupon_empty').show();
            return false;
        }
    });

    if($('.woocommerce-remove-coupon').length){
        $('.display_coupon_btn').hide();
    }
    else{
        $('.display_coupon_btn').show();
    }

    $('body').on('click', 'a.woocommerce-remove-coupon', function () {
        $('.display_coupon_btn').show();
   });

   $("body").on("click", ".apply_coupon", function(e){
    console.log('enter coupon');
    e.preventDefault();
    e.stopPropagation();
    $thisbutton = $(this),
    $form = $thisbutton.closest('tr.coupon'),
    coupon_code = $form.find('input[name=coupon_code]').val();
    var data = {
        action: 'apply_coupon_programatically',
        coupon_code: coupon_code,
    };
    console.log(data);
    $.ajax({
        type: 'post',
        url: ajax_obj.ajaxurl,
        data: data,
        // beforeSend: function (response) {
        //     $('body').trigger('wc_update_cart');
        //     //$thisbutton.addClass('loader_active');
        // },
        // complete: function (response) {
        //     $thisbutton.removeClass('loader_active');
        // },
        success: function (response) {
            console.log('success');
            console.log(response);
            //var desc_sale = response.desc_sale;
            //var sale_sum = response.sale;
        
            //$('.fee').html( response );
            // if ($("body").hasClass("woocommerce-cart")){
            //     //$('body').trigger('wc_update_cart');
            // }  
            // if ($("body").hasClass("woocommerce-checkout")){
            //     //$('body').trigger('update_checkout');
            // }
        //    if(desc_sale != null && sale_sum!= null) {
        //     localStorage.setItem("desc_sale", JSON.stringify(desc_sale));
        //     localStorage.setItem("sale_sum", JSON.stringify(sale_sum));
        //    }
           localStorage.setItem("transaction_update", JSON.stringify(response.result));
           window.location.reload();
            
        },
        error : function( data ) {
            console.log( 'Error…' );
        }
    });
});


    //reload page after remove item from cart
    
    $('.woocommerce-cart-form__cart-item .product-remove > a').click(function() {
        if($('.pdts_content .cart_item').length == 1){
            $( document.body ).trigger( 'wc_fragment_refresh' );
            setTimeout(function() { 
                location.reload();
            }, 1000);
        }
    });
    //promotion banner
    if (sessionStorage.getItem('bannerOnce') != 'true') {
        $('.promotion_banner').show();
    }
    else{   
        $('.promotion_banner').hide();
    }
    
    $('.promotion_banner_close_button').click(function() {
        $(this).closest('.promotion_banner').hide();
        sessionStorage.setItem('bannerOnce','true');
    });


    //change coupon location in checkout
    var coupon = $(".woocommerce-form-coupon");
    coupon.insertAfter('.shop_table.woocommerce-checkout-review-order-table');

  


    

    // $(".banner_row_5").height(function() {
    //     return $(this).prev('.search_suggestions_product').find('.box_product .thumbnail').height();
    // });

    //open mobile menu
    $('button.menu-toggle').click(function(e) {
        //e.preventDefault();
        $("#primary-right-menu").toggleClass('mobile_menu_open');
        $(".right-navigation.main-navigation").toggleClass('header_mobile_nav_open');
        if($("#primary-right-menu").hasClass('mobile_menu_open')){
            $('body').addClass("fixed-position");
        }
        else{
            $('body').removeClass("fixed-position");
        }
        if($('.open_menu_account_mobile').length){
            $('.account_menu_wrapper').removeClass('open_menu_account_mobile');
        }
    });



    if($(window).width() < 1024){
        $('#primary-right-menu > .menu-item-has-children > a').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.menu-item-has-children').toggleClass('sub_menu_opened');
            if($(this).closest('.menu-item-has-children').hasClass('sub_menu_opened')){
                $(this).closest('.menu-item-has-children').siblings().hide();
            }
            else{
                $(this).closest('.menu-item-has-children').siblings().show();
            }
            
            $(this).toggleClass('sub_menu_opened');
            if($(this).hasClass('sub_menu_opened')){
                $(this).css('top', $('.top_banner_wrapper').height());
            }
            else{
                $(this).css('top', "0");
            }
            $(this).next('ul.sub-menu').toggleClass('sub_menu_open');
        });

        $('a.sub_menu_opened').click(function(e) {
            $(this).closest('.menu-item-has-children').removeClass('sub_menu_opened');
            $(this).removeClass('sub_menu_opened');
            $(this).next('ul.sub-menu').removeClass('sub_menu_open');
        });

        $('.site-header .main_menu_wrapper nav.main-navigation.right-navigation ul ul ul li.menu-item-has-children > a, .footer-menu li.menu-item-has-children > a').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var parent_li = $(this).closest('li.menu-item-has-children').closest('ul').closest('li.menu-item-has-children');
            if(parent_li.siblings('.menu-item-has-children').find('.inner_sub_menu_open ').is(':visible')){
                parent_li.siblings('.menu-item-has-children').find('.inner_sub_menu_open ').find('ul').slideUp();
                parent_li.siblings('.menu-item-has-children').find('li.menu-item-has-children').removeClass('inner_sub_menu_open');
            }
            // if($(this).closest('li.menu-item-has-children').closest('li.menu-item-has-children').siblings('li.menu-item-has-children').find('ul.sub-menu').is(':visible')){
            //     $(this).closest('li.menu-item-has-children').closest('li.menu-item-has-children').siblings('li.menu-item-has-children').find('ul.sub-menu').slideToggle();
            // }
            $(this).closest('li.menu-item-has-children').toggleClass('inner_sub_menu_open');
           
            $(this).next('ul.sub-menu').slideToggle();
        });

       
    }

    $('.register_modal_btn').on("click", function(event){
        event.preventDefault();
        event.stopPropagation();
        $("#register_modal").toggleClass('is_modal_showing');
        $('body').toggleClass('is_register_modal_open');
    });

    if (window.location.href.indexOf("branch") > -1 || $('body.page-template-register').length > 0) {
        $("#register_modal").toggleClass('is_modal_showing');
        $('body').toggleClass('is_register_modal_open');
        $("#reg_birthday").datepicker({
            dateFormat: "dd/mm/yy",
            changeYear: true,
            yearRange: "1930:2023"
        });
    }

    $( "#register_modal .close" ).on("click", function(event){
        $('body').removeClass('is_register_modal_open');
    });
    
    
});









  

  
