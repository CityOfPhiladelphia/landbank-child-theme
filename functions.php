<?php
/**

Custom function for filtering the sections array. Good for child themes to override or add to the sections.

NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
so you must use get_template_directory_uri() if you want to use any of the built in icons
**/

// REMOVE COMMENTS AROUND THIS FUNCTION IF YOU WANT TO PLAY WITH THEME OPTIONS
/*
function dynamic_section($sections) {
    //$sections = array();
    $sections[] = array(
        'title' => __('Section via hook', 'framework'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'framework'),
        'icon' => 'el-icon-paper-clip',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
*/

/**
 *  Create Custom Post Types
 *
 * Additional custom post types can be defined here
 * http://codex.wordpress.org/Post_Types
 *
 * @link https://github.com/kdemi/business-services-child-theme
 *
 *
 */

/**
 * Filter the upload size limit for non-administrators.
 *
 * @param string $size Upload size limit (in bytes).
 * @return int (maybe) Filtered size limit.
 */
function filter_site_upload_size_limit( $size ) {
    // Set the upload size limit to 10 MB for users lacking the 'manage_options' capability.
    if ( current_user_can( 'manage_options' ) ) {
        // 20 MB.
        $size = 1024 * 40000;
    }
    return $size;
}
add_filter( 'upload_size_limit', 'filter_site_upload_size_limit', 20 );

/*-----------------------------------------------------------------------------------*/
/*	Remove unnecessary post types
/*-----------------------------------------------------------------------------------*/

function remove_medical_press_theme_features() {
   // remove Movie Custom Post Type
   remove_action( 'init', 'create_doctor_post_type' );
   remove_action( 'init', 'create_gallery_post_type' );
	remove_action( 'init', 'create_service_post_type' );
}

add_action( 'after_setup_theme', 'remove_medical_press_theme_features', 10 );

/*-----------------------------------------------------------------------------------*/
/* Custom Taxonomy
/*-----------------------------------------------------------------------------------*/

if (!class_exists("LandbankCustomTax")){
    class LandbankCustomTax {
            function add_custom_taxonomies() {
                register_taxonomy('departments',
                    array(
                        'person_page'
                    ), array(
                        'hierarchical' => true,
                        // This array of options controls the labels displayed in the WordPress Admin UI
                        'labels' => array(
                            'name' => _x( 'Department', 'taxonomy general name'),
                            'singular_name' => _x( 'Department', 'taxonomy singular name'),
                            'menu_name' =>     __('Departments'),
                            'search_items' =>  __( 'Search Departments' ),
                            'all_items' =>     __( 'All Departments' ),
                            'edit_item' =>     __( 'Edit Departments' ),
                            'update_item' =>   __( 'Update Departments' ),
                            'add_new_item' =>  __( 'Add New Department' ),
                            'new_item_name' => __( 'New Department Name' ),
                            'menu_name' =>     __( 'Departments' ),
                        ),
                    'public' => true,
                    'show_admin_column' => true,
                    // Control the slugs used for this taxonomy
                    'rewrite' => array(
                      'slug' => '', // This controls the base slug that will display before each term
                      'with_front' => false, // Don't display the category base before
                      'hierarchical' => true // This will allow URL's like "/topics/water/billing"
                    ),
                    'capabilities' => array(
                       //TODO decide who can do what with this tax
                    ),
              ));
            }
    }//end PhilaGovCustomTax
}

//create instance of PhilaGovCustomTax
if (class_exists("LandbankCustomTax")){
    $landbank_tax = new LandbankCustomTax();
}

if (isset($landbank_tax)){
    //WP actions
    add_action( 'init', array($landbank_tax, 'add_custom_taxonomies'), 0 );
}

/*-----------------------------------------------------------------------------------*/
/*	Theme Breadcrumb
/*-----------------------------------------------------------------------------------*/

if (!function_exists('theme_breadcrumb')) {
    function theme_breadcrumb()
    {

        echo '<ul class="breadcrumb clearfix">';

        /* For all pages other than front page */
        if (!is_front_page()) {
            echo '<li>';
            echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>';
            echo '<span class="divider"></span></li>';
        }

        /* For index.php OR blog posts page */
        if (is_home()) {
            $page_for_posts = get_option('page_for_posts');
            if ($page_for_posts) {
                $blog = get_post($page_for_posts);
                echo '<li>';
                echo $blog->post_title;
                echo '</li>';
            } else {
                echo '<li>';
                _e('Blog', 'framework');
                echo '<li>';
            }
        }

        if (is_category() || is_singular('post')) {
            $category = get_the_category();
            $ID = $category[0]->cat_ID;
            echo '<li>';
            echo get_category_parents($ID, TRUE, ' <span class="divider"></span></li><li>', FALSE);
        }

        if (is_tax('gallery-item-type') || is_tax('department')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            if (!empty($current_term->name)) {
                echo '<li class="active">';
                echo $current_term->name;
                echo '</li>';
            }
        }

        if (is_singular('post') || is_singular('doctor') || is_singular('service') || is_singular('gallery-item') || is_page() || is_singular('person_page') ) {
            global $post;
            $parent_id = $post->post_parent;
            if(  is_page() && $parent_id ){
                $parents = array();
                while ( $parent_id ) {
                    $parents[] = $parent_id;
                    $page = get_post( $parent_id );
                    $parent_id = $page->post_parent;
                }
                $parents_count = count( $parents );
                for( $i = $parents_count; $i > 0; ){
                    $parent_id = $parents[--$i];
                    echo '<li>';
                        echo '<a href="' . get_the_permalink( $parent_id ) . '">' ;
                        echo get_the_title( $parent_id );
                        echo '</a>';
                        echo '<span class="divider"></span>';
                    echo '</li>';
                }
            }

            echo '<li class="active">';
            the_title();
            echo '</li>';
        }

        if (is_tag()) {
            echo '<li>';
            _e('Tag: ', 'framework');
            echo single_tag_title('', FALSE);
            echo '</li>';
        }

        if (is_404()) {
            echo '<li>';
            _e('404 - Page not Found', 'framework');
            echo '</li>';

        }

        if (is_search()) {
            echo '<li>';
            _e('Search', 'framework');
            echo '</li>';
        }

        if (is_year()) {
            echo '</li>';
            echo get_the_time('Y');
            echo '</li>';
        }

        echo "</ul>";

    }
}
//[feedback_link]
function feedback_shortcode_function( $atts ){

	$full_url =  "https://docs.google.com/forms/d/1howWdLf1j0VtjRdkUsehYl9x6g-zdGyOuv6iEQ8wimY/viewform?entry.893934780&entry.526820711=" . "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $full_url;
}
add_shortcode( 'feedback_link', 'feedback_shortcode_function' );

