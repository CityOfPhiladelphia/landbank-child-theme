<?php
get_header();
get_template_part('template-parts/banner');
?>
<div class=" page-top clearfix">
    <div class="container">
        <div class="row">
            <div class="<?php bc('9', '8', '12', ''); ?>">
                <nav class="bread-crumb">
                    <?php theme_breadcrumb(); ?>
                </nav>
            </div>
            <div class="<?php bc('3', '4', '12', ''); ?>">
                <?php get_template_part('search-form'); ?>
            </div>
        </div>
    </div>
</div>
<div class="blog-page clearfix">
    <div class="container">
        <div class="row">
            <div class="<?php bc('9', '8', '12', ''); ?>">
                <div class="blog-post-single clearfix">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?> >
                                <div class="right-contents">
                                    <header class="entry-header">
                                        <?php
                                        /* Get post header based on format */
                                        $format = get_post_format($post->ID);
                                        if (false === $format) {
                                            $format = 'standard';
                                        }
                                        get_template_part("post-formats/$format");

                                        if ( $format !== 'link' && $format !== 'quote' ) {
                                            ?>
                                            <h1 class="entry-title"><?php the_title(); ?></h1>

                                            <?php
                                        }

                                        if(function_exists(rwmb_meta) && (rwmb_meta( 'lb_job_title' ) != '') ){
                                          echo '<p><strong>Title:</strong> ' . rwmb_meta( 'lb_job_title' ) . '</p>';
                                       }
                                      ?>
                                    </header>

                                    <div class="entry-content">
                                        <?php
                                        /* output post contents */
                                        the_content();

                                        // WordPress Link Pages
                                        wp_link_pages(array('before' => '<div class="page-nav-btns clearfix">', 'after' => '</div>', 'next_or_number' => 'next'));
                                        ?>
                                    </div>

                                    <footer class="entry-footer">
                                        <p class="entry-meta">
                                            <span class="entry-categories">
                                                <i class="fa fa-folder-o"></i>&nbsp;
                                                <?php
                                                $terms = get_the_terms( $post->ID , 'departments' );
                                                  foreach ( $terms as $term ) {
                                                    echo $term->name . ' ';
                                                  //  echo implode( ', ',  $term->name )
                                                  }
                                                  ?>
                                            </span>
                                        </p>
                                    </footer>
                                </div>
                            </article>
                        <?php
                        endwhile;
                    endif;
                    ?>
                </div>

            </div>

            <div class="<?php bc('3', '4', '12', ''); ?>">
                <?php get_sidebar(); ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
