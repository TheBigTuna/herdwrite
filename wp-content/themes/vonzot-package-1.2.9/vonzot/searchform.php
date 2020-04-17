<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>

<?php $unique_id = uniqid( 'search-form-' ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>">
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'vonzot' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field" placeholder="<?php echo apply_filters( 'vonzot_searchform_placeholder', esc_attr_x( 'Type and hit enter&hellip;', 'placeholder', 'vonzot' ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_attr_x( 'Type and hit enter', 'submit button', 'vonzot' ); ?></span></button>
</form>