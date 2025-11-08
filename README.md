# Directorist - Advanced Social Links

An extension for Directorist plugin that adds advanced social networking options to listing forms and single listing pages.

## Description

Directorist Advanced Social Links extends the default social links functionality by adding 15+ additional social networks, custom SVG icons, brand color hover effects, and comprehensive settings management.

## Features

### 🎯 Core Features

- **Extended Social Networks**: Adds 15+ additional social networks beyond Directorist's default options
  - Meetup.com
  - Discord
  - Telegram
  - TikTok
  - Twitch
  - Medium
  - WhatsApp
  - Alignable
  - Threads
  - Nextdoor
  - Yelp
  - Google Review
  - Tripadvisor
  - BlueSky
  - And more...

- **Custom SVG Icons**: Custom SVG icons for networks that don't have default icon fonts
  - TikTok
  - Alignable
  - Threads
  - Nextdoor
  - BlueSky

- **Brand Color Hover Effects**: Optional hover background color effects using each social network's official brand colors

- **Settings Management**: Comprehensive admin settings page to:
  - Select which social networks are available in listing forms
  - Enable/disable brand color hover effects
  - Configure social link options per listing type

- **Template Overrides**: Custom template system for displaying social links on single listing pages

- **Custom CSS**: Built-in CSS for social icon styling with hover effects

### 📋 Additional Features

- **Form Field Description**: Adds a description/instructions field to the social info widget in listing forms
- **Dynamic Options**: Social network options are dynamically generated from available networks
- **Settings Filtering**: Only selected social networks appear in listing forms
- **Security**: All inputs are properly sanitized and validated
- **WordPress Standards**: Follows WordPress coding standards and best practices

## Installation

