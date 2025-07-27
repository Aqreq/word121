<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <?php if (is_home() && !is_front_page()) : ?>
            <header class="page-title">
                <h1><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            
            <div class="content-area">
                <?php if (is_home() || is_archive()) : ?>
                    <div class="grid grid-3">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="card-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium_large', array('class' => 'card-thumbnail')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="card-content">
                                    <header class="entry-header">
                                        <h2 class="card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
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
                                        </div>
                                    </header>

                                    <div class="entry-content card-text">
                                        <?php 
                                        if (has_excerpt()) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), 20, '...');
                                        }
                                        ?>
                                    </div>

                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <?php _e('Read More', 'imagestore-pro'); ?>
                                        </a>
                                    </footer>
                                </div>

                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('&larr; Previous', 'imagestore-pro'),
                        'next_text' => __('Next &rarr;', 'imagestore-pro'),
                        'class'     => 'pagination-nav',
                    ));
                    ?>
                    
                <?php else : ?>
                    
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="featured-image mb-4">
                                    <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                                </div>
                            <?php endif; ?>

                            <header class="entry-header mb-3">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                
                                <?php if (is_single()) : ?>
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
                                <?php endif; ?>
                            </header>

                            <div class="entry-content">
                                <?php
                                the_content();
                                
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . __('Pages:', 'imagestore-pro'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div>

                            <?php if (is_single()) : ?>
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
                            <?php endif; ?>

                        </article>
                    <?php endwhile; ?>
                    
                <?php endif; ?>
            </div>

        <?php else : ?>
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Nothing here', 'imagestore-pro'); ?></h1>
                </header>

                <div class="page-content">
                    <?php if (is_home() && current_user_can('publish_posts')) : ?>
                        <p>
                            <?php
                            printf(
                                wp_kses(
                                    __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'imagestore-pro'),
                                    array(
                                        'a' => array(
                                            'href' => array(),
                                        ),
                                    )
                                ),
                                esc_url(admin_url('post-new.php'))
                            );
                            ?>
                        </p>
                    <?php elseif (is_search()) : ?>
                        <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'imagestore-pro'); ?></p>
                        <?php get_search_form(); ?>
                    <?php else : ?>
                        <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'imagestore-pro'); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>

    </div>
</main>

<?php
get_sidebar();
get_footer();
?>