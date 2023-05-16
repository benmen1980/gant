<?php 
$user = wp_get_current_user(); 
?>
<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-wide">
    <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" required class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-wide">
    <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" required class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" required class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" /> <span class="msg_under_input"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
</p>
<div class="clear"></div>

<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="email" required class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-wide">
    <label for="account_id"><?php esc_html_e( 'ת"ז', 'gant' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" required class="woocommerce-Input woocommerce-Input--id input-text" name="account_id" id="account_id" value="" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide paswd_edit_input hhh">
    <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide paswd_edit_input">
    <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
</p>
<div class="clear"></div>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide paswd_edit_input">
    <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
</p>

<div class="clear"></div>
<p class="row_checkbox_wrapper">
    <span class="woocommerce-input-wrapper checkbox_wrapper">
        <input type="checkbox" name="agree_business_owner">	
        <label for="agree_business_owner">
            <?php echo get_field('checkbox_privacy','option');?>
        </label>
    </span>
</p>
<div class="clear"></div>
<input type="hidden" name="edit_account_validation_code" class="edit_account_validation_code">
<?php do_action( 'woocommerce_edit_account_form' ); ?>

<p class="submit_wrap">
    <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
    <button type="submit" class="save_account_details woocommerce-Button button-secondary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>">
    <span class="button_label"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></span>
    </button>
    <input type="hidden" name="action" value="save_account_details" />
</p>

<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>