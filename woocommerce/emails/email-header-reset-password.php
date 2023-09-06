<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wrapper" dir="<?//php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
                        <table dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>" border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top; border-bottom: 1px solid #000;" width="600">
            
                            <tbody>
                                <tr>
                                    <td align="center" class="m_6064162303597352931link" style="font-size:0px;padding:0;word-break:break-word">
                                        <table border="0" cellpadding="0" cellspacing="0" style="color:#000000;font-family:Arial,sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none" width="100%">
                    
                                            <tbody>
                                                <tr>
                                                    <td align="left" width="100" style="text-align: right;">
                                                        <div class="link_account" >
                                                            <a href="https://dev-gant.tmpurl.co.il/my-account/" target="_blank">
                                                                <span class="btn_icon">
                                                                    <img border="0" width="10" height="12" src="<?php echo get_template_directory_uri();?>/dist/images/account.png" aria-hidden="false" alt="" style="margin-left:0;">
                                                                </span>
                                                                <span>החשבון שלי</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td align="center">
                                                        
                                                        <div id="template_header_image" >
                                                            <?php
                                                            if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
                                                                echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td align="right" width="100" style="text-align: left;">
                                                        <div class="link_site">
                                                            <a href="/" target="_blank">
                                                                לחנות
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container"  style="border:0;">
							<tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
										<tr>
											<td id="header_wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>"  style="">
												<h1 style="font-weight: bold; font-size: 40px;"><?php echo $email_heading; ?></h1>
											</td>
										</tr>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
										<tr>
											<td valign="top" id="body_content">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%" style="border-bottom: 1px solid #000;">
													<tr>
														<td valign="top">
															<div id="body_content_inner" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
