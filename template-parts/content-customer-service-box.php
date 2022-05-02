<div class="box_customer_service_wrap">
    <div class="top_msg">
        <h3><?php echo get_field('desc_no_msg', 'option'); ?></h3>
        <?php 
        $link = get_field('link_customer_service', 'option'); 
        //print_r(	$link );
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
        <div class="arrow_btn">
        <a class="button-secondary " href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
            <span class="button_label"><?php echo esc_html( $link_title ); ?></span>
            <span class="btn_icon">
                <svg focusable="false" class="c-icon icon--arrow-button" viewBox="0 0 42 10" width="15px" height="15px">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M40.0829 5.5H0V4.5H40.0829L36.9364 1.35359L37.6436 0.646484L41.9971 5.00004L37.6436 9.35359L36.9364 8.64649L40.0829 5.5Z" fill="currentColor"></path>
                </svg>
            </span>
        </a>
        </div>
        
    </div>
    <dl>
        <div class="row_wrapper">
            <dd><?php esc_html_e( 'טלפון:', 'gant' ); ?></dd>
            <dt>
                <a href="tel:<?php echo get_field('tel_customer_service', 'option') ?>">
                    <?php echo get_field('tel_customer_service', 'option') ?>
                </a>
            </dt>
        </div>
        <div class="row_wrapper customer_mail_wrap">
            <dd><?php esc_html_e( 'אמייל:', 'gant' ); ?></dd>
            <dt>
                <a href = "mailto:<?php echo get_field('email_customer_service', 'option') ?>">
                    <?php echo get_field('email_customer_service', 'option') ?>
                </a>
            </dt>
        </div>
    </dl>
    <div class="hours_customer_service">
        <?php echo get_field('open_hours_customer_service', 'option') ?>
    </div>
</div>