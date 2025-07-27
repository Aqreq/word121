<?php
/**
 * The template for displaying Download Archive pages
 *
 * Used for displaying Easy Digital Downloads archive pages
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <header class="page-title">
            <h1><?php _e('Digital Images Collection', 'imagestore-pro'); ?></h1>
            <p><?php _e('Browse our extensive collection of premium digital images', 'imagestore-pro'); ?></p>
        </header>

        <?php if (have_posts()) : ?>
            
            <!-- Filter Bar -->
            <div class="edd-download-filters">
                <?php
                // Categories dropdown
                $categories = get_terms(array(
                    'taxonomy' => 'download_category',
                    'hide_empty' => true,
                ));
                
                if (!empty($categories)) : ?>
                    <select id="download-category-filter">
                        <option value=""><?php _e('All Categories', 'imagestore-pro'); ?></option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <?php
                // Tags dropdown
                $tags = get_terms(array(
                    'taxonomy' => 'download_tag',
                    'hide_empty' => true,
                ));
                
                if (!empty($tags)) : ?>
                    <select id="download-tag-filter">
                        <option value=""><?php _e('All Tags', 'imagestore-pro'); ?></option>
                        <?php foreach ($tags as $tag) : ?>
                            <option value="<?php echo esc_attr($tag->slug); ?>">
                                <?php echo esc_html($tag->name); ?> (<?php echo $tag->count; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <!-- Sort dropdown -->
                <select id="download-sort-filter">
                    <option value="date"><?php _e('Newest First', 'imagestore-pro'); ?></option>
                    <option value="title"><?php _e('Alphabetical', 'imagestore-pro'); ?></option>
                    <option value="popularity"><?php _e('Most Popular', 'imagestore-pro'); ?></option>
                    <?php if (function_exists('edd_get_download_price')) : ?>
                        <option value="price_low"><?php _e('Price: Low to High', 'imagestore-pro'); ?></option>
                        <option value="price_high"><?php _e('Price: High to Low', 'imagestore-pro'); ?></option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="edd_downloads_list grid grid-3" id="downloads-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <div class="edd_download card" data-categories="<?php echo esc_attr(implode(' ', wp_get_object_terms(get_the_ID(), 'download_category', array('fields' => 'slugs')))); ?>" data-tags="<?php echo esc_attr(implode(' ', wp_get_object_terms(get_the_ID(), 'download_tag', array('fields' => 'slugs')))); ?>">
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="edd_download_image card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('imagestore-card', array('alt' => get_the_title())); ?>
                                </a>
                                
                                <?php if (function_exists('edd_has_variable_prices') && edd_has_variable_prices(get_the_ID())) : ?>
                                    <span class="price-badge"><?php _e('Multiple Sizes', 'imagestore-pro'); ?></span>
                                <?php endif; ?>

                                <!-- Quick Preview Button -->
                                <div class="image-overlay">
                                    <a href="<?php the_post_thumbnail_url('large'); ?>" class="quick-preview" data-lightbox="downloads">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="edd_download_inner card-content">
                            <header class="download-header">
                                <h3 class="edd_download_title card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="download-meta">
                                    <?php
                                    // Display download categories
                                    $categories = wp_get_object_terms(get_the_ID(), 'download_category');
                                    if (!empty($categories)) {
                                        echo '<span class="download-categories">';
                                        $cat_links = array();
                                        foreach ($categories as $category) {
                                            $cat_links[] = '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                                        }
                                        echo implode(', ', $cat_links);
                                        echo '</span>';
                                    }
                                    ?>
                                </div>
                            </header>
                            
                            <?php if (has_excerpt()) : ?>
                                <div class="edd_download_excerpt card-text">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <footer class="download-footer">
                                <?php if (function_exists('edd_get_download_price') && edd_get_download_price(get_the_ID())) : ?>
                                    <div class="edd_price card-price">
                                        <?php edd_price(get_the_ID()); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="download-actions">
                                    <?php echo do_shortcode('[purchase_link id="' . get_the_ID() . '" style="button" color="blue" text="' . __('Add to Cart', 'imagestore-pro') . '" class="edd-submit btn btn-primary"]'); ?>
                                    
                                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                                        <?php _e('View Details', 'imagestore-pro'); ?>
                                    </a>
                                </div>
                            </footer>
                        </div>
                    </div>
                    
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
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h2 class="page-title"><?php _e('No downloads found', 'imagestore-pro'); ?></h2>
                </header>

                <div class="page-content">
                    <p><?php _e('Sorry, but no downloads were found. Please check back later or browse our categories.', 'imagestore-pro'); ?></p>
                    
                    <?php if (!empty($categories)) : ?>
                        <h3><?php _e('Browse Categories', 'imagestore-pro'); ?></h3>
                        <ul class="download-categories-list">
                            <?php foreach ($categories as $category) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                        <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
            
        <?php endif; ?>

    </div>
</main>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('download-category-filter');
    const tagFilter = document.getElementById('download-tag-filter');
    const sortFilter = document.getElementById('download-sort-filter');
    const downloadsGrid = document.getElementById('downloads-grid');
    const downloads = Array.from(downloadsGrid.children);

    function filterDownloads() {
        const selectedCategory = categoryFilter ? categoryFilter.value : '';
        const selectedTag = tagFilter ? tagFilter.value : '';
        
        downloads.forEach(download => {
            const categories = download.dataset.categories || '';
            const tags = download.dataset.tags || '';
            
            const categoryMatch = !selectedCategory || categories.includes(selectedCategory);
            const tagMatch = !selectedTag || tags.includes(selectedTag);
            
            if (categoryMatch && tagMatch) {
                download.style.display = 'block';
            } else {
                download.style.display = 'none';
            }
        });
    }

    function sortDownloads() {
        const sortValue = sortFilter.value;
        const visibleDownloads = downloads.filter(download => download.style.display !== 'none');
        
        visibleDownloads.sort((a, b) => {
            switch (sortValue) {
                case 'title':
                    return a.querySelector('.edd_download_title a').textContent.localeCompare(
                        b.querySelector('.edd_download_title a').textContent
                    );
                case 'date':
                default:
                    return 0; // Maintain original order for date
            }
        });
        
        visibleDownloads.forEach(download => {
            downloadsGrid.appendChild(download);
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', () => {
            filterDownloads();
            sortDownloads();
        });
    }

    if (tagFilter) {
        tagFilter.addEventListener('change', () => {
            filterDownloads();
            sortDownloads();
        });
    }

    if (sortFilter) {
        sortFilter.addEventListener('change', sortDownloads);
    }
});
</script>

<?php
get_footer();
?>