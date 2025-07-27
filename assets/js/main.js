/**
 * File main.js.
 *
 * Main JavaScript functionality for ImageStore Pro theme
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Initialize all components
        initImageLazyLoading();
        initSearchToggle();
        initSmoothScroll();
        initBackToTop();
        initImageGallery();
        initEDDIntegration();
        initAjaxSearch();

        // Sticky header on scroll
        var $header = $('.site-header');
        var headerHeight = $header.outerHeight();
        
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > headerHeight) {
                $header.addClass('sticky');
            } else {
                $header.removeClass('sticky');
            }
        });

    });

    /**
     * Initialize lazy loading for images
     */
    function initImageLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Initialize search toggle functionality
     */
    function initSearchToggle() {
        $('.search-toggle').on('click', function(e) {
            e.preventDefault();
            $('.search-form').toggleClass('active');
            $('.search-field').focus();
        });

        // Close search when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form, .search-toggle').length) {
                $('.search-form').removeClass('active');
            }
        });
    }

    /**
     * Initialize smooth scrolling
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"]):not([data-toggle]):not([data-target])').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 800, 'easeInOutQuart');
                }
            }
        });
    }

    /**
     * Initialize back to top button
     */
    function initBackToTop() {
        // Add back to top button
        $('body').append('<button id="back-to-top" class="back-to-top" aria-label="Back to top"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m18 15-6-6-6 6"/></svg></button>');
        
        var $backToTop = $('#back-to-top');
        
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 300) {
                $backToTop.addClass('visible');
            } else {
                $backToTop.removeClass('visible');
            }
        });

        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    }

    /**
     * Initialize image gallery functionality
     */
    function initImageGallery() {
        $('.gallery').each(function() {
            $(this).magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: 'The image could not be loaded.'
                }
            });
        });

        // Product image zoom
        $('.edd_download_image').on('mouseenter', function() {
            $(this).find('img').addClass('zoom');
        }).on('mouseleave', function() {
            $(this).find('img').removeClass('zoom');
        });
    }

    /**
     * Initialize Easy Digital Downloads integration
     */
    function initEDDIntegration() {
        // Update cart count after AJAX add to cart
        $(document).on('edd_cart_item_added', function(event, response) {
            updateCartCount();
            showNotification('Item added to cart!', 'success');
        });

        $(document).on('edd_cart_item_removed', function(event, response) {
            updateCartCount();
            showNotification('Item removed from cart!', 'info');
        });

        // Update cart count function
        function updateCartCount() {
            $.post(imagestore_ajax.ajax_url, {
                action: 'get_cart_count',
                nonce: imagestore_ajax.nonce
            }, function(response) {
                if (response.success) {
                    $('.cart-count').text(response.data.count);
                }
            });
        }
    }

    /**
     * Initialize AJAX search
     */
    function initAjaxSearch() {
        var searchTimeout;
        
        $('.search-field').on('input', function() {
            var $this = $(this);
            var query = $this.val();
            
            clearTimeout(searchTimeout);
            
            if (query.length >= 3) {
                searchTimeout = setTimeout(function() {
                    performAjaxSearch(query);
                }, 500);
            } else {
                $('.search-results').hide();
            }
        });

        function performAjaxSearch(query) {
            $.post(imagestore_ajax.ajax_url, {
                action: 'ajax_search',
                query: query,
                nonce: imagestore_ajax.nonce
            }, function(response) {
                if (response.success) {
                    displaySearchResults(response.data.results);
                }
            });
        }

        function displaySearchResults(results) {
            var $searchForm = $('.search-form');
            var $resultsContainer = $searchForm.find('.search-results');
            
            if (!$resultsContainer.length) {
                $resultsContainer = $('<div class="search-results"></div>');
                $searchForm.append($resultsContainer);
            }

            if (results.length > 0) {
                var html = '<ul>';
                results.forEach(function(item) {
                    html += '<li><a href="' + item.url + '">' + item.title + '</a></li>';
                });
                html += '</ul>';
                
                $resultsContainer.html(html).show();
            } else {
                $resultsContainer.html('<p>No results found.</p>').show();
            }
        }

        // Hide search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form').length) {
                $('.search-results').hide();
            }
        });
    }

    /**
     * Show notification messages
     */
    function showNotification(message, type) {
        var notificationClass = 'notification notification-' + (type || 'info');
        var $notification = $('<div class="' + notificationClass + '">' + message + '</div>');
        
        $('body').append($notification);
        
        setTimeout(function() {
            $notification.addClass('show');
        }, 100);

        setTimeout(function() {
            $notification.removeClass('show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 3000);
    }

    /**
     * Easing function for animations
     */
    $.easing.easeInOutQuart = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    };

})(jQuery);

// Handle window resize
window.addEventListener('resize', function() {
    // Recalculate any layout-dependent elements
    if (window.innerWidth > 768) {
        document.querySelector('.main-navigation').classList.remove('active');
    }
});

// Handle page visibility change
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Pause any animations or videos when page is not visible
    } else {
        // Resume animations when page becomes visible
    }
});