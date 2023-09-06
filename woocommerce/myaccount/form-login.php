<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


		
do_action( 'woocommerce_before_customer_login_form' ); 

if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

<?php endif; ?>

		<h1>להתחבר</h1>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'טלפון נייד', 'gant' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="link_before_submit_wrap">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
				<div class="woocommerce-LostPassword lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">שכחתי סיסמה?</a>
				</div>
			</div>

			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<div class="btns_wrapper">
				<button type="submit" class="button-secondary woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
					<span class="button_label"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></span>
				</button>
				<a class="button-primary" href="/register">
					<span class="button__label">להרשם</span>
				</a>
			</div>
			


			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
		<?//php echo do_shortcode( '[TheChamp-Login title="התחבר דרך גוגל או פייסבוק" redirect_url="'.home_url( '/overview' ).'"]' ); ?>
		<div class="modal" id="password_reset_modal">
			<div class="modal_container">
				
				<header class="section_header">
					<h3>אפס את הסיסמה</h3>
					<button type="button" tabindex="0" aria-label="סגור" class="close">
						<svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
						</svg>
					</button>
				</header>
				<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
				<?php do_action( 'woocommerce_before_lost_password_form' );?>
				<div class="modal_content" role="dialog">
					<form method="post" class="woocommerce-ResetPassword lost_reset_password">
						<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
							<label for="user_login"><?php esc_html_e( 'אימייל', 'gant' ); ?></label>
							<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
						</p>

						<div class="clear"></div>

						<?php do_action( 'woocommerce_lostpassword_form' ); ?>

						<div class="btn_wrapper">
							<input type="hidden" name="wc_reset_password" value="true" />
							<button type="submit" class="button-secondary" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>">
								<span class="button_label"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></span>
							</button>
						</div>
						<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
					</form>
					<?php do_action( 'woocommerce_after_lost_password_form' ); ?>
				</div>
			
			</div>
			<div class="modal_bg"></div>
		</div>



<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="u-column2 col-2">

		<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
