<?php
/**
 * ImageStore Pro Theme Customizer
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function imagestore_customize_register($wp_customize) {
    
    // Add theme options section
    $wp_customize->add_section('imagestore_theme_options', array(
        'title'    => __('ImageStore Options', 'imagestore-pro'),
        'priority' => 130,
    ));

    // Hero section title
    $wp_customize->add_setting('imagestore_hero_title', array(
        'default'           => __('Premium Digital Images', 'imagestore-pro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('imagestore_hero_title', array(
        'label'   => __('Hero Title', 'imagestore-pro'),
        'section' => 'imagestore_theme_options',
        'type'    => 'text',
    ));

    // Hero section subtitle
    $wp_customize->add_setting('imagestore_hero_subtitle', array(
        'default'           => __('Discover thousands of high-quality digital images for your projects. Perfect for designers, marketers, and content creators.', 'imagestore-pro'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('imagestore_hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'imagestore-pro'),
        'section' => 'imagestore_theme_options',
        'type'    => 'textarea',
    ));

    // Show featured products
    $wp_customize->add_setting('imagestore_show_featured', array(
        'default'           => 1,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('imagestore_show_featured', array(
        'label'   => __('Show Featured Products', 'imagestore-pro'),
        'section' => 'imagestore_theme_options',
        'type'    => 'checkbox',
    ));

    // Colors section
    $wp_customize->add_section('imagestore_colors', array(
        'title'    => __('ImageStore Colors', 'imagestore-pro'),
        'priority' => 131,
    ));

    // Primary color
    $wp_customize->add_setting('imagestore_primary_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'imagestore_primary_color', array(
        'label'   => __('Primary Color', 'imagestore-pro'),
        'section' => 'imagestore_colors',
    )));

    // Accent color
    $wp_customize->add_setting('imagestore_accent_color', array(
        'default'           => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'imagestore_accent_color', array(
        'label'   => __('Accent Color', 'imagestore-pro'),
        'section' => 'imagestore_colors',
    )));

    // Layout section
    $wp_customize->add_section('imagestore_layout', array(
        'title'    => __('Layout Options', 'imagestore-pro'),
        'priority' => 132,
    ));

    // Container width
    $wp_customize->add_setting('imagestore_container_width', array(
        'default'           => '1200px',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('imagestore_container_width', array(
        'label'       => __('Container Width', 'imagestore-pro'),
        'section'     => 'imagestore_layout',
        'type'        => 'select',
        'choices'     => array(
            '1200px' => __('Standard (1200px)', 'imagestore-pro'),
            '1400px' => __('Wide (1400px)', 'imagestore-pro'),
            '1600px' => __('Extra Wide (1600px)', 'imagestore-pro'),
            '100%'   => __('Full Width', 'imagestore-pro'),
        ),
    ));

    // Archive products per page
    $wp_customize->add_setting('imagestore_products_per_page', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('imagestore_products_per_page', array(
        'label'   => __('Products per Page', 'imagestore-pro'),
        'section' => 'imagestore_layout',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 100,
        ),
    ));

    // Typography section
    $wp_customize->add_section('imagestore_typography', array(
        'title'    => __('Typography', 'imagestore-pro'),
        'priority' => 133,
    ));

    // Body font
    $wp_customize->add_setting('imagestore_body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('imagestore_body_font', array(
        'label'   => __('Body Font', 'imagestore-pro'),
        'section' => 'imagestore_typography',
        'type'    => 'select',
        'choices' => array(
            'Inter'     => 'Inter',
            'Roboto'    => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato'      => 'Lato',
            'Montserrat' => 'Montserrat',
        ),
    ));

    // Heading font
    $wp_customize->add_setting('imagestore_heading_font', array(
        'default'           => 'Poppins',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('imagestore_heading_font', array(
        'label'   => __('Heading Font', 'imagestore-pro'),
        'section' => 'imagestore_typography',
        'type'    => 'select',
        'choices' => array(
            'Poppins'    => 'Poppins',
            'Roboto'     => 'Roboto',
            'Inter'      => 'Inter',
            'Montserrat' => 'Montserrat',
            'Playfair Display' => 'Playfair Display',
        ),
    ));

    // Modify existing settings for postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'imagestore_customize_partial_blogname',
        ));
        
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'imagestore_customize_partial_blogdescription',
        ));
    }
}
add_action('customize_register', 'imagestore_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function imagestore_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function imagestore_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function imagestore_customize_preview_js() {
    wp_enqueue_script('imagestore-customizer', IMAGESTORE_THEME_URL . '/assets/js/customizer.js', array('customize-preview'), IMAGESTORE_VERSION, true);
}
add_action('customize_preview_init', 'imagestore_customize_preview_js');

/**
 * Output custom CSS based on customizer settings
 */
function imagestore_customize_css() {
    $primary_color = get_theme_mod('imagestore_primary_color', '#2563eb');
    $accent_color = get_theme_mod('imagestore_accent_color', '#f59e0b');
    $container_width = get_theme_mod('imagestore_container_width', '1200px');
    $body_font = get_theme_mod('imagestore_body_font', 'Inter');
    $heading_font = get_theme_mod('imagestore_heading_font', 'Poppins');

    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --accent-color: <?php echo esc_attr($accent_color); ?>;
            --secondary-color: <?php echo esc_attr(imagestore_adjust_brightness($primary_color, -20)); ?>;
            --font-primary: '<?php echo esc_attr($body_font); ?>', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-heading: '<?php echo esc_attr($heading_font); ?>', var(--font-primary);
        }

        .container {
            max-width: <?php echo esc_attr($container_width); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'imagestore_customize_css');

/**
 * Helper function to adjust color brightness
 */
function imagestore_adjust_brightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0, min(255, $color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}