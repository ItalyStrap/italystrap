<?php 
/**
 *
 * Style for entry meta for 
 */
?>
<ul class="list-inline">
	<li><span class="glyphicon glyphicon-calendar"></span> <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time('d-m-Y') ?></time></li>
	<li><span class="glyphicon glyphicon-user"></span> <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span></li>

	<?php if ( comments_open() ): ?>
		<li><span class="glyphicon glyphicon-comment"></span> <?php comments_number( '0 risposte', '1 risposta', '% risposte' ); ?></li>
	<?php endif ?>
	
	<?php if ( !is_page() ): ?>
		<li><span class="glyphicon glyphicon-folder-open"></span> <?php the_category('&');?></li>
	<?php endif ?>

	<?php the_tags('<li itemprop="keywords"><span class="glyphicon glyphicon-tags"></span> ',' - ' , '</li>'); ?>
</ul>