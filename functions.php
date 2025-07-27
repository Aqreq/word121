<?php
/**
 * ImageStore Pro theme functions and definitions
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('IMAGESTORE_VERSION', '1.0.0');
define('IMAGESTORE_THEME_DIR', get_template_directory());
define('IMAGESTORE_THEME_URL', get_template_directory_uri());

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function imagestore_theme_setup() {
    
    // Make theme available for translation
    load_theme_textdomain('imagestore-pro', IMAGESTORE_THEME_DIR . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');
    
    // Set custom image sizes for the theme
    add_image_size('imagestore-featured', 800, 600, true); // Featured images
    add_image_size('imagestore-gallery', 400, 300, true);  // Gallery thumbnails
    add_image_size('imagestore-card', 360, 270, true);     // Card images

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'imagestore-pro'),
        'footer'  => __('Footer Menu', 'imagestore-pro'),
    ));

    // Switch default core markup for search form, comment form, and comments
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));

    // Set up the WordPress core custom background feature
    add_theme_support('custom-background', apply_filters('imagestore_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for wide and full alignment
    add_theme_support('align-wide');
    
    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Support for block editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary Blue', 'imagestore-pro'),
            'slug'  => 'primary',
            'color' => '#2563eb',
        ),
        array(
            'name'  => __('Secondary Blue', 'imagestore-pro'),
            'slug'  => 'secondary',
            'color' => '#1e40af',
        ),
        array(
            'name'  => __('Accent Orange', 'imagestore-pro'),
            'slug'  => 'accent',
            'color' => '#f59e0b',
        ),
        array(
            'name'  => __('Dark Gray', 'imagestore-pro'),
            'slug'  => 'dark',
            'color' => '#1f2937',
        ),
        array(
            'name'  => __('Light Gray', 'imagestore-pro'),
            'slug'  => 'light',
            'color' => '#f9fafb',
        ),
    ));
}
add_action('after_setup_theme', 'imagestore_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function imagestore_content_width() {
    $GLOBALS['content_width'] = apply_filters('imagestore_content_width', 1200);
}
add_action('after_setup_theme', 'imagestore_content_width', 0);

/**
 * Register widget area.
 */
