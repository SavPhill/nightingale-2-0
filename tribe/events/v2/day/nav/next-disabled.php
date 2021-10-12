<?php
/**
 * View: Day View Nav Disabled Next Button
 *
 * @package nightingale
 *
 * See more documentation about our views templating system.
 *
 * @version 5.0.1
 */

?>
<li class="tribe-events-c-nav__list-item tribe-events-c-nav__list-item--next">
	<button
		class="tribe-events-c-nav__next tribe-common-b2 tribe-common-b1--min-medium"
		aria-label="<?php esc_attr_e( 'Next Day', NHSUK_DOMAIN_NAME ); ?>"
		title="<?php esc_attr_e( 'Next Day', NHSUK_DOMAIN_NAME ); ?>"
		disabled
	>
		<?php esc_html_e( 'Next Day', NHSUK_DOMAIN_NAME ); ?>
	</button>
</li>
