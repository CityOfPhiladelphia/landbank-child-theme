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

if (!class_exists('LandbankCustomPostTypes')){
    class LandbankCustomPostTypes{
        function create_person_profile() {
          register_post_type( 'person_page',
            array(
                'labels' => array(
                    'name' => __( 'Person Profile' ),
                    'singular_name' => __( 'Person Profile' ),
                    'add_new'   => __('Add Person Profile'),
                    'all_items'   => __('All Person Profiles'),
                    'add_new_item' => __('Add Person Profile'),
                    'edit_item'   => __('Edit Person Profile'),
                    'view_item'   => __('View Person Profile'),
                    'search_items'   => __('Search Person Profiles'),
                    'not_found'   => __('Person Profile Not Found'),
                    'not_found_in_trash'   => __('Person Profile not found in trash'),
              ),
                'taxonomies' => array(''),
                'public' => true,
                'supports' => array(
                  'title',
                  'editor',
                  'thumbnail'
                  ),
                'has_archive' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-businessman',
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => '',
                ),
            )
          );
        }

    }//end class

}


if (class_exists("LandbankCustomPostTypes")){
    $custom_post_types = new LandbankCustomPostTypes();
}

if (isset($custom_post_types)){
    //actions
    add_action( 'init', array($custom_post_types, 'create_person_profile'));

    register_activation_hook( __FILE__, array($custom_post_types, 'rewrite_flush') );
}

/*-----------------------------------------------------------------------------------*/
/*	Remove unnecessary post types
/*-----------------------------------------------------------------------------------*/

function remove_medical_press_theme_features() {
   // remove Movie Custom Post Type
   remove_action( 'init', 'create_doctor_post_type' );
   remove_action( 'init', 'create_gallery_post_type' );
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
                      'with_front' => false, // Don't display the category base before "/topics/"
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
