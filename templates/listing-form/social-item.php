<?php

/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

if (!defined('ABSPATH')) exit;

$social_items = ATBDP()->helper->social_links();
//Add an option
$social_items['meetup'] = 'Meetup.com';
$social_items['discord'] = 'Discord';
$social_items['telegram'] = 'Telegram';
$social_items['tiktok'] = 'TikTok';
$social_items['twitch'] = 'Twitch';
$social_items['medium'] = 'Medium';
$social_items['whatsapp'] = 'WhatsApp';
$social_items['alignable'] = 'Alignable';
$social_items['threads'] = 'Threads';
$social_items['nextdoor'] = 'Nextdoor';
//Remove an option
//unset($social_items['flickr']);

$id = (array_key_exists('id', $args)) ? $args['id'] : $index; ?>

<div class="directorist-form-social-fields" id="socialID-<?php echo esc_attr($id); ?>">
    <div class="directorist-form-group">
        <select name="social[<?php echo esc_attr($id); ?>][id]" class="directorist-form-element">
            <?php foreach ($social_items as $nameID => $socialName) { ?>
                <option value="<?php echo esc_attr($nameID); ?>" <?php selected($nameID, $social_info['id']); ?>><?php echo esc_html($socialName); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="directorist-form-group">
        <input type="url" name="social[<?php echo esc_attr($id); ?>][url]" class="directorist-form-element directory_field atbdp_social_input" value="<?php echo esc_url($social_info['url']); ?>" placeholder="<?php esc_attr_e('eg. http://example.com', 'directorist'); ?>" required>
    </div>
    <div class="directorist-form-group directorist-form-social-fields__action">
        <span data-id="<?php echo esc_attr($id); ?>" class="directorist-form-social-fields__remove dashicons dashicons-trash" title="<?php esc_html_e('Remove this item', 'directorist'); ?>"></span>
    </div>
</div>