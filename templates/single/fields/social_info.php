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
            <a target='_blank' href="<?php echo esc_url($social['url']); ?>" class="<?php echo esc_attr($social['id']); ?>">
                <?php if ($social['id'] === 'tiktok') {
                    echo '<img width="15" height="15" src="' . ADVANCED_SOCIAL_URI . '/assets/icon/tiktok.png">';
                } else if ($social['id'] === 'twitter') {
                    echo '<img width="15" height="15" src="' . ADVANCED_SOCIAL_URI . '/assets/icon/twitter.svg">';
                } else if ($social['id'] === 'alignable') {
                    echo '<img width="15" height="15" src="' . ADVANCED_SOCIAL_URI . '/assets/icon/alignable.svg">';
                } else if ($social['id'] === 'threads') {
                    echo '<img width="15" height="15" src="' . ADVANCED_SOCIAL_URI . '/assets/icon/threads.svg">';
                } else if ($social['id'] === 'nextdoor') {
                    echo '<img width="15" height="15" src="' . ADVANCED_SOCIAL_URI . '/assets/icon/nextdoor.svg">';
                } else {
                    directorist_icon($icon);
                } ?>
            </a>
        <?php endforeach; ?>
    </div>

</div>