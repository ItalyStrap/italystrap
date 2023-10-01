<?php

/**
 * The main template file.
 *
 * By default, WordPress sets your site’s home page to display your latest blog posts.
 * This page is called the blog posts index.
 * You can also set your blog posts to display on a separate static page.
 * The template file home.php is used to render the blog posts index,
 * whether it is being used as the front page or on separate static page.
 * If home.php does not exist, WordPress will use index.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Main\Events\Content;
use ItalyStrap\UI\Components\Main\Events\ContentAfter;
use ItalyStrap\UI\Components\Main\Events\ContentBefore;
use ItalyStrap\UI\Components\Main\Events\Footer;
use ItalyStrap\UI\Components\Main\Events\Header;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @var $this ConfigInterface
 */

$dispatcher = (object)$this->get(EventDispatcherInterface::class);
?>
<?= $dispatcher->dispatch(new Header()); ?>
<!-- wp:group {"tagName":"main","align":"full","layout":{"inherit":false}} -->
<main class="wp-block-group alignfull">
<?php
//  open_tag_e( 'index-container', 'div', [
//          'class' => (string)$this->get('container_class_names'),
//  ] );
//      open_tag_e( 'index-row', 'div', [
//          'class' => (string)$this->get('row_class_names'),
//      ] );
?>
    <!-- wp:columns {"align":"wide","layout":{"inherit":true}} -->
    <div class="wp-block-columns alignwide">

        <?= $dispatcher->dispatch(new ContentBefore()); ?>

        <!-- wp:column -->
        <div class="wp-block-column">
            <?= $dispatcher->dispatch(new Content()); ?>
        </div>
        <!-- /wp:column -->

        <?= $dispatcher->dispatch(new ContentAfter()); ?>

    </div>
    <!-- /wp:columns -->
    <?php

//      close_tag_e( 'index-row' );
//  close_tag_e( 'index-container' );
    ?>
</main>
<!-- /wp:group -->
<?= $dispatcher->dispatch(new Footer()); ?>
