<?php
/**
 * The template for displaying single Download posts
 *
 * Used for displaying single Easy Digital Downloads
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="download-<?php the_ID(); ?>" <?php post_class('single-download'); ?>>
                
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
                    <div class="download-meta">
                        <?php
                        // Display download categories
                        $categories = wp_get_object_terms(get_the_ID(), 'download_category');
                        if (!empty($categories)) {
                            echo '<div class="download-categories">';
                            echo '<strong>' . __('Categories:', 'imagestore-pro') . ' </strong>';
                            $cat_links = array();
                            foreach ($categories as $category) {
                                $cat_links[] = '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                            }
                            echo implode(', ', $cat_links);
                            echo '</div>';
                        }

                        // Display download tags
                        $tags = wp_get_object_terms(get_the_ID(), 'download_tag');
                        if (!empty($tags)) {
                            echo '<div class="download-tags">';
                            echo '<strong>' . __('Tags:', 'imagestore-pro') . ' </strong>';
                            $tag_links = array();
                            foreach ($tags as $tag) {
                                $tag_links[] = '<a href="' . esc_url(get_term_link($tag)) . '">' . esc_html($tag->name) . '</a>';
                            }
                            echo implode(', ', $tag_links);
                            echo '</div>';
                        }
                        ?>
                    </div>
                </header>

                <div class="download-content-wrapper">
                    <div class="download-gallery">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image">
                                <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Display additional images from gallery if available
                        $gallery_images = get_post_meta(get_the_ID(), '_edd_gallery_images', true);
                        if (!empty($gallery_images)) : ?>
                            <div class="download-gallery-thumbnails">
                                <h3><?php _e('Additional Images', 'imagestore-pro'); ?></h3>
                                <div class="gallery-grid">
                                    <?php foreach ($gallery_images as $image_id) : ?>
                                        <div class="gallery-thumbnail">
                                            <a href="<?php echo esc_url(wp_get_attachment_url($image_id)); ?>" data-lightbox="download-gallery">
                                                <?php echo wp_get_attachment_image($image_id, 'imagestore-gallery', false, array('class' => 'gallery-thumb')); ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="download-details">
                        <!-- Purchase Form -->
                        <div class="edd_download_purchase_form">
                            <?php if (function_exists('edd_get_download_price') && edd_get_download_price(get_the_ID())) : ?>
                                <div class="edd_price">
                                    <?php edd_price(get_the_ID()); ?>
                                </div>
                            <?php endif; ?>

                            <?php echo do_shortcode('[purchase_link id="' . get_the_ID() . '" style="button" color="blue" text="' . __('Add to Cart', 'imagestore-pro') . '" class="edd-submit btn btn-primary btn-large"]'); ?>

                            <!-- Download Info -->
                            <div class="download-info">
                                <?php
                                // File size
                                $file_size = get_post_meta(get_the_ID(), '_edd_file_size', true);
                                if ($file_size) : ?>
                                    <div class="download-file-size">
                                        <strong><?php _e('File Size:', 'imagestore-pro'); ?></strong> <?php echo esc_html($file_size); ?>
                                    </div>
                                <?php endif; ?>

                                <?php
                                // File format
                                $file_format = get_post_meta(get_the_ID(), '_edd_file_format', true);
                                if ($file_format) : ?>
                                    <div class="download-file-format">
                                        <strong><?php _e('Format:', 'imagestore-pro'); ?></strong> <?php echo esc_html($file_format); ?>
                                    </div>
                                <?php endif; ?>

                                <?php
                                // Dimensions
                                $dimensions = get_post_meta(get_the_ID(), '_edd_image_dimensions', true);
                                if ($dimensions) : ?>
                                    <div class="download-dimensions">
                                        <strong><?php _e('Dimensions:', 'imagestore-pro'); ?></strong> <?php echo esc_html($dimensions); ?>
                                    </div>
                                <?php endif; ?>

                                <?php
                                // License
                                $license = get_post_meta(get_the_ID(), '_edd_license_type', true);
                                if ($license) : ?>
                                    <div class="download-license">
                                        <strong><?php _e('License:', 'imagestore-pro'); ?></strong> <?php echo esc_html($license); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="download-license">
                                        <strong><?php _e('License:', 'imagestore-pro'); ?></strong> <?php _e('Standard Commercial License', 'imagestore-pro'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Social Share -->
                            <div class="download-share">
                                <h4><?php _e('Share this image:', 'imagestore-pro'); ?></h4>
                                <div class="social-buttons">
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url(get_permalink()); ?>&text=<?php echo esc_attr(get_the_title()); ?>" target="_blank" class="btn btn-social btn-twitter">
                                        <?php _e('Twitter', 'imagestore-pro'); ?>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>" target="_blank" class="btn btn-social btn-facebook">
                                        <?php _e('Facebook', 'imagestore-pro'); ?>
                                    </a>
                                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo esc_url(get_the_post_thumbnail_url()); ?>&description=<?php echo esc_attr(get_the_title()); ?>" target="_blank" class="btn btn-social btn-pinterest">
                                        <?php _e('Pinterest', 'imagestore-pro'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="entry-content">
                    <h2><?php _e('Description', 'imagestore-pro'); ?></h2>
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', 'imagestore-pro'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php
                // Display related downloads
                $related_args = array(
                    'post_type'      => 'download',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'post__not_in'   => array(get_the_ID()),
                );

                // Get related by category
                $categories = wp_get_object_terms(get_the_ID(), 'download_category', array('fields' => 'ids'));
                if (!empty($categories)) {
                    $related_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'download_category',
                            'field'    => 'term_id',
                            'terms'    => $categories,
                        ),
                    );
                }

                $related_query = new WP_Query($related_args);
                
                if ($related_query->have_posts()) : ?>
                    <section class="related-downloads">
                        <h2><?php _e('Related Images', 'imagestore-pro'); ?></h2>
                        
                        <div class="grid grid-4">
                            <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
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
                    </section>
                    
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();
?>