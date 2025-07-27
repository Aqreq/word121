<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <section class="error-404 not-found text-center">
            
            <div class="error-404-content">
                <div class="error-number">
                    <h1>404</h1>
                </div>
                
                <header class="page-header">
                    <h2 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'imagestore-pro'); ?></h2>
                </header>

                <div class="page-content">
                    <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search or browse our image collection?', 'imagestore-pro'); ?></p>

                    <?php get_search_form(); ?>

                    <div class="error-404-actions">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                            <?php esc_html_e('Go Home', 'imagestore-pro'); ?>
                        </a>
                        
                        <?php if (imagestore_is_edd_active()) : ?>
                            <a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>" class="btn btn-secondary">
                                <?php esc_html_e('Browse Images', 'imagestore-pro'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (imagestore_is_edd_active()) : ?>
                <div class="featured-content-404">
                    <h3><?php esc_html_e('Or check out these popular images:', 'imagestore-pro'); ?></h3>
                    
                    <?php
                    $popular_downloads = new WP_Query(array(
                        'post_type'      => 'download',
                        'posts_per_page' => 4,
                        'post_status'    => 'publish',
                        'meta_key'       => '_edd_download_sales',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC',
                    ));

                    if ($popular_downloads->have_posts()) : ?>
                        <div class="grid grid-4">
                            <?php while ($popular_downloads->have_posts()) : $popular_downloads->the_post(); ?>
                                <div class="edd_download card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="edd_download_image card-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('imagestore-card', array('alt' => get_the_title())); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="edd_download_inner card-content">
                                        <h4 class="edd_download_title card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        
                                        <?php if (function_exists('edd_get_download_price') && edd_get_download_price(get_the_ID())) : ?>
                                            <div class="edd_price card-price">
                                                <?php edd_price(get_the_ID()); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php echo do_shortcode('[purchase_link id="' . get_the_ID() . '" style="button" color="blue" text="' . __('Add to Cart', 'imagestore-pro') . '" class="edd-submit btn btn-primary btn-sm"]'); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </section>

    </div>
</main>

<style>
.error-404-content {
    max-width: 600px;
    margin: 0 auto 4rem;
}

.error-number h1 {
    font-size: 8rem;
    font-weight: 700;
    color: var(--primary-color);
    line-height: 1;
    margin-bottom: 1rem;
}

.error-404-actions {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.featured-content-404 {
    margin-top: 4rem;
    padding-top: 4rem;
    border-top: 1px solid var(--border-color);
}

@media (max-width: 768px) {
    .error-number h1 {
        font-size: 6rem;
    }
    
    .error-404-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-404-actions .btn {
        width: 200px;
    }
}
</style>

<?php
get_footer();
?>