<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Navigation\Admin;

use ItalyStrap\Navigation\Admin\ItemCustomFieldsSubscriber;
use ItalyStrap\Tests\IntegrationTestCase;

class ItemCustomFieldsSubscriberTest extends IntegrationTestCase
{
    private int $menuId;

    private int $itemId;

    public function setUp(): void
    {
        parent::setUp();
        $this->menuId = (int)\wp_create_nav_menu('Item custom fields ' . \uniqid());
        $this->itemId = (int)\wp_update_nav_menu_item($this->menuId, 0, [
            'menu-item-title' => 'Home',
            'menu-item-url' => \home_url('/'),
            'menu-item-status' => 'publish',
        ]);
    }

    public function tearDown(): void
    {
        unset($_POST['update-nav-menu-nonce'], $_REQUEST['update-nav-menu-nonce'], $_POST['menu-item-glyphicon']);
        parent::tearDown();
    }

    public function testItShouldSkipAMenuItemSavedOutsideTheMenusScreen(): void
    {
        \update_post_meta($this->itemId, 'menu-item-glyphicon', 'star');

        (new ItemCustomFieldsSubscriber())->saveFields($this->menuId, $this->itemId, []);

        $this->assertSame('star', \get_post_meta($this->itemId, 'menu-item-glyphicon', true));
    }

    public function testItShouldSaveTheFieldsPostedByTheMenusScreen(): void
    {
        $nonce = \wp_create_nonce('update-nav_menu');
        $_POST['update-nav-menu-nonce'] = $nonce;
        $_REQUEST['update-nav-menu-nonce'] = $nonce;
        $_POST['menu-item-glyphicon'] = [$this->itemId => 'heart'];

        (new ItemCustomFieldsSubscriber())->saveFields($this->menuId, $this->itemId, []);

        $this->assertSame('heart', \get_post_meta($this->itemId, 'menu-item-glyphicon', true));
    }
}
