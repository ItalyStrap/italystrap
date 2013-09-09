<form  role="search" method="get" class="row" action="<?php bloginfo('url'); ?>">
	<div class="col-md-12">
		<div class="input-group input-group-sm">
				<input type="text" size="16" placeholder="Non trovi qualcosa? Cercalo ora!" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="form-control">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-default" value="<?php _e('Cercalo ora'); ?>"><i class="glyphicon glyphicon-search"></i></button>
				</span>
		</div>
	</div>
</form>