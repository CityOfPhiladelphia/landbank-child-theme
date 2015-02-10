<?php
/*
 *  Template Name: Home Template - Landbank
 */

global $theme_options;

/* Include Header */
get_header();

/* Slider */
if ($theme_options['display_slider_on_home'] == '1') {
    if($theme_options['slider_type'] == '2'){
        $revolution_slider_alias = $theme_options['revolution_slider_alias'];
        if( function_exists('putRevSlider') && (!empty($revolution_slider_alias)) ){
            putRevSlider( $revolution_slider_alias );
        } else {
            get_template_part('template-parts/banner');
        }
    }else{
        get_template_part('template-parts/home-slider');
    }
} else {
    get_template_part('template-parts/banner');
}

/* Appointment Form - As separate section below slider */
if (($theme_options['display_appointment_form'] == '1') && ($theme_options['appointment_form_variation'] == '3')) {
    get_template_part('template-parts/appoint-form');
}
/* Home page contents from page editor */
if (have_posts()):
    while (have_posts()):
        the_post();
        $content = get_the_content();
        if (!empty($content)) {
            ?>
            <div class="default-contents">
                <div class="container">
                    <div class="row">
                        <div class="<?php bc_all('12'); ?>">
                            <article <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php
                                    /* output page contents */
                                    the_content();
                                    ?>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    endwhile;
endif;
?>
<div class="home-search">
    <div class="container">
        <div class="row">
          <div class="<?php bc_all('12'); ?>">
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
    </div>
<?php


/* Home Features */
if ($theme_options['display_features_section'] == '1') {
    if( $theme_options['features_variation'] == '1'){
        get_template_part('template-parts/home-features-one');
    }else if( $theme_options['features_variation'] == '2'){
        get_template_part('template-parts/home-features-two');
    }if( $theme_options['features_variation'] == '3'){
        get_template_part('template-parts/home-features-three');
    }
}

/* Doctors Section */
if ($theme_options['display_doctors_section'] == '1') {
    get_template_part('template-parts/home-doctors');
}

/* Services Section */
if ($theme_options['display_services_section'] == '1') {
    get_template_part('template-parts/home-services');
}

/* News Section */
if ($theme_options['display_news_section'] == '1') {
    get_template_part('template-parts/home-blog');
}

/* Testimonials Section */
if ($theme_options['display_testimonials_section'] == '1') {
    get_template_part('template-parts/home-testimonial');
}

/* Include Footer */
get_footer();
?>
