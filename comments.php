<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package ItalyStrap
 * @since ItalyStrap 1.8.1
 */
declare(strict_types=1);

namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\ListenerRegisterInterface;
use function _n;
use function do_blocks;
use function get_comment_pages_count;
use function get_comments_number;
use function get_option;
use function get_the_title;
use function have_comments;
use function in_array;
use function ItalyStrap\Factory\injector;
use function number_format_i18n;
use function ob_get_clean;
use function ob_start;
use function post_password_required;
use function printf;
use function the_comments_pagination;
use function wp_list_comments;

/**
 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
 */
// if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
// 	return;
// }

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/** @var Injector $injector */
$injector = injector();

/** @var ListenerRegisterInterface $listenerRegister */
$listenerRegister = $injector->make(ListenerRegisterInterface::class);

/** @var ConfigInterface $config */
$config = $injector->make(ConfigInterface::class);

$template_settings = (array) $config->get('post_content_template');

if ( ! have_comments() ) {
	return;
}
?>
<section id="comments" class="comments-area">
	<h3 class="comments-title">
		<?php
		/**
		 * The comment number
		 */
		$comment_number = get_comments_number();
		printf(
			/* translators: 1: number of comments, 2: post title */
			_n( '%1$s response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', $comment_number, 'italystrap' ),
			number_format_i18n( $comment_number ),
			get_the_title()
		);
		?>
	</h3>
	<?php
	// DRY
	$comment_pagination = '';
	if ( get_comment_pages_count() > 1 && get_option('page_comments') ) {
		ob_start();
		the_comments_pagination(
			[
				'prev_text'	=> __( '&laquo; Previous comments', 'italystrap' ),
				'next_text'	=> __( 'Next comments &raquo;', 'italystrap' ),
			]
		);
		$comment_pagination = ob_get_clean();
	}

	echo $comment_pagination;
	echo '<ol class="commentlist">';
	/**
	 * 'max_depth'     => 3 is set in WordPress option
	 */
	wp_list_comments();
	echo '</ol>';
	echo $comment_pagination;

	?>
</section>
<?php  // End have_comments().

if ( ! in_array( 'hide_comments_form', $template_settings, true )  ) {
	$listenerRegister->addListener(
		'comment_form_comments_closed',
		static function () {
			echo '<p class="no-comments">' . __( 'Comments are closed.', 'italystrap' ) . '</p>';
		}
	);

	echo do_blocks( '<!-- wp:post-comments-form /-->' );
}
