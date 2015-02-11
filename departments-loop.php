<?php
/* Main loop */
$args = array(
  'posts_per_page '=> 1,
  'tax_query' => array(
    array(
      'taxonomy' => 'departments',
      'field'    => 'slug',
      'terms'    => 'chair',
      ),
    ),
  );
$query = new WP_Query($args);
    while ($query->have_posts()) :
      $query->the_post();
      $do_not_duplicate = $post->ID;

            /* to display other post types */
            get_template_part("templates/departments");

    endwhile;

if (have_posts()) :
    while (have_posts()) :
        the_post();

        if ( $post->ID == $do_not_duplicate )
         continue;
            get_template_part("templates/departments");


    endwhile;
    global $wp_query;
    inspiry_pagination($wp_query);
else :
    nothing_found(__('No Post Found!', 'framework'));
endif;
?>
