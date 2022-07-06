<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use function ItalyStrap\Core\get_template_settings;

class Meta implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface {

	final public function getSubscribedEvents(): iterable {
		yield 'italystrap_entry_content' => [
			self::CALLBACK => self::DISPLAY_METHOD_NAME,
			self::PRIORITY  => 30,
		];
	}

	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	public function shouldDisplay(): bool {
		return \post_type_supports(  (string)\get_post_type(), 'entry-meta' )
			&& ! \in_array( 'hide_meta', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		echo \do_blocks( $this->output() );
	}

	private function output() {
		\ob_start();
		?>
		<!-- wp:group {"tagName":"footer","layout":{"type":"flex"}} -->
		<footer class="wp-block-group">
			<!-- wp:post-date {"textAlign":"center","isLink":true} /-->

			<!-- wp:post-author {"showAvatar":false} /-->

			<!-- wp:post-terms {"term":"category","textAlign":"center"} /-->

			<!-- wp:post-terms {"term":"post_tag","textAlign":"center"} /-->
		</footer>
		<!-- /wp:group -->
		<?php
		return \ob_get_clean();
	}
}
