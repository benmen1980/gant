<?php
/*
Template Name: close page

*/
?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <!-- HolyClock.com <HEAD> code for dev-gant.tmpurl.co.il -->
    <script>
        /*<![CDATA[*/
        _holyclock_id = "5afa1b48ce4ac7fe1f18443494e52348";
        _holyclock_tag = '<s' + 'cript src\x3d"//www.holyclock.com/holyclock.js?' + Math.floor(+new Date / 864E5) + '">\x3c/script>';
        null !== document.cookie.match(/(?:^|;)\s*_holyclock_qr=\s*\w/) && null === window.location.hash.match(/#holyclock=qr(?=#|$)/) && document.write(_holyclock_tag); //]]>
    </script>
    <!-- HolyClock.com <HEAD> code for dev-gant.tmpurl.co.il -->
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <main class="page-close-page">
        <?php
        $img_bg = get_field('backround_img');
        $style_bg = $img_bg ? "style='background-image: url($img_bg);'" : "";
        ?>

        <div class="bk-img-shabat container" <?= $style_bg; ?>>
            <h1 class="title-shabbat"><?php echo get_field('title'); ?></h1>
            <h2 class="content-shabbat"><?php echo get_field('sub_title'); ?></h2>
            <img class="img-logo" src="<?php echo get_template_directory_uri(); ?>/dist/images/GANT-LOGO_2023_White.svg" aria-hidden="false" alt="logo" />
        </div>
    </main>
</body>

</html>