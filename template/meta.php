<?php 
/**
 * Style for entry meta
 * 
 * Customize the the_time function:
 * the_time('d-m-Y');
 * @link http://codex.wordpress.org/Formatting_Date_and_Time
 * i18n date
 * @link http://codex.wordpress.org/Function_Reference/date_i18n
 *
 * Retrive date format from the admin dashboard under Settings > General Settings
 * the_time( get_option('date_format') );
 *
 * <time> tag is optimized for Schema.org markup - Don't touch
 */
?>
<ul class="list-inline">
	<li><span class="glyphicon glyphicon-calendar"></span> <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time( get_option('date_format') ); ?></time></li>

	<li><span class="glyphicon glyphicon-user"></span> <span itemprop="author"><?php the_author_posts_link(); ?></span></li>

	<?php if ( comments_open() ): ?>
		<li><span class="glyphicon glyphicon-comment"></span> <?php comments_number( __('No Responses', 'ItalyStrap'), __('One Response', 'ItalyStrap'), __( '% Responses', 'ItalyStrap')  ); ?></li>
	<?php endif ?>
	
	<?php
	$category = get_the_category();
	if ( $category ): ?>
		<li><span class="glyphicon glyphicon-folder-open"></span> <?php the_category(' & ');?></li>
	<?php endif ?>

	<?php the_tags('<li itemprop="keywords"><span class="glyphicon glyphicon-tags"></span> ',' - ' , '</li>'); ?>
</ul>