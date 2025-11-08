<?php

/**
 * @author  wpWax
 * @since   6.7
 * @version 7.4.0
 */

if (!defined('ABSPATH')) exit;

$socials = $listing->get_socials();

if (empty($socials)) {
    return;
}
?>

<div class="directorist-single-info directorist-single-info-socials">

    <?php if (isset($data['label']) && !empty($data['label'])) : ?>
        <div class="directorist-single-info__label">
            <span class="directorist-single-info__label-icon"><?php directorist_icon($icon); ?></span>
            <span class="directorist-single-info__label--text"><?php echo esc_html($data['label']); ?></span>
        </div>
    <?php endif; ?>

    <div class="directorist-social-links">
        <?php foreach ($socials as $social) : ?>
            <?php $icon = 'lab la-' . $social['id']; ?>
            <a class="directorist-custom-social-link <?php echo esc_attr($social['id']); ?>" target='_blank' href="<?php echo esc_url($social['url']); ?>">
                <?php
                    directorist_advanced_social_links_get_social_icon($social['id']);
                ?>
            </a>
        <?php endforeach; ?>
    </div>

</div>