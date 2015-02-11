<?php
/* common excerpt template for search results */
global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?>>

    <!-- main contents -->
    <div class="main-contents">
      <?php
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
          the_post_thumbnail('thumbnail', array( 'class' => 'alignleft' ) );
        }
      ?>
        <header class="entry-header">
            <h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <?php if(function_exists(rwmb_meta) && (rwmb_meta( 'lb_job_title' ) != '') ){
              echo '<p><strong>Title:</strong> ' . rwmb_meta( 'lb_job_title' ) . '<br>';
            }
            if(function_exists(rwmb_meta) && (rwmb_meta( 'lb_committees' ) != '') ){
              echo '<strong>Committees:</strong> ' . rwmb_meta( 'lb_committees' ) . '</p>';
            }
            ?>
        </header>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>

    </div>

</article>
