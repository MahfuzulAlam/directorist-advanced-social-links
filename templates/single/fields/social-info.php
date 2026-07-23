<?php
/**
 * Directorist single-listing social links field.
 *
 * @package Directorist_Advanced_Social_Links
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $listing ) || ! is_object( $listing ) || ! is_callable( array( $listing, 'get_socials' ) ) ) {
	return;
}

$socials      = $listing->get_socials();
$social_items = directorist_advanced_social_links_get_all_social_items();

if ( ! is_array( $socials ) || ! $socials ) {
	return;
}
?>

<div class="directorist-single-info directorist-single-info-socials">

	<?php if ( ! empty( $data['label'] ) ) : ?>
		<div class="directorist-single-info__label">
			<span class="directorist-single-info__label-icon"><?php directorist_icon( $icon ); ?></span>
			<span class="directorist-single-info__label--text"><?php echo esc_html( $data['label'] ); ?></span>
		</div>
	<?php endif; ?>

	<div class="directorist-social-links">
		<?php
		foreach ( $socials as $social ) :
			if ( ! is_array( $social ) || empty( $social['id'] ) || empty( $social['url'] ) ) {
				continue;
			}

			$social_id    = sanitize_key( $social['id'] );
			$social_url   = esc_url( $social['url'] );
			$social_label = isset( $social_items[ $social_id ] )
				? $social_items[ $social_id ]
				: ucwords( str_replace( array( '-', '_' ), ' ', $social_id ) );

			if ( ! $social_id || ! $social_url ) {
				continue;
			}
			?>
			<a
				class="directorist-custom-social-link <?php echo esc_attr( $social_id ); ?>"
				target="_blank"
				rel="noopener noreferrer"
				href="<?php echo esc_url( $social_url ); ?>"
				aria-label="<?php echo esc_attr( $social_label ); ?>"
			>
				<?php directorist_advanced_social_links_get_social_icon( $social_id ); ?>
			</a>
		<?php endforeach; ?>
	</div>

</div>
