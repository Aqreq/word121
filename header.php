<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'imagestore-pro'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-inner">
                
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        
                        <?php
                        $imagestore_description = get_bloginfo('description', 'display');
                        if ($imagestore_description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $imagestore_description; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="screen-reader-text"><?php _e('Primary Menu', 'imagestore-pro'); ?></span>
                        ☰
                    </button>
                    
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'imagestore_fallback_menu',
                    ));
                    ?>
                    
                    <div class="header-actions">
                        <?php if (imagestore_is_edd_active()) : ?>
                            <div class="cart-icon">
                                <a href="<?php echo esc_url(edd_get_checkout_uri()); ?>" class="cart-link">
                                    <span class="cart-icon-svg">🛒</span>
                                    <span class="cart-count"><?php echo edd_get_cart_quantity(); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php get_search_form(); ?>
                    </div>
                </nav><!-- #site-navigation -->

            </div><!-- .header-inner -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <?php if (is_front_page() && !is_home()) : ?>
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <?php echo esc_html(get_option('imagestore_hero_title', __('Premium Digital Images', 'imagestore-pro'))); ?>
                    </h1>
                    
                    <p class="hero-subtitle">
                        <?php echo esc_html(get_option('imagestore_hero_subtitle', __('Discover thousands of high-quality digital images for your projects. Perfect for designers, marketers, and content creators.', 'imagestore-pro'))); ?>
                    </p>
                    
                    <div class="hero-actions">
                        <?php if (imagestore_is_edd_active()) : ?>
                            <a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>" class="btn btn-primary">
                                <?php _e('Browse Images', 'imagestore-pro'); ?>
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="btn btn-secondary">
                            <?php _e('Learn More', 'imagestore-pro'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <div id="content" class="site-content">