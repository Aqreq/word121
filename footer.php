<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
                <div class="footer-content">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-section">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-section">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-section">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="footer-content">
                    <div class="footer-section">
                        <h3><?php _e('About ImageStore', 'imagestore-pro'); ?></h3>
                        <p><?php _e('We provide high-quality digital images for designers, marketers, and content creators. Our curated collection features stunning photography and graphics perfect for any project.', 'imagestore-pro'); ?></p>
                    </div>

                    <div class="footer-section">
                        <h3><?php _e('Quick Links', 'imagestore-pro'); ?></h3>
                        <ul style="list-style: none; padding: 0;">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'imagestore-pro'); ?></a></li>
                            <?php if (imagestore_is_edd_active()) : ?>
                                <li><a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>"><?php _e('Shop', 'imagestore-pro'); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php _e('Privacy Policy', 'imagestore-pro'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>"><?php _e('Contact', 'imagestore-pro'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h3><?php _e('Customer Support', 'imagestore-pro'); ?></h3>
                        <p><?php _e('Need help? We\'re here to assist you with any questions about our digital images and licensing.', 'imagestore-pro'); ?></p>
                        <p><strong><?php _e('Email:', 'imagestore-pro'); ?></strong> support@imagestore.com</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="footer-bottom">
                <div class="site-info">
                    <?php
                    printf(
                        esc_html__('Copyright &copy; %1$s %2$s. All rights reserved.', 'imagestore-pro'),
                        date('Y'),
                        get_bloginfo('name')
                    );
                    ?>
                    
                    <span class="sep"> | </span>
                    
                    <?php
                    printf(
                        esc_html__('Powered by %1$s and %2$s.', 'imagestore-pro'),
                        '<a href="' . esc_url('https://wordpress.org/') . '">WordPress</a>',
                        '<a href="' . esc_url('https://easydigitaldownloads.com/') . '">Easy Digital Downloads</a>'
                    );
                    ?>
                </div><!-- .site-info -->

                <?php if (has_nav_menu('footer')) : ?>
                    <nav class="footer-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                        ?>
                    </nav>
                <?php endif; ?>
            </div><!-- .footer-bottom -->

        </div><!-- .container -->
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>