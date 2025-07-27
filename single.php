<?php
/**
 * The template for displaying all single posts
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header text-center mb-4">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
                    <div class="entry-meta">
                        <span class="posted-on">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                        
                        <span class="byline">
                            <?php _e('by', 'imagestore-pro'); ?> 
                            <span class="author vcard">
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php echo get_the_author(); ?>
                                </a>
                            </span>
                        </span>
                        
                        <?php if (has_category()) : ?>
                            <span class="cat-links">
                                <?php _e('in', 'imagestore-pro'); ?> <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
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

                <footer class="entry-footer">
                    <?php
                    if (has_tag()) {
                        echo '<div class="tag-links">';
                        _e('Tags: ', 'imagestore-pro');
                        the_tags('', ', ', '');
                        echo '</div>';
                    }
                    ?>
                </footer>

            </article>

            <?php
            // Navigation between posts
            the_post_navigation(array(
                'prev_text' => '<span class="nav-subtitle">' . __('Previous:', 'imagestore-pro') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . __('Next:', 'imagestore-pro') . '</span> <span class="nav-title">%title</span>',
            ));

            // Comments
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>
            
        <?php endwhile; ?>

    </div>
</main>

<?php
get_sidebar();
get_footer();
?>