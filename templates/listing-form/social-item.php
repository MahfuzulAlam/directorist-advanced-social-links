<?php
/**
 * Directorist listing-form social link item.
 *
 * @package Directorist_Advanced_Social_Links
 */

defined( 'ABSPATH' ) || exit;

$template_args = isset( $args ) && is_array( $args ) ? $args : array();
$social_info   = isset( $social_info ) && is_array( $social_info ) ? $social_info : array();
$social_items  = directorist_advanced_social_links_get_social_items();
$social_id     = isset( $social_info['id'] ) ? sanitize_key( $social_info['id'] ) : '';
$social_url    = isset( $social_info['url'] ) ? $social_info['url'] : '';
$social_row_id = array_key_exists( 'id', $template_args ) ? $template_args['id'] : $index;
?>

<div class="directorist-form-social-fields" id="socialID-<?php echo esc_attr( $social_row_id ); ?>">
	<div class="directorist-form-social-fields__input">
		<div class="directorist-form-group">
			<select name="social[<?php echo esc_attr( $social_row_id ); ?>][id]" class="directorist-form-element placeholder-item">
				<option value=""><?php esc_html_e( 'Select Network', 'advanced-social-links-for-directorist' ); ?></option>
				<?php foreach ( $social_items as $name_id => $social_name ) : ?>
					<option value="<?php echo esc_attr( $name_id ); ?>" <?php selected( $name_id, $social_id ); ?>>
						<?php echo esc_html( $social_name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="directorist-form-group">
			<input type="url" name="social[<?php echo esc_attr( $social_row_id ); ?>][url]" class="directorist-form-element directory_field atbdp_social_input" value="<?php echo esc_url( $social_url ); ?>" placeholder="<?php esc_attr_e( 'https://example.com', 'advanced-social-links-for-directorist' ); ?>" required>
		</div>
	</div>
	<div class="directorist-form-social-fields__action">
		<span data-id="<?php echo esc_attr( $social_row_id ); ?>" class="directorist-form-social-fields__remove dashicons" title="<?php esc_attr_e( 'Remove this item', 'advanced-social-links-for-directorist' ); ?>">
			<?php directorist_icon( 'fas fa-trash-alt' ); ?>
		</span>
	</div>
</div>
