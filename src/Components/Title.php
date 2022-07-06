<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use function ItalyStrap\Core\get_template_settings;

class Title implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface {

	private ConfigInterface $config;

	public function getSubscribedEvents(): iterable {
		yield 'italystrap_entry_content' => [
			self::CALLBACK => self::DISPLAY_METHOD_NAME,
			self::PRIORITY  => 20,
		];
	}

	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	public function shouldDisplay(): bool {
		return \post_type_supports(  (string)\get_post_type(), 'title' )
			&& ! \in_array( 'hide_title', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		echo \do_blocks($this->title());
	}

	private function title(): string {

		$post_title_config = [
			"level" => \is_singular() ? 1 : 2,
			"isLink" => true,
			"rel" => "bookmark",
			"className" => "entry-title",
		];

		\ob_start();
		?>
		<!-- wp:group {"tagName":"header","className":"page-header entry-header","layout":{"inherit":true}} -->
		<header class="wp-block-group page-header entry-header">

			<!-- wp:post-title <?php echo \json_encode( $post_title_config );?> /-->

		</header>
		<!-- /wp:group -->
		<?php
		return \ob_get_clean();
	}
}
