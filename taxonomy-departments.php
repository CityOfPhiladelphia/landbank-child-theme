<?php
get_header();

get_template_part('template-parts/banner');
?>
    <div class="page-top clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc('9', '8', '7', ''); ?>">
                    <?php
                    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                    echo '<h2 class="page-title">'. $term->name . '</h2>';
                    ?>
                </div>
                <div class="<?php bc('3', '4', '5', ''); ?>">
                    <?php get_template_part('search-form'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-page clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc('9', '8', '12', ''); ?>">
                    <div class="blog-post-listing clearfix">
                        <?php get_template_part('departments-loop'); ?>
                    </div>
                </div>
                <div class="<?php bc('3', '4', '12', ''); ?>">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
