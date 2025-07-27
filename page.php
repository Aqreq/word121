<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header text-center mb-4">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image mb-4">
                        <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', 'imagestore-pro'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="comments-section">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_sidebar();
get_footer();
?>