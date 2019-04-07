<?php
/**
 * Form for search in WordPress site
 * @link https://codex.wordpress.org/Function_Reference/get_search_form
 * Add markup for Sitelinks Search Box, @see link below for more informations
 * @link https://developers.google.com/structured-data/slsb-overview
 */

namespace ItalyStrap;

?>
<div itemscope itemtype="https://schema.org/WebSite">
	<meta itemprop="url" content="<?php echo esc_attr( HOME_URL ); ?>"/>
	<form  role="search" method="get" id="searchform" class="search-form" action="<?php echo esc_attr( HOME_URL ); ?>" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
		<meta itemprop="target" content="<?php echo esc_attr( HOME_URL ); ?>?s={s}"/>
		<div class="input-group input-group-sm">
			<span class="screen-reader-text sr-only"><?php esc_attr_e( 'Search now', 'italystrap' ); ?></span>
			<input type="search" size="16" placeholder="<?php esc_attr_e( 'Search now', 'italystrap' ); ?>" value="<?php if ( is_search() ) echo get_search_query();?>" name="s" class="form-control" itemprop="query-input" >
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default" value="<?php esc_attr_e( 'Search', 'italystrap' ); ?>"><i class="glyphicon glyphicon-search"></i></button>
			</span>
		</div>
	</form>
</div>
