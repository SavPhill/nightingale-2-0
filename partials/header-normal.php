<?php
/**
 * The standard header for our theme
 *
 * This is the template that displays the standard header region
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.1 21st August 2019
 */

?>
<div class="nhsuk-width-container nhsuk-header__container">

    <?php get_template_part( 'partials/logo' ); ?>
	<div class="nhsuk-header__content" id="content-header">

		<div class="nhsuk-header__menu">
			<button class="nhsuk-header__menu-toggle" id="toggle-menu" aria-controls="header-navigation"
					aria-label="Open menu">Menu
			</button>
		</div>
		<?php if ( get_theme_mod( 'show_search' ) === 'yes' ) { ?>
			<div class="nhsuk-header__search">
				<?php get_search_form(); ?>
			</div>
			<?php
		}
		?>
	</div>

</div>
