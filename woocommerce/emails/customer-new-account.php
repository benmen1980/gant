<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 6.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>

<p>באיזור האישי באתר תוכלו תמיד להתעדכן בסטטוס ההזמנה, להוסיף פריטים מועדפים לרשימה, להמשיך לקופה בצורה מהירה ולצפות בהיסטוריית ההזמנות</p>
<p>פרטי הגישה שמסרת ישמשו אותך בחיבור במהלך הצקאאוט</p>
<p style="direction:ltr"><?php printf( esc_html__( '%1$s :או בדף החשבון שלי', 'gant' ), make_clickable( esc_url( wc_customer_edit_account_url() ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<p><span style="font-weight: bold">שם משתמש:</span><span><?php echo $user_login; ?></span></p>
<p><span style="font-weight: bold">סיסמא:</span><span>הסיסמה שהגדרת בעת יצירת חשבון</span></p>
<?php if(false): ?>
	<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>
	<?php /* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */ ?>
	<p><?php printf( esc_html__( 'Thanks for creating an account on %1$s. Your username is %2$s. You can access your account area to view orders, change your password, and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_customer_edit_account_url() ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url ) : ?>
		<?php // If the password has not been set by the user during the sign up process, send them a link to set a new password ?>
		<p><a href="<?php echo esc_attr( $set_password_url ); ?>"><?php printf( esc_html__( 'Click here to set your new password.', 'woocommerce' ) ); ?></a></p>
	<?php endif; ?>
<?php endif; ?>
<?php $email_after_registration = get_field('email_after_registration', 'option'); ?>
<img alt="Welcome image SE" height="750" src="<?php echo $email_after_registration['second_image']; ?>" style="display:block;outline:none;text-decoration:none;font-size:13px;padding:0px;margin: 0;text-align:center;border:0px"/>
<p></p>
<p></p>
<p><?php echo $email_after_registration['text'] ?></p>
<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
