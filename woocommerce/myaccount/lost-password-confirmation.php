<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

defined( 'ABSPATH' ) || exit;

?>


<div class="modal is_modal_showing" id="password_confirmation_modal">
    <div class="modal_container">
        <header class="section_header">
            <h3>אפס את הסיסמה</h3>
            <button type="button" tabindex="0" aria-label="סגור" class="redirect_my_account">
                <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                </svg>
            </button>
        </header>
        <div class="modal_content" role="dialog">
            <?php 
            wc_print_notice( esc_html__( 'Password reset email has been sent.', 'woocommerce' ) );
            ?>
            <?php do_action( 'woocommerce_before_lost_password_confirmation_message' ); ?>

            <p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ) ); ?></p>

            <?php do_action( 'woocommerce_after_lost_password_confirmation_message' ); ?>
        
            
        </div>
    
    </div>
    <div class="modal_bg"></div>
</div>
<?php do_action( 'woocommerce_after_lost_password_confirmation_message' ); ?>
