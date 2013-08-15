<form  role="search" method="get" id="search-form" class="form-search" action="<?php bloginfo('home'); ?>">

		<input type="text" size="16" placeholder="Non trovi qualcosa?" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-query">
		<input type="submit" class="btn" value="<?php _e('Cercalo ora'); ?>">

</form>