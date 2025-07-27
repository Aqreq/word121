<?php
/**
 * The sidebar containing the main widget area
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}

// Don't show sidebar on EDD checkout or cart pages
if (function_exists('edd_is_checkout') && (edd_is_checkout() || edd_is_cart())) {
    return;
}

// Don't show sidebar on front page
if (is_front_page()) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    <div class="sidebar-inner">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
</aside><!-- #secondary -->