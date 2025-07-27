<?php
/**
 * The template for displaying the front page
 *
 * This is the template that displays the front page by default.
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    
    <?php if (get_option('imagestore_show_featured', 1) && imagestore_is_edd_active()) : ?>
        <section class="featured-products">
            <div class="container">
                <header class="section-header text-center">
                    <h2><?php _e('Featured Images', 'imagestore-pro'); ?></h2>
                    <p><?php _e('Handpicked premium digital images for your creative projects', 'imagestore-pro'); ?></p>
                </header>

                <?php
                // Get featured downloads (you can set featured downloads using a custom field or category)
                $featured_args = array(
                    'post_type'      => 'download',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'meta_query'     => array(
                        array(
                            'key'     => '_edd_featured_product',
                            'value'   => '1',
                            'compare' => '='
                        )
                    ),
                );

                // Fallback to recent downloads if no featured products
                $featured_query = new WP_Query($featured_args);
                if (!$featured_query->have_posts()) {
                    $featured_args = array(
                        'post_type'      => 'download',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    );
                    $featured_query = new WP_Query($featured_args);
                }

                if ($featured_query->have_posts()) : ?>
                    <div class="grid grid-3">
                        <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                            <div class="edd_download card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="edd_download_image card-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('imagestore-card', array('alt' => get_the_title())); ?>
                                        </a>
                                        
                                        <?php if (function_exists('edd_has_variable_prices') && edd_has_variable_prices(get_the_ID())) : ?>
                                            <span class="price-badge"><?php _e('Multiple Options', 'imagestore-pro'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="edd_download_inner card-content">
                                    <h3 class="edd_download_title card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <?php if (has_excerpt()) : ?>
                                        <div class="edd_download_excerpt card-text">
                                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="edd_download_buy_button">
                                        <?php if (function_exists('edd_get_download_price') && edd_get_download_price(get_the_ID())) : ?>
                                            <div class="edd_price card-price">
                                                <?php edd_price(get_the_ID()); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php echo do_shortcode('[purchase_link id="' . get_the_ID() . '" style="button" color="blue" text="' . __('Add to Cart', 'imagestore-pro') . '" class="edd-submit btn btn-primary"]'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <div class="section-footer text-center mt-4">
                        <a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>" class="btn btn-secondary">
                            <?php _e('View All Images', 'imagestore-pro'); ?>
                        </a>
                    </div>
                    
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (have_posts()) : ?>
        <section class="recent-content">
            <div class="container">
                <header class="section-header text-center">
                    <h2><?php _e('Latest Updates', 'imagestore-pro'); ?></h2>
                    <p><?php _e('Stay updated with our latest news, tips, and featured content', 'imagestore-pro'); ?></p>
                </header>

                <div class="grid grid-3">
                    <?php
                    $recent_posts = new WP_Query(array(
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ));

                    while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('imagestore-card', array('alt' => get_the_title())); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="card-content">
                                <header class="entry-header">
                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <div class="entry-meta">
                                        <span class="posted-on">
                                            <time datetime="<?php echo get_the_date('c'); ?>">
                                                <?php echo get_the_date(); ?>
                                            </time>
                                        </span>
                                    </div>
                                </header>

                                <div class="entry-content card-text">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                </div>

                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                        <?php _e('Read More', 'imagestore-pro'); ?>
                                    </a>
                                </footer>
                            </div>

                        </article>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (imagestore_is_edd_active()) : ?>
        <section class="cta-section">
            <div class="container">
                <div class="cta-content text-center">
                    <h2><?php _e('Ready to Get Started?', 'imagestore-pro'); ?></h2>
                    <p><?php _e('Browse our extensive collection of premium digital images and find the perfect assets for your next project.', 'imagestore-pro'); ?></p>
                    
                    <div class="cta-actions">
                        <a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>" class="btn btn-primary">
                            <?php _e('Browse Collection', 'imagestore-pro'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php
get_footer();
?>