1. Upload the plugin files to `/wp-content/plugins/directorist-advanced-social-links/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to **Directorist → Settings → Extensions → Advanced Social Links** to configure

## Configuration

### Settings Page

Go to **Directorist → Settings → Extensions → Advanced Social Links** to configure:

1. **Enable Brand Color Hover Effect**: Toggle to enable/disable hover background color effects
2. **Available Social Networks**: Select which social networks should be available in listing forms

### Default Behavior

- All social networks are available by default
- Brand color hover effect is disabled by default
- Custom SVG icons are used for: TikTok, Alignable, Threads, Nextdoor, BlueSky

## Developer Documentation

### Available Functions

#### `directorist_advanced_social_links_get_all_social_items()`

Returns all available social networks without filtering.

```php
$all_socials = directorist_advanced_social_links_get_all_social_items();
// Returns: array('facebook' => 'Facebook', 'twitter' => 'Twitter', ...)
```

#### `directorist_advanced_social_links_get_social_items()`

Returns available social networks filtered by admin settings.

```php
$socials = directorist_advanced_social_links_get_social_items();
// Returns only enabled social networks based on settings
```

#### `directorist_advanced_social_links_get_social_icon($social_id)`

Outputs the HTML for a social network icon.

```php
directorist_advanced_social_links_get_social_icon('facebook');
// Outputs: <i class="lab la-facebook"></i> or custom SVG for specific networks
```

**Parameters:**
- `$social_id` (string) - Social network identifier (e.g., 'facebook', 'tiktok')

#### `directorist_advanced_social_links_get_brand_color()`

Returns an array of social network brand colors.

```php
$colors = directorist_advanced_social_links_get_brand_color();
// Returns: array('facebook' => '#1877F2', 'twitter' => '#000000', ...)
```

### Available Filters (Hooks)

#### `directorist_advanced_social_links_all_items`

Filter all available social networks before settings filtering.

```php
add_filter('directorist_advanced_social_links_all_items', function($socials) {
    // Add custom social network
    $socials['custom_network'] = 'Custom Network';
    return $socials;
});
```

**Parameters:**
- `$socials` (array) - Associative array of social network IDs and labels

**Returns:** (array) Modified social networks array

#### `directorist_advanced_social_links_items`

Filter available social networks after settings filtering.

```php
add_filter('directorist_advanced_social_links_items', function($socials) {
    // Modify filtered social networks
    unset($socials['twitter']); // Remove Twitter
    return $socials;
});
```

**Parameters:**
- `$socials` (array) - Associative array of enabled social networks

**Returns:** (array) Modified social networks array

#### `directorist_advanced_social_links_custom_icons`

Filter the list of social IDs that use custom SVG icons.

```php
add_filter('directorist_advanced_social_links_custom_icons', function($custom_icons) {
    // Add custom network to use SVG icon
    $custom_icons[] = 'custom_network';
    return $custom_icons;
});
```

**Parameters:**
- `$custom_icons` (array) - Array of social network IDs that use custom icons

**Returns:** (array) Modified custom icons array

#### `directorist_advanced_social_links_icon_output`

Filter the HTML output for custom social icons.

```php
add_filter('directorist_advanced_social_links_icon_output', function($output, $social_id) {
    // Modify icon HTML
    if ($social_id === 'custom_network') {
        $output = '<i class="custom-icon-class"></i>';
    }
    return $output;
}, 10, 2);
```

**Parameters:**
- `$output` (string) - HTML for the custom icon
- `$social_id` (string) - Social network identifier

**Returns:** (string) Modified icon HTML

#### `directorist_advanced_social_links_default_icon_class`

Filter the default icon classname for social networks.

```php
add_filter('directorist_advanced_social_links_default_icon_class', function($icon_class, $social_id) {
    // Change icon class for specific network
    if ($social_id === 'facebook') {
        $icon_class = 'fab fa-facebook-f';
    }
    return $icon_class;
}, 10, 2);
```

**Parameters:**
- `$icon_class` (string) - Default icon classname
- `$social_id` (string) - Social network identifier

**Returns:** (string) Modified icon classname

#### `directorist_advanced_social_links_brand_color`

Filter brand colors for social networks.

```php
add_filter('directorist_advanced_social_links_brand_color', function($brand_colors) {
    // Add or modify brand colors
    $brand_colors['custom_network'] = '#FF0000';
    $brand_colors['facebook'] = '#1877F2'; // Override existing
    return $brand_colors;
});
```

**Parameters:**
- `$brand_colors` (array) - Associative array of social network IDs and hex colors

**Returns:** (array) Modified brand colors array

#### `atbdp_advanced_social_links_settings_controls`

Filter the settings sections and controls.

```php
add_filter('atbdp_advanced_social_links_settings_controls', function($sections) {
    // Add custom section
    $sections['custom_section'] = array(
        'title' => 'Custom Section',
        'description' => 'Custom settings',
        'fields' => array('custom_field'),
    );
    return $sections;
});
```

**Parameters:**
- `$sections` (array) - Settings sections array

**Returns:** (array) Modified sections array

#### `atbdp_form_preset_widgets`

Filter form preset widgets (used to add description field).

```php
add_filter('atbdp_form_preset_widgets', function($widgets) {
    // Modify social_info widget options
    $widgets['social_info']['options']['custom_field'] = array(
        'label' => 'Custom Field',
        'type' => 'text',
    );
    return $widgets;
});
```

**Parameters:**
- `$widgets` (array) - Form preset widgets array

**Returns:** (array) Modified widgets array

#### `directorist_template`

Filter Directorist templates (used for template overrides).

```php
add_filter('directorist_template', function($template, $field_data) {
    // Override template for specific field
    if ($template === 'single/fields/social_info') {
        // Custom template logic
    }
    return $template;
}, 10, 2);
```

**Parameters:**
- `$template` (string) - Template file name
- `$field_data` (array) - Field data passed to template

**Returns:** (string) Template file name

### Template Files

The plugin includes custom templates that can be overridden in your theme:

- `templates/single/fields/social_info.php` - Single listing page social links display
- `templates/listing-form/social-item.php` - Listing form social link field
- `templates/listing-form/fields/social_info.php` - Listing form social info field

To override templates, copy them to:
`your-theme/directorist-advanced-social-links/templates/[template-path].php`

### CSS Classes

The plugin adds the following CSS classes:

- `.directorist-custom-social-link` - Main wrapper for social links
- `.directorist-custom-social-icon` - Custom SVG icon class
- `.directorist-custom-social-link.{social_id}` - Individual social network class (e.g., `.directorist-custom-social-link.facebook`)
- `.directorist-custom-social-link.{social_id}:hover` - Hover state with brand color (when enabled)

### Settings Options

Available settings options (stored in `atbdp_option`):

- `advanced_social_links_items` (array) - Array of enabled social network IDs
- `enable_brand_color_hover` (bool) - Enable/disable brand color hover effect

## Changelog

### 2.0.0
- Added brand color hover effects
- Added settings page integration
- Added toggle for brand color hover effect
- Improved template system
- Added custom SVG icons
- Enhanced security and validation
- Added comprehensive filter hooks

### 1.0.0
- Initial release
- Basic social network extensions
- Template overrides

## Support

For support, feature requests, or bug reports, please visit the plugin's support page.

## License

GPL v2 or later

## Credits

Developed by wpXplore
