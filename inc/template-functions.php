<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function imagestore_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'imagestore_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function imagestore_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'imagestore_pingback_header');

/**
 * Custom search form
 */
function imagestore_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
        <label>
            <span class="screen-reader-text">' . _x('Search for:', 'label', 'imagestore-pro') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Search images...', 'placeholder', 'imagestore-pro') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit">
            <span class="screen-reader-text">' . _x('Search', 'submit button', 'imagestore-pro') . '</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="21 21l-4.35-4.35"></path>
            </svg>
        </button>
    </form>';

    return $form;
}
add_filter('get_search_form', 'imagestore_search_form');

/**
 * Enqueue admin styles
 */
function imagestore_admin_style() {
    wp_enqueue_style('imagestore-admin-style', IMAGESTORE_THEME_URL . '/assets/css/admin.css', array(), IMAGESTORE_VERSION);
}
add_action('admin_enqueue_scripts', 'imagestore_admin_style');

/**
 * Custom logo setup
 */
function imagestore_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'imagestore_custom_logo_setup');

/**
 * Filter the except length to 20 words for card displays
 */
function imagestore_custom_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    return 20;
}
add_filter('excerpt_length', 'imagestore_custom_excerpt_length', 999);

/**
 * Filter the excerpt "read more" string
 */
function imagestore_excerpt_more($more) {
    if (is_admin()) {
        return $more;
    }
    return '...';
}
add_filter('excerpt_more', 'imagestore_excerpt_more');

/**
 * Add custom image sizes to media library dropdown
 */
function imagestore_custom_sizes($sizes) {
    return array_merge($sizes, array(
        'imagestore-featured' => __('Featured Image', 'imagestore-pro'),
        'imagestore-gallery' => __('Gallery Thumbnail', 'imagestore-pro'),
        'imagestore-card' => __('Card Image', 'imagestore-pro'),
    ));
}
add_filter('image_size_names_choose', 'imagestore_custom_sizes');

/**
 * Enable SVG uploads
 */
function imagestore_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'imagestore_mime_types');

/**
 * Custom pagination for archives
 */
function imagestore_pagination() {
    global $wp_query;
    
    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    
    $big = 999999999; // need an unlikely integer
    
    echo paginate_links(array(
        'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'  => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total'   => $wp_query->max_num_pages,
        'type'    => 'plain',
        'prev_text' => __('&larr; Previous', 'imagestore-pro'),
        'next_text' => __('Next &rarr;', 'imagestore-pro'),
    ));
}

/**
 * Add custom CSS classes to nav menu items
 */
function imagestore_nav_menu_css_class($classes, $item, $args) {
    if (isset($args->theme_location)) {
        if ('primary' === $args->theme_location) {
            $classes[] = 'nav-item';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'imagestore_nav_menu_css_class', 10, 3);

/**
 * Add custom CSS classes to nav menu links
 */
function imagestore_nav_menu_link_attributes($atts, $item, $args) {
    if (isset($args->theme_location)) {
        if ('primary' === $args->theme_location) {
            $atts['class'] = 'nav-link';
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'imagestore_nav_menu_link_attributes', 10, 3);