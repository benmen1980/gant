<?php 
$user = wp_get_current_user(); 
echo 'test';die;
?>
<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-wide">
    <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-wide">
    <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span class="msg_under_input"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
</p>
<div class="clear"></div>

<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
</p>

<div class="clear"></div>

<?php do_action( 'woocommerce_edit_account_form' ); ?>

<p>
    <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
    <button type="submit" class="woocommerce-Button button-secondary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>">
    <span class="button_label"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></span>
    </button>
    <input type="hidden" name="action" value="save_account_details" />
</p>

<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>