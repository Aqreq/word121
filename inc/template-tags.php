<?php
/**
 * Custom template tags for this theme
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

if (!function_exists('imagestore_fallback_menu')) :
    /**
     * Fallback menu if no menu is assigned to primary location
     */
    function imagestore_fallback_menu() {
        ?>
        <ul class="nav-menu fallback-menu">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'imagestore-pro'); ?></a></li>
            <?php if (imagestore_is_edd_active()) : ?>
                <li><a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>"><?php _e('Shop', 'imagestore-pro'); ?></a></li>
            <?php endif; ?>
            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>"><?php _e('About', 'imagestore-pro'); ?></a></li>
            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>"><?php _e('Contact', 'imagestore-pro'); ?></a></li>
        </ul>
        <?php
    }
endif;

if (!function_exists('imagestore_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function imagestore_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            esc_html_x('Posted on %s', 'post date', 'imagestore-pro'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>';
    }
endif;

if (!function_exists('imagestore_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function imagestore_posted_by() {
        $byline = sprintf(
            esc_html_x('by %s', 'post author', 'imagestore-pro'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>';
    }
endif;

if (!function_exists('imagestore_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function imagestore_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'imagestore-pro'));
            if ($categories_list) {
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'imagestore-pro') . '</span>', $categories_list);
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'imagestore-pro'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'imagestore-pro') . '</span>', $tags_list);
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'imagestore-pro'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    __('Edit <span class="screen-reader-text">%s</span>', 'imagestore-pro'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('imagestore_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     */
    function imagestore_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
            <?php
        else :
            ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail('post-thumbnail', array(
                    'alt' => the_title_attribute(array(
                        'echo' => false,
                    )),
                ));
                ?>
            </a>
            <?php
        endif;
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;