<?php
/**
 * View: Top Bar Navigation Previous Template
 *
 * @package nightingale
 *
 * @var string $prev_url The URL to the previous page, if any, or an empty string.
 *
 * @version 5.0.1
 */

?>
<li class="tribe-events-c-top-bar__nav-list-item">
	<a
		href="<?php echo esc_url( $prev_url ); ?>"
		class="tribe-common-c-btn-icon tribe-common-c-btn-icon--caret-left tribe-events-c-top-bar__nav-link tribe-events-c-top-bar__nav-link--prev"
		aria-label="<?php esc_attr_e( 'Previous day', NHSUK_DOMAIN_NAME ); ?>"
		title="<?php esc_attr_e( 'Previous day', NHSUK_DOMAIN_NAME ); ?>"
		data-js="tribe-events-view-link"
	>
	</a>
</li>
