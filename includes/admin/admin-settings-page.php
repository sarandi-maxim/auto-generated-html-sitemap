<?php
/**
 * Admin Page Template
 *
 * @package    WordPress
 * @subpackage html-sitemap-generator
 */

?>
<div class="wrap">
	<form method="post" action="options.php">
		<table class="form-table">
			<?php settings_fields( 'aghs_options_group' ); ?>
			<?php do_settings_sections( 'aghs_options_section' ); ?>
			<?php submit_button(); ?>
		</table>
	</form>
</div>
