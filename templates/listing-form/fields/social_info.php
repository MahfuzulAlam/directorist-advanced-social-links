<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="directorist-form-group directorist-form-social-info-field">

    <?php \Directorist\Directorist_Listing_Form::instance()->field_label_template( $data );?>

    <div id="social_info_sortable_container">

        <input type="hidden" id="is_social_checked">

        <?php
        if ( ! empty( $data['value'] ) ) {
            foreach ( $data['value'] as $index => $social_info ) {
                if( isset( $data['social_items'] ) ) $social_info['social_items'] = $data['social_items'];
                \Directorist\Directorist_Listing_Form::instance()->social_item_template( $index, $social_info );
            }
        }
        ?>

    </div>

    <button type="button" class="directorist-btn directorist-btn-light" id="addNewSocial"><?php directorist_icon( 'las la-plus' ); ?><?php esc_html_e( 'Add Social', 'directorist' ); ?></button>

    <?php \Directorist\Directorist_Listing_Form::instance()->field_description_template( $data ); ?>
    
</div>