function imagestore_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'imagestore-pro'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'imagestore-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Area 1', 'imagestore-pro'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'imagestore-pro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Area 2', 'imagestore-pro'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in your footer.', 'imagestore-pro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Area 3', 'imagestore-pro'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here to appear in your footer.', 'imagestore-pro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'imagestore_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function imagestore_scripts() {
    
    // Load Google Fonts
    wp_enqueue_style('imagestore-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap', array(), null);
    
    // Load theme stylesheet
    wp_enqueue_style('imagestore-style', get_stylesheet_uri(), array(), IMAGESTORE_VERSION);
    
    // Load theme JavaScript
    wp_enqueue_script('imagestore-navigation', IMAGESTORE_THEME_URL . '/assets/js/navigation.js', array('jquery'), IMAGESTORE_VERSION, true);
    
    wp_enqueue_script('imagestore-main', IMAGESTORE_THEME_URL . '/assets/js/main.js', array('jquery'), IMAGESTORE_VERSION, true);

    // Load comment reply script on single posts
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Pass PHP variables to JavaScript
    wp_localize_script('imagestore-main', 'imagestore_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('imagestore_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'imagestore_scripts');

/**
 * Easy Digital Downloads Integration
 */

// Check if EDD is active
function imagestore_is_edd_active() {
    return class_exists('Easy_Digital_Downloads');
}

/**
 * Custom EDD template integration
 */
function imagestore_edd_template_integration() {
    if (imagestore_is_edd_active()) {
        // Remove default EDD styles if needed
        remove_action('wp_enqueue_scripts', 'edd_register_styles');
        
        // Add custom EDD styles
        add_action('wp_enqueue_scripts', 'imagestore_edd_styles');
    }
}
add_action('init', 'imagestore_edd_template_integration');

/**
 * Enqueue EDD custom styles
 */
function imagestore_edd_styles() {
    wp_enqueue_style('imagestore-edd', IMAGESTORE_THEME_URL . '/assets/css/edd-custom.css', array('imagestore-style'), IMAGESTORE_VERSION);
}

/**
 * Custom EDD download grid shortcode
 */
function imagestore_downloads_grid($atts) {
    $atts = shortcode_atts(array(
        'number'   => 12,
        'columns'  => 3,
        'category' => '',
        'tag'      => '',
        'author'   => '',
        'ids'      => '',
        'exclude'  => '',
        'orderby'  => 'date',
        'order'    => 'DESC',
    ), $atts, 'imagestore_downloads');

    ob_start();

    $query_args = array(
        'post_type'      => 'download',
        'posts_per_page' => intval($atts['number']),
        'post_status'    => 'publish',
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
    );

    if (!empty($atts['category'])) {
        $query_args['download_category'] = $atts['category'];
    }

    if (!empty($atts['tag'])) {
        $query_args['download_tag'] = $atts['tag'];
    }

    if (!empty($atts['author'])) {
        $query_args['author'] = $atts['author'];
    }

    if (!empty($atts['ids'])) {
        $query_args['post__in'] = explode(',', $atts['ids']);
    }

    if (!empty($atts['exclude'])) {
        $query_args['post__not_in'] = explode(',', $atts['exclude']);
    }

    $downloads = new WP_Query($query_args);
    
    $grid_class = 'grid-' . intval($atts['columns']);
    
    if ($downloads->have_posts()) : ?>
        <div class="imagestore-downloads-grid">
            <div class="grid <?php echo esc_attr($grid_class); ?>">
                <?php while ($downloads->have_posts()) : $downloads->the_post(); ?>
                    <div class="edd_download card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="edd_download_image card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('imagestore-card'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="edd_download_inner card-content">
                            <h3 class="edd_download_title card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <?php if (has_excerpt()) : ?>
                                <div class="edd_download_excerpt card-text">
                                    <?php echo get_the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="edd_download_buy_button">
                                <?php echo do_shortcode('[purchase_link id="' . get_the_ID() . '" style="button" color="blue" text="' . __('Purchase', 'imagestore-pro') . '"]'); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif;

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('imagestore_downloads', 'imagestore_downloads_grid');

/**
 * Customizer additions.
 */
require IMAGESTORE_THEME_DIR . '/inc/customizer.php';

/**
 * Custom template tags for this theme.
 */
require IMAGESTORE_THEME_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require IMAGESTORE_THEME_DIR . '/inc/template-functions.php';

/**
 * Add custom fields for theme options
 */
function imagestore_add_theme_options_page() {
    add_theme_page(
        __('ImageStore Options', 'imagestore-pro'),
        __('Theme Options', 'imagestore-pro'),
        'manage_options',
        'imagestore-options',
        'imagestore_theme_options_page'
    );
}
add_action('admin_menu', 'imagestore_add_theme_options_page');

/**
 * Theme options page callback
 */
function imagestore_theme_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('ImageStore Pro Options', 'imagestore-pro'); ?></h1>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('imagestore_options');
            do_settings_sections('imagestore_options');
            ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Hero Section Title', 'imagestore-pro'); ?></th>
                    <td>
                        <input type="text" name="imagestore_hero_title" value="<?php echo esc_attr(get_option('imagestore_hero_title', __('Premium Digital Images', 'imagestore-pro'))); ?>" class="regular-text" />
                        <p class="description"><?php _e('Enter the main title for your hero section.', 'imagestore-pro'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('Hero Section Subtitle', 'imagestore-pro'); ?></th>
                    <td>
                        <textarea name="imagestore_hero_subtitle" rows="3" cols="50" class="large-text"><?php echo esc_textarea(get_option('imagestore_hero_subtitle', __('Discover thousands of high-quality digital images for your projects. Perfect for designers, marketers, and content creators.', 'imagestore-pro'))); ?></textarea>
                        <p class="description"><?php _e('Enter the subtitle text for your hero section.', 'imagestore-pro'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('Featured Products Section', 'imagestore-pro'); ?></th>
                    <td>
                        <input type="checkbox" name="imagestore_show_featured" value="1" <?php checked(1, get_option('imagestore_show_featured', 1)); ?> />
                        <label><?php _e('Show featured products section on homepage', 'imagestore-pro'); ?></label>
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Register theme options
 */
function imagestore_register_options() {
    register_setting('imagestore_options', 'imagestore_hero_title');
    register_setting('imagestore_options', 'imagestore_hero_subtitle');
    register_setting('imagestore_options', 'imagestore_show_featured');
}
add_action('admin_init', 'imagestore_register_options');

/**
 * Add body classes for better styling control
 */
function imagestore_body_classes($classes) {
    // Add class if EDD is active
    if (imagestore_is_edd_active()) {
        $classes[] = 'edd-active';
    }
    
    // Add class for front page
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    // Add class for EDD pages
    if (function_exists('edd_is_checkout') && edd_is_checkout()) {
        $classes[] = 'edd-checkout';
    }
    
    return $classes;
}
add_filter('body_class', 'imagestore_body_classes');

/**
 * Custom excerpt length
 */
function imagestore_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'imagestore_excerpt_length');

/**
 * Custom excerpt more text
 */
function imagestore_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'imagestore_excerpt_more');

/**
 * Add theme support for WooCommerce if needed as fallback
 */
function imagestore_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'imagestore_woocommerce_support');