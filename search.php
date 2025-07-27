<?php
/**
 * The template for displaying search results pages
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <header class="page-title">
            <h1>
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'imagestore-pro'),
                    '<span class="search-term">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <?php
            global $wp_query;
            if ($wp_query->found_posts) {
                printf(
                    esc_html(_n('Found %s result', 'Found %s results', $wp_query->found_posts, 'imagestore-pro')),
                    number_format_i18n($wp_query->found_posts)
                );
            }
            ?>
        </header>

        <?php if (have_posts()) : ?>
            
            <div class="search-results-content">
                <div class="grid grid-3">
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card search-result-item'); ?>>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('imagestore-card', array('alt' => get_the_title())); ?>
                                    </a>
                                    
                                    <?php if (get_post_type() === 'download') : ?>
                                        <span class="post-type-badge"><?php _e('Digital Image', 'imagestore-pro'); ?></span>
                                    <?php else : ?>
                                        <span class="post-type-badge"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="card-content">
                                <header class="entry-header">
                                    <h2 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="entry-meta">
                                        <span class="post-type">
                                            <?php if (get_post_type() === 'download') : ?>
                                                <a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>">
                                                    <?php _e('Digital Images', 'imagestore-pro'); ?>
                                                </a>
                                            <?php else : ?>
                                                <a href="<?php echo esc_url(get_post_type_archive_link(get_post_type())); ?>">
                                                    <?php echo esc_html(get_post_type_object(get_post_type())->labels->name); ?>
                                                </a>
                                            <?php endif; ?>
                                        </span>
                                        
                                        <?php if (get_post_type() === 'post') : ?>
                                            <span class="posted-on">
                                                <time datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date(); ?>
                                                </time>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </header>

                                <div class="entry-content card-text">
                                    <?php
                                    if (has_excerpt()) {
                                        echo wp_trim_words(get_the_excerpt(), 15, '...');
                                    } else {
                                        echo wp_trim_words(get_the_content(), 15, '...');
                                    }
                                    ?>
                                </div>

                                <footer class="entry-footer">
                                    <?php if (get_post_type() === 'download' && function_exists('edd_get_download_price') && edd_get_download_price(get_the_ID())) : ?>
                                        <div class="edd_price card-price">
                                            <?php edd_price(get_the_ID()); ?>
                                        </div>
                                        
                                        <div class="download-actions">
                                            <?php echo do_shortcode('[purchase_link id="' . get_the_ID() . '" style="button" color="blue" text="' . __('Add to Cart', 'imagestore-pro') . '" class="edd-submit btn btn-primary btn-sm"]'); ?>
                                            
                                            <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm">
                                                <?php _e('View Details', 'imagestore-pro'); ?>
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <?php _e('Read More', 'imagestore-pro'); ?>
                                        </a>
                                    <?php endif; ?>
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
            </div>
            
        <?php else : ?>
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h2 class="page-title"><?php _e('Nothing found', 'imagestore-pro'); ?></h2>
                </header>

                <div class="page-content">
                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'imagestore-pro'); ?></p>
                    
                    <?php get_search_form(); ?>
                    
                    <div class="search-suggestions">
                        <h3><?php _e('Search Suggestions:', 'imagestore-pro'); ?></h3>
                        <ul>
                            <li><?php _e('Try different keywords', 'imagestore-pro'); ?></li>
                            <li><?php _e('Check your spelling', 'imagestore-pro'); ?></li>
                            <li><?php _e('Use more general terms', 'imagestore-pro'); ?></li>
                            <li><?php _e('Try fewer keywords', 'imagestore-pro'); ?></li>
                        </ul>
                    </div>
                    
                    <?php if (imagestore_is_edd_active()) : ?>
                        <div class="browse-categories">
                            <h3><?php _e('Browse by Category:', 'imagestore-pro'); ?></h3>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'download_category',
                                'hide_empty' => true,
                                'number' => 8,
                            ));
                            
                            if (!empty($categories)) : ?>
                                <div class="categories-grid">
                                    <?php foreach ($categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-link">
                                            <?php echo esc_html($category->name); ?>
                                            <span class="category-count">(<?php echo $category->count; ?>)</span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
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