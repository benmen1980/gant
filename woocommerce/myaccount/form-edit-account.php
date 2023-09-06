<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>
<div class="step3-form">
	<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
		
		<?php if(is_user_logged_in() && (get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1) && empty( get_user_meta( get_current_user_id(), 'sms_code', true ))): ?>
			<div class="modal is_modal_showing" id="validation_phone_modal">
				<div class="modal_container">
			
					<header class="section_header">
						<h3><?php echo __('אימות מספר טלפון', 'gant') ?></h3>
						<!-- <button type="button" tabindex="0" aria-label="סגור" class="close">
							<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
							</svg>
						</button> -->
					</header>
					<div class="modal_content" role="dialog">
						<div class="validation_token_wrapper">
							<button type="button" class="send_validation_sms" data-phone="<?php echo wp_get_current_user()->user_login; ?>">
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
					</div>
				</div>
				<div class="modal_bg"></div>
			</div>
		<?php endif;?>

		<?php if(is_user_logged_in() && (get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1)): ?>
			<div class="modal" id="validation_user_details_modal">
				<div class="modal_container">
			
					<header class="section_header">
						<h2><?php echo __('אימות  מועדון', 'gant') ?></h2>
						<button type="button" tabindex="0" aria-label="סגור" class="close">
							<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
							</svg>
						</button>
					</header>
					<div class="modal_content" role="dialog" id="msg_is_club">
						<h3>
							<?php esc_html_e( 'שלום', 'gant' ); ?>
							<?php echo wp_get_current_user()->user_firstname ?>
						</h3>
						<?php echo get_field('popup_content_is_club','option'); ?>
						<button type="button" class="button-secondary confirmation_btn">
							<span class="button_label">
								<?php esc_html_e( 'אישור', 'gant' ); ?>
							</span>
						</button>
					</div>
			
				</div>
				<div class="modal_bg"></div>
			</div>
		<?php endif;?>
		<!-- <div class="modal" id="validation_user_details_modal">
			<div class="modal_container">
		
				<header class="section_header">
					<h3><?php echo __('אישור פרטי חשבון', 'gant') ?></h3>
					<button type="button" tabindex="0" aria-label="סגור" class="close">
						<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
						</svg>
					</button>
				</header>
				<div class="modal_content" role="dialog">
					<h3><?php echo get_field('popup_content','option'); ?></h3>
					<button type="button" class="button-secondary confirmation_btn">
						<span class="button_label">
							<?php esc_html_e( 'אישור', 'gant' ); ?>
						</span>
					</button>
				</div>
			</div>
			<div class="modal_bg"></div>
		</div> -->
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
			<label for="account_display_name"><?php esc_html_e( 'שם משתמש', 'gant' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span class="msg_under_input"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_email bgg">
				<?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span>
			</label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
			<?//php if(get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1): ?>
			<span class="msg_under_input">
				<em><?php echo "אנא תבדוק שכתובת המייל תקינה ";?></em>
			</span>
			<?//php endif;?>
		</p>

		<div class="clear"></div>
		<?php 
		     $encryption_key = "my_secret_key";

			 // Get the encrypted number from the session
			 $encrypted_number = $_SESSION['encrypted_number'];

			 // Decrypt the number using the AES algorithm
			 $user_password = openssl_decrypt($encrypted_number, "AES-256-CBC", $encryption_key);
		 ?>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current">
				<?php if(get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1): ?>
					<?php esc_html_e( 'Current password', 'woocommerce' ); ?>
				<?php else:?>
					<?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>
				<?php endif;?>
			</label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" value="<?php echo (get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1) ? $user_password : ''; ?>"/>
		</p>
		<div class="clear"></div>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_1">
			<?php if(get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1): ?>
				<?php esc_html_e( 'New password', 'woocommerce' ); ?>
				<span class="required">*</span>
				
			<?php else:?>
				<?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?>
			<?php endif;?>
			</label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
			<?php if(get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1): ?>
				<span class="msg_under_input"><em><?php esc_html_e( 'חובה להזין סיסמה חדשה', 'gant' ); ?></em></span>
			<?php endif;?>
			</p>
		<div class="clear"></div>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_2">
				<?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?>
			</label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
		</p>
		
		
		<!-- <div class="clear"></div>
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-wide">
			<label for="account_id"><?php esc_html_e( 'ת"ז', 'gant' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" required class="woocommerce-Input woocommerce-Input--id input-text" name="account_id" id="account_id" value="" />
		</p> -->
		<?php if(get_user_meta( get_current_user_id(), 'has_to_edit_details', true ) == 1): ?>
			<div class="clear"></div>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="edit_birthday"><?php esc_html_e( 'תאריך לידה', 'gant' ); ?> <span class="required">*</span></label>
				<input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="reg_birthday" id="edit_birthday" autocomplete="reg_birthday" value="<?php echo ( ! empty( $_POST['reg_birthday'] ) ) ? esc_attr( wp_unslash( $_POST['reg_birthday'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<div class="clear"></div>
			<?php if(false): ?>
				<div class="row_checkbox_wrapper condition_accept_wrapper">
					<span class="woocommerce-input-wrapper checkbox_wrapper">
						<input id="read_club_condition" type="checkbox" name="read_club_condition" <?php  checked( get_user_meta( $user->ID, 'read_club_condition', true ), '1' ); ?>>	
						<label for="read_club_condition">
							<?php echo get_field('checkbox_read_club_condition','option');?>
							<span class="required">*</span>
						</label>
					</span>
				</div>
				<div class="clear"></div>
			<?php endif;?>
			<div class="row_checkbox_wrapper condition_accept_wrapper">
				<span class="woocommerce-input-wrapper checkbox_wrapper">
					<input id="confirm_club_registration"  type="checkbox" name="want_club_registration"   <?php  checked( get_user_meta( $user->ID, 'want_club_registration', true ), '1' ); ?> >	
					<label for="confirm_club_registration">
						<?php echo get_field('checkbox_read_club_condition','option');?>
						<?//php esc_html_e( 'אישור  חברות למועדון', 'gant' );?>
						<span class="required">*</span>
					</label>
				</span>
			</div>
			<div class="clear"></div>
			<div class="row_checkbox_wrapper condition_accept_wrapper">
				<span class="woocommerce-input-wrapper checkbox_wrapper">
					<input id="agree_business_owner" type="checkbox" name="agree_business_owner"   <?php  checked( get_user_meta( $user->ID, 'agree_business_owner', true ), 'on' ); ?> >	
					<label for="agree_business_owner">
						<?php echo get_field('checkbox_privacy','option');?>
					</label>
				</span>
			</div>
			<div class="clear"></div>
			<div class="row_checkbox_wrapper condition_accept_wrapper">
				<span class="woocommerce-input-wrapper checkbox_wrapper">
					<input id="read_site_condition" type="checkbox" name="read_site_condition" <?php  checked( get_user_meta( $user->ID, 'read_site_condition', true ), '1'); ?>>	
					<label for="read_site_condition">
						<?php echo get_field('checkbox_read_site_condition','option');?>
						<span class="required">*</span>
					</label>
				</span>
			</div>
			<input type="hidden" name="edit_account_validation_code" class="edit_account_validation_code" value="">
		<?php endif;?>
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
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>




