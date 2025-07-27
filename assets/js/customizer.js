/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($, wp) {
    'use strict';

    if (!wp || !wp.customize) {
        return;
    }

    var api = wp.customize;

    // Site title
    api('blogname', function(value) {
        value.bind(function(newval) {
            $('.site-title a').text(newval);
        });
    });

    // Site tagline
    api('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

    // Header text color
    api('header_textcolor', function(value) {
        value.bind(function(newval) {
            if ('blank' === newval) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': newval
                });
            }
        });
    });

    // Primary color
    api('imagestore_primary_color', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--primary-color', newval);
            updateCSSVariable('--secondary-color', adjustBrightness(newval, -20));
        });
    });

    // Accent color
    api('imagestore_accent_color', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--accent-color', newval);
        });
    });

    // Container width
    api('imagestore_container_width', function(value) {
        value.bind(function(newval) {
            $('.container').css('max-width', newval);
        });
    });

    // Body font
    api('imagestore_body_font', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--font-primary', "'" + newval + "', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif");
            loadGoogleFont(newval);
        });
    });

    // Heading font
    api('imagestore_heading_font', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--font-heading', "'" + newval + "', var(--font-primary)");
            loadGoogleFont(newval);
        });
    });

    // Hero title
    api('imagestore_hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });

    // Hero subtitle
    api('imagestore_hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero-subtitle').text(newval);
        });
    });

    /**
     * Update CSS custom property (variable)
     */
    function updateCSSVariable(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    /**
     * Adjust color brightness
     */
    function adjustBrightness(hex, percent) {
        // Remove # if present
        hex = hex.replace('#', '');

        // Convert to RGB
        var num = parseInt(hex, 16);
        var amt = Math.round(2.55 * percent);
        var R = (num >> 16) + amt;
        var G = (num >> 8 & 0x00FF) + amt;
        var B = (num & 0x0000FF) + amt;

        // Ensure values stay within bounds
        R = R > 255 ? 255 : R < 0 ? 0 : R;
        G = G > 255 ? 255 : G < 0 ? 0 : G;
        B = B > 255 ? 255 : B < 0 ? 0 : B;

        // Convert back to hex
        return '#' + (0x1000000 + (R << 16) + (G << 8) + B).toString(16).slice(1);
    }

    /**
     * Load Google Font
     */
    function loadGoogleFont(fontName) {
        var fontId = 'customizer-font-' + fontName.replace(/\s+/g, '-').toLowerCase();
        
        // Remove existing font link if present
        $('#' + fontId).remove();
        
        // Add new font link
        var fontUrl = 'https://fonts.googleapis.com/css2?family=' + 
                      encodeURIComponent(fontName) + ':wght@300;400;500;600;700&display=swap';
        
        $('<link>')
            .attr({
                'id': fontId,
                'rel': 'stylesheet',
                'href': fontUrl
            })
            .appendTo('head');
    }

    /**
     * Handle live preview for sections that need refresh
     */
    api('imagestore_show_featured', function(value) {
        value.bind(function(newval) {
            api.preview.send('refresh');
        });
    });

    api('imagestore_products_per_page', function(value) {
        value.bind(function(newval) {
            api.preview.send('refresh');
        });
    });

    // Focus on elements when corresponding controls are focused in customizer
    api.preview.bind('focus-control', function(controlId) {
        var $element;
        
        switch (controlId) {
            case 'blogname':
                $element = $('.site-title a');
                break;
            case 'blogdescription':
                $element = $('.site-description');
                break;
            case 'imagestore_hero_title':
                $element = $('.hero-title');
                break;
            case 'imagestore_hero_subtitle':
                $element = $('.hero-subtitle');
                break;
        }
        
        if ($element && $element.length) {
            $element.addClass('customizer-focus');
            setTimeout(function() {
                $element.removeClass('customizer-focus');
            }, 1500);
        }
    });

})(jQuery, parent.wp);