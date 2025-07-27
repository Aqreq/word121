# ImageStore Pro - WordPress E-commerce Theme

A modern, responsive WordPress theme designed specifically for e-commerce stores selling digital images. Fully compatible with Easy Digital Downloads plugin featuring clean design, image galleries, and optimized user experience for digital product sales.

## Description

ImageStore Pro is a professional WordPress theme built for digital image marketplaces, photography stores, and creative e-commerce sites. The theme provides a seamless integration with Easy Digital Downloads plugin to create a powerful platform for selling digital images.

## Features

### Design & Layout
- **Modern, Clean Design**: Professional appearance suitable for commercial use
- **Fully Responsive**: Optimized for all devices (desktop, tablet, mobile)
- **Customizable Colors**: Built-in color customization options
- **Typography Options**: Google Fonts integration with multiple font choices
- **Grid Layouts**: Flexible grid system for showcasing images

### E-commerce Features
- **Easy Digital Downloads Integration**: Full compatibility with EDD plugin
- **Product Galleries**: Support for multiple product images
- **Variable Pricing**: Support for different image sizes and licenses
- **Shopping Cart**: Integrated cart functionality
- **Checkout Process**: Streamlined checkout experience
- **Payment Processing**: Support for all EDD payment gateways

### Image-Specific Features
- **Image Preview**: Quick preview functionality for products
- **Image Information**: Display file size, format, dimensions, and license info
- **Category & Tag Support**: Organize images with taxonomies
- **Search & Filter**: Advanced filtering options for products
- **Related Products**: Show similar images to increase sales

### User Experience
- **Fast Loading**: Optimized for performance
- **SEO Friendly**: Built with SEO best practices
- **Accessibility**: WCAG compliant design
- **Cross-browser Compatible**: Works on all modern browsers
- **Social Sharing**: Built-in social media sharing

### Technical Features
- **Custom Post Types**: Enhanced support for downloads
- **Widget Areas**: Multiple widget-ready areas
- **Custom Menus**: Support for navigation menus
- **Customizer Integration**: Live customization options
- **Translation Ready**: Full internationalization support
- **Child Theme Support**: Safe customization options

## Installation

1. **Download the theme**: Extract the theme files to your computer
2. **Upload to WordPress**:
   - Go to your WordPress admin dashboard
   - Navigate to Appearance > Themes
   - Click "Add New" > "Upload Theme"
   - Select the `imagestore-pro.zip` file
   - Click "Install Now"
3. **Activate the theme**: Click "Activate" after installation
4. **Install Easy Digital Downloads**: Install and activate the EDD plugin
5. **Configure the theme**: Go to Appearance > Customize to set up your site

## Required Plugins

- **Easy Digital Downloads**: Required for e-commerce functionality
- **Easy Digital Downloads - Software Licensing**: For selling licenses (optional)
- **Easy Digital Downloads - Reviews**: For product reviews (optional)

## Theme Setup

### 1. Homepage Setup
1. Create a new page titled "Home"
2. Go to Settings > Reading
3. Set "Your homepage displays" to "A static page"
4. Select your "Home" page as the homepage

### 2. Menu Setup
1. Go to Appearance > Menus
2. Create a new menu
3. Add pages, downloads, and custom links
4. Assign the menu to "Primary Menu" location

### 3. Customizer Settings
Navigate to Appearance > Customize to configure:
- **Site Identity**: Upload logo and set site title
- **Colors**: Customize theme colors
- **Typography**: Select fonts
- **ImageStore Options**: Configure hero section and featured products
- **Widgets**: Add content to footer areas

### 4. Adding Products (Downloads)
1. Go to Downloads > Add New
2. Add product title, description, and featured image
3. Set pricing in the Download Configuration box
4. Add downloadable files
5. Assign categories and tags
6. Publish the product

## Customization

### Theme Options
Access theme-specific options through:
- **Appearance > Customize > ImageStore Options**
- **Appearance > Theme Options**

Available customization options:
- Hero section title and subtitle
- Featured products display
- Color scheme customization
- Typography settings
- Layout options

### Custom CSS
Add custom CSS through:
- Appearance > Customize > Additional CSS

### Widget Areas
The theme includes several widget areas:
- Sidebar
- Footer Area 1
- Footer Area 2  
- Footer Area 3

## File Structure

```
imagestore-pro/
├── style.css              # Main stylesheet and theme info
├── index.php              # Main template file
├── functions.php          # Theme functions
├── header.php             # Header template
├── footer.php             # Footer template
├── sidebar.php            # Sidebar template
├── front-page.php         # Homepage template
├── single.php             # Single post template
├── single-download.php    # Single download template
├── page.php               # Page template
├── archive-download.php   # Downloads archive template
├── search.php             # Search results template
├── comments.php           # Comments template
├── 404.php               # 404 error template
├── inc/                  # Theme functions
│   ├── customizer.php    # Customizer options
│   ├── template-tags.php # Template functions
│   └── template-functions.php # Helper functions
├── assets/               # Theme assets
│   ├── css/             # Stylesheets
│   │   └── edd-custom.css # EDD custom styles
│   └── js/              # JavaScript files
│       ├── main.js      # Main scripts
│       ├── navigation.js # Navigation scripts
│       └── customizer.js # Customizer scripts
└── languages/           # Translation files
```

## Shortcodes

### Download Grid
Display a grid of downloads:
```
[imagestore_downloads number="12" columns="3" category="photography"]
```

Parameters:
- `number`: Number of downloads to show (default: 12)
- `columns`: Number of columns (2, 3, or 4)
- `category`: Filter by category slug
- `tag`: Filter by tag slug
- `orderby`: Sort order (date, title, popularity)

## Hooks & Filters

The theme provides several hooks for customization:

### Action Hooks
- `imagestore_before_header`
- `imagestore_after_header`
- `imagestore_before_content`
- `imagestore_after_content`
- `imagestore_before_footer`
- `imagestore_after_footer`

### Filter Hooks
- `imagestore_hero_title`
- `imagestore_hero_subtitle`
- `imagestore_excerpt_length`
- `imagestore_grid_columns`

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+

## Performance

The theme is optimized for performance:
- Minified CSS and JavaScript
- Optimized images
- Efficient database queries
- Lazy loading support
- Caching friendly

## SEO Features

- Schema markup for products
- Optimized meta tags
- Breadcrumb support
- XML sitemap compatibility
- Social media meta tags

## Accessibility

The theme follows WCAG 2.1 AA guidelines:
- Keyboard navigation support
- Screen reader friendly
- High contrast support
- Focus indicators
- Alt text for images

## Support

For theme support and documentation:
- **Documentation**: [Theme Documentation URL]
- **Support Forum**: [Support URL]
- **Email Support**: support@imagestore-theme.com

## Changelog

### Version 1.0.0
- Initial release
- Easy Digital Downloads integration
- Responsive design
- Customizer options
- SEO optimization
- Accessibility improvements

## License

This theme is licensed under the GPL v2 or later.
- Theme License: GPLv2 or later
- Images: Licensed for theme use
- Fonts: Open source fonts

## Credits

- **Framework**: WordPress
- **E-commerce**: Easy Digital Downloads
- **Fonts**: Google Fonts (Inter, Poppins)
- **Icons**: Custom SVG icons
- **Testing**: WordPress Coding Standards

---

**Version**: 1.0.0  
**Requires at least**: WordPress 5.0  
**Tested up to**: WordPress 6.4  
**Requires PHP**: 7.4  
**License**: GPL v2 or later