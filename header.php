<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <!-- META TAGS -->
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Title -->
    <title><?php wp_title('|', true, 'right'); ?></title>

    <!-- Define a viewport to mobile devices to use - telling the browser to assume that the page is as wide as the device (width=device-width) and setting the initial page zoom level to be 1 (initial-scale=1.0) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no" />

    <?php
    global $theme_options;
    if (!empty($theme_options['theme_favicon']) && !empty($theme_options['theme_favicon']['url'])) {
        ?>
        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo $theme_options['theme_favicon']['url']; ?>"/>
    <?php
    }
    ?>

    <!-- Style Sheet-->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"/>

    <!-- Pingback URL -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <!-- RSS -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>"/>
    <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('atom_url'); ?>"/>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <!-- Google Tag Manager [phila.gov] -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MC6CR2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MC6CR2');</script>
<!-- End Google Tag Manager -->

<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="<?php echo 'http://browsehappy.com/'; ?>">upgrade your browser</a> or <a href="<php echo 'http://www.google.com/chromeframe/?redirect=true'; ?>">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<?php
if ($theme_options['display_top_header']) {
    ?>
    <div class="header-top clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc('5', '5', '', ''); ?>">
                    <?php
                    if (!empty($theme_options['top_header_text'])) {
                        ?>
                        <p><?php echo $theme_options['top_header_text']; ?></p>
                        <?php
                    }
                    ?>
                </div>
                <?php
                if ((!empty($theme_options['header_opening_hours'])) || (!empty($theme_options['header_contact_number']))) {
                    ?>
                    <div class="<?php bc('7', '7', '', ''); ?> text-right">
                        <?php
                        /* WPML Language Switcher */
                        if($theme_options['display_wpml_flags']){
                            if(function_exists('icl_get_languages')){
                                $languages = icl_get_languages('skip_missing=0&orderby=code');
                                if(!empty($languages)){
                                    echo '<div id="inspiry_language_list"><ul class="clearfix">';
                                    foreach($languages as $l){
                                        echo '<li>';
                                        if($l['country_flag_url']){
                                            if(!$l['active']) echo '<a href="'.$l['url'].'" title="'.$l['translated_name'].'">';
                                            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['translated_name'].'" width="18" />';
                                            if(!$l['active']) echo '</a>';
                                        }
                                        echo '</li>';
                                    }
                                    echo '</ul></div>';
                                }
                            }
                        }
                        ?>
                        <p>
                            <?php
                            if (!empty($theme_options['header_opening_hours'])) {
                                _e('Opening Hours', 'framework');
                                echo ' : ';
                                echo '<span>' . $theme_options['header_opening_hours'] . '</span>';
                            }
                            if (!empty($theme_options['header_contact_number'])) {
                                echo '<br class="visible-xs" />';
                                echo '&nbsp;&nbsp;';
                                _e('Contact', 'framework');
                                echo ' : ';
                                echo '<span>' . $theme_options['header_contact_number'] . '</span>';
                            }
                            ?>
                        </p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
?>


<header id="header">
    <div class="container">
        <div class="row">
            <div class="<?php bc_all('10'); ?>">

                <!-- Website Logo -->
                <div class="logo clearfix">
                    <?php
                    if (!empty($theme_options['website_logo']['url'])) {
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo $theme_options['website_logo']['url']; ?>"
                                 alt="<?php bloginfo('name'); ?>"/>
                        </a>
                    <?php
                    } else {
                        ?>
                        <h1>
                            <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php $site_title = get_bloginfo('name'); echo strip_tags(html_entity_decode($site_title)); ?>">
                                <?php echo html_entity_decode($site_title); ?>
                            </a>
                        </h1>
                    <?php
                    }
                    ?>
                </div>

                <!-- Main Navigation -->
                <nav class="main-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'container' => false,
                        'menu_class' => 'header-nav clearfix'
                    ));
                    ?>
                </nav>

                <div id="responsive-menu-container"></div>
			</div>
			<div class="<?php bc_all('2'); ?>">
          <div id="search" class="widget clearfix">
              <form method="get" id="search-form" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                  <div>
                      <input type="text" value="<?php the_search_query(); ?>" name="s" id="search-text" placeholder="<?php _e('Search', 'framework'); ?>"/>
                      <input type="submit" id="search-submit" value=""/>
                  </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</header>
