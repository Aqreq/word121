/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile menu toggle
        $('.menu-toggle').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $navigation = $('.main-navigation');
            
            $navigation.toggleClass('active');
            
            // Toggle aria-expanded
            var expanded = $button.attr('aria-expanded') === 'true' || false;
            $button.attr('aria-expanded', !expanded);
            
            // Change button text for screen readers
            if (!expanded) {
                $button.find('.screen-reader-text').text('Close Primary Menu');
            } else {
                $button.find('.screen-reader-text').text('Primary Menu');
            }
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                $('.main-navigation').removeClass('active');
                $('.menu-toggle').attr('aria-expanded', false);
                $('.menu-toggle .screen-reader-text').text('Primary Menu');
            }
        });

        // Close mobile menu on window resize
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.main-navigation').removeClass('active');
                $('.menu-toggle').attr('aria-expanded', false);
                $('.menu-toggle .screen-reader-text').text('Primary Menu');
            }
        });

        // Dropdown menu handling for accessibility
        $('.main-navigation .menu-item-has-children > a').on('click', function(e) {
            if ($(window).width() <= 768) {
                e.preventDefault();
                
                var $parent = $(this).parent();
                var $submenu = $parent.find('.sub-menu').first();
                
                $submenu.slideToggle(200);
                $parent.toggleClass('menu-open');
            }
        });

        // Keyboard navigation
        $('.main-navigation a').on('focus blur', function() {
            $(this).parents('ul, li').toggleClass('focus');
        });

        // Smooth scroll for anchor links
        $('a[href^="#"]:not([href="#"])').on('click', function(e) {
            var target = $(this.hash);
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 500, 'swing');
                
                // Close mobile menu if open
                $('.main-navigation').removeClass('active');
                $('.menu-toggle').attr('aria-expanded', false);
            }
        });

    });

})(jQuery);