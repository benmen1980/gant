<?php
/*
Template Name: Register Page

*/

if ( is_user_logged_in() ){
    wp_redirect ( home_url("/overview") );
    exit;
}

if(isset($_GET['branch']))
{
    $registration_store = true;
    $_SESSION["branch"] = $_GET['branch'];
}
else{
    $registration_store = false;
    unset($_SESSION['branch']);
}
echo $_SESSION['branch'];
get_header();

?>

<div class="register_page">
    <div class="section_modules_wrapper">
        <?php get_template_part('modules/section','case'); ?>
    </div>
 
</div>

<div class="modal" id="register_modal">
    <div class="modal_container">
  
        <header class="section_header">
            <h3>הרשם</h3>
            <button type="button" tabindex="0" aria-label="סגור" class="close">
                <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                </svg>
            </button>
        </header>
        <?php do_action( 'woocommerce_before_customer_login_form' );?>
        <div class="modal_content" role="dialog">
            <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
        
                <?php do_action( 'woocommerce_register_form_start' ); ?>
    
                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-wide">
                    <label for="reg_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" id="reg_first_name" autocomplete="first_name" value="<?php echo ( ! empty( $_POST['first_name'] ) ) ? esc_attr( wp_unslash( $_POST['first_name'] ) ) : ''; ?>" />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-wide">
                    <label for="reg_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="last_name" id="reg_last_name" autocomplete="last_name" value="<?php echo ( ! empty( $_POST['last_name'] ) ) ? esc_attr( wp_unslash( $_POST['last_name'] ) ) : ''; ?>" />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_birthday"><?php esc_html_e( 'תאריך לידה', 'gant' ); ?> <span class="required">*</span></label>
                    <input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="reg_birthday" id="reg_birthday" autocomplete="reg_birthday" value="<?php echo ( ! empty( $_POST['reg_birthday'] ) ) ? esc_attr( wp_unslash( $_POST['reg_birthday'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>


                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
        
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e( 'טלפון נייד', 'gant' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>

                <?php endif; ?>
                <!-- <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-wide">
                    <label for="reg_billing_phone"><?php _e( 'טלפון נייד', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_phone" id="reg_billing_phone" value="<?php echo ( ! empty( $_POST['billing_phone'] ) ) ? esc_attr( wp_unslash( $_POST['billing_phone'] ) ) : ''; ?>" />
                </p> -->
                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-wide">
                    <label for="reg_id"><?php esc_html_e( 'ת"ז', 'gant' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--id input-text" name="account_id" id="reg_id" value="<?php echo ( ! empty( $_POST['account_id'] ) ) ? esc_attr( wp_unslash( $_POST['account_id'] ) ) : ''; ?>" />
                </p>


                <p class="row_checkbox_wrapper">
                    <span class="woocommerce-input-wrapper checkbox_wrapper">
                        <input id="agree_business_owner" type="checkbox" name="agree_business_owner"   <?php  checked( get_user_meta( $user->ID, 'agree_business_owner', true ), 'on' ); ?> >	
                        <label for="agree_business_owner">
                        <?php echo get_field('checkbox_privacy','option');?>
                        </label>
                    </span>
                </p>

                <p class="row_checkbox_wrapper">
                    <span class="woocommerce-input-wrapper checkbox_wrapper">
                        <input id="want_club_registration" type="checkbox" name="want_club_registration"   <?php  checked( get_user_meta( $user->ID, 'want_club_registration', true ), 1 ); ?> >	
                        <label for="want_club_registration">
                        <?php esc_html_e( 'הצטרף לחבר מועדון', 'gant' );?>
                        </label>
                    </span>
                </p>
                <div class="row_before_submit">
                    <?php echo get_field('desc_before_submit','option');?>
                </div>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                    
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                    </p>

                <?php else : ?>

                    <p class="send_pswd_msg"><?php esc_html_e( 'סיסמה תישלח לכתובת המייל שלך.', 'gant' ); ?></p>

                <?php endif; ?>
                <?php if($registration_store  == false): ?>
                    <div class="validation_token_wrapper">
                        <button type="button" class="send_validation_sms">
                        <span class="button_label">
                            <?php esc_html_e( 'שלח קוד אימות ב sms', 'gant' ); ?>
                        </span>
                        </button>
                    </div>
                    <div class="input_wrapper_validation_code">
                        <label for="validation_code">ברגעים אלה נשלח SMS עם קוד זיהוי זמני</label><br>
                        <div class="check_code_wrapper">
                            <input type="text" id="validation_code" name="validation_code" >
                            <button type="button" class="check_code"><?php esc_html_e( 'אימות', 'gant' ); ?></button>
                        </div>
                    </div>
                <?php endif; ?>

    
                <?php do_action( 'woocommerce_register_form' ); ?>
        
                <p class="woocommerce-FormRow form-row form-row-submit">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <?php if($registration_store  == true): ?>
                        <button type="submit" class="button-secondary register_btn" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
                            <span class="button_label">
                                <?php esc_html_e( 'Register', 'woocommerce' ); ?>
                            </span>
                        </button>
                    <?php endif; ?>    
                </p>
        
                <?php do_action( 'woocommerce_register_form_end' ); ?>
        
            </form>
        </div>
    </div>
    <div class="modal_bg"></div>
</div>

<?php get_footer(); 

?>
