<?php
/*
Template Name: Login Validation Page

*/

get_header();

?>
<div class="post-11">
    <div class="entry-content">
        <div class="woocomerce">
            <div class="validation_login_wrapper">
                <h1><?php esc_html_e( 'בדיקת חברות למועדון', 'gant' ); ?></h1>

                <form class="woocommerce-form woocommerce-form-login login" method="post">

                    <h2><?php esc_html_e( ' על מנת שנוכל לזהות אתכם, אנא רשמו את הפרטים הבאים:', 'gant' ); ?></h2>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="validate_id"><?php esc_html_e( 'ת.ז.', 'gant' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="validate_id" id="validate_id"  />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="validate_phone"><?php esc_html_e( 'מספר טלפון', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="validate_phone" id="validate_phone" />
                    </p>
                    <div class="login_validation_btn">
                        <button type="button" class="user_validation_phone_id button-secondary" data-phone="" >
                            <span class="button_label">
                                <?php esc_html_e( 'אימות פרטים', 'gant' ); ?>
                            </span>
                        </button>
                    </div>
                    <input type="hidden" name="form_submitted" value="1">
                    <?php if(false): ?>
                        <div class="login_validation_btn">
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
                    <?php endif; ?>
                    


                

                </form>

                <div class="modal" id="check_club_details_msg_modal">
                    <div class="modal_container">
                
                        <header class="section_header">
                            <h2><?php echo __('אימות  מועדון', 'gant') ?></h2>
                            <button type="button" tabindex="0" aria-label="סגור" class="close">
                                <svg focusable="false" class="c-icon icon--close" viewBox="0 0 26 27" width="12" height="12">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 14.348l11.445 11.685L26 24.445 14.555 12.761 25.5 1.588 23.944 0 13 11.173 2.056 0 .501 1.588 11.445 12.76 0 24.444l1.555 1.588L13 14.348z" fill="currentColor"></path>
                                </svg>
                            </button>
                        </header>
                        <div class="modal_content" role="dialog" id="msg_not_club">
                            <?php echo get_field('popup_content_no_club','option'); ?>
                        </div>
                        <div class="modal_content" role="dialog" id="msg_data_not_match">
                            <?php echo get_field('popup_content_error_data','option'); ?>
                        </div>
                        <div class="modal_content" role="dialog" id="msg_data_not_exist">
                            <?php echo get_field('popup_content_error_data_not_exist','option'); ?>
                        </div>
                    </div>
                    <div class="modal_bg"></div>
                </div>
                <?php if(false): ?>
                    <div class="modal" id="validation_phone_modal">
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
