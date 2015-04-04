<div class="wrap">

		<?php settings_errors(); ?>

	<form action='options.php' method='post'>
		
		<?php
		settings_fields( 'italystrap_theme_options_group' );
		do_settings_sections( 'italystrap_theme_options_group' );
		submit_button();
		?>
		
	</form>
</div>