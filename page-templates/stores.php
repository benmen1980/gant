<?php
/*
Template Name: Stores Page

*/

get_header();
?>
<header>
    <h1><?php echo get_field('title') ?></h1>
</header>
<div class="stores_page">
    <div class="r_side">
        <div class="accordion">
            <?php 
                if( have_rows('stores') ) {
                    // while has rows
                    $counter =0;while( have_rows('stores') ) {
                        // instantiate row
                        the_row(); 
                        $store_name = get_sub_field('store_name');
                        $store_active = get_sub_field('store_active');
                        $store_address = get_sub_field('address');
                        $hours1 = get_sub_field('hours1');
                        $hours2 = get_sub_field('hours2');
                        $hours3 = get_sub_field('hours3');
                        $hours4 = get_sub_field('hours4');
                        $hours5 = get_sub_field('hours5');
                        $hours6 = get_sub_field('hours6');
                        $hours7 = get_sub_field('hours7');
                        $longtitude = get_sub_field('longtitude');
                        $latitude = get_sub_field('latitude');
                        $phone = get_sub_field('telephone');
                    ?>
                    <?php if($store_active == 1){ ?>
                        <div class="section">
                            <a class="section-title" href="#store-<?php echo $counter ?>" title="<?php echo $store_name; ?>">
                                <div class="section-title-content">
                                    <h3><?php echo $store_name; ?></h3>
                                    <address><?php echo $store_address; ?></address>
                                   
                                </div>
                            </a>
                            <a class="waze-ico" href="waze://?ll=<?php echo $longtitude;?>,<?php echo $latitude ?>"></a>
                            <div id="store-<?php echo $counter ?>" class="section-content">
                                <dl>
                                    <div class="day_wrapper">
                                        <dt><?php esc_html_e( 'יום ראשון:', 'gant' ) ?></dt>
                                        <dd><?php echo $hours1; ?></dd>
                                    </div>
                                    <div class="day_wrapper">
                                        <dt><?php esc_html_e( 'יום שני:', 'gant' ) ?></dt>
                                        <dd><?php echo $hours2; ?></dd>
                                    </div>
                                    <div class="day_wrapper">
                                        <dt><?php esc_html_e( 'יום שלישי:', 'gant' ) ?></dt>
                                        <dd><?php echo $hours3; ?></dd>
                                    </div>
                                    <div class="day_wrapper">
                                        <dt><?php esc_html_e( 'יום רביעי:', 'gant' ) ?></dt>
                                        <dd><?php echo $hours4; ?></dd>
                                    </div>
                                    <div class="day_wrapper">
                                        <dt><?php esc_html_e( 'יום חמישי:', 'gant' ) ?></dt>
                                        <dd><?php echo $hours5; ?></dd>
                                    </div>
                                    <div class="day_wrapper">
                                        <dt><?php esc_html_e( 'יום שישי:', 'gant' ) ?></dt>
                                        <dd><?php echo $hours6; ?></dd>
                                    </div>
                                    <?php if(!empty($hours7)): ?>
                                        <div class="day_wrapper">
                                            <dt><?php esc_html_e( 'יום שבת:', 'gant' ) ?></dt>
                                            <dd><?php echo $hours7; ?></dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                                <?php if(!empty($phone)){ ?>
                                    <?php if(wp_is_mobile()): ?>
                                        <a class="button-secondary" href="tel:+<?php echo $phone;?>" title="<?php esc_html_e( 'התקשר לחנות', 'gant' ) ?>">
                                            <span class="button_label"><?php esc_html_e( 'התקשר לחנות', 'gant' ) ?></span>
                                        </a>
                                    <?php else:?>
                                        <label  class="store_tel"><?php esc_html_e( 'טלפון:', 'gant' ) ?></label>
                                        <a class="button-secondary" href="tel:+<?php echo $phone;?>" title="<?php esc_html_e( 'התקשר לחנות', 'gant' ) ?>">
                                            <span class="button_label"><?php echo $phone;?></span>
                                        </a>
                                    <?php endif;?>
                                <?php } ?>
                                <?php $stores_collection =  get_sub_field('stores_collection');
                           ?>
                                <?php if(!empty($stores_collection)): ?>
                                    <div class="stores_collection_wrapper">
                                    <dl>
                                        <dt> <?php  echo get_field_object('field_622f449a3b536')['label']; ?></dt>
                                        <dd>
                                            <?php  echo implode( ', ', $stores_collection ); ?>
                                        </dd>
                                    </dl>
                                    
                                    </div>
                                <?php endif; ?>
                                <p class="accsessibility_txt">
                                
                                    <?php echo get_field('accessibility_text'); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>                    
                    
                    <?php $counter++;}
                }
            ?>
        </div>
    </div>
    <div class="l_side">
        <img src="<?php echo get_field('store_image'); ?>" alt="">
    </div>
</div>

<?php get_footer(); ?>
