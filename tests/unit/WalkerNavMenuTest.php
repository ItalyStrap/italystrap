<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit;

// phpcs:disable
require_once \codecept_data_dir( 'stubs/' ) . 'class-wp-walker.php';
require_once \codecept_data_dir( 'stubs/' ) . 'class-walker-nav-menu.php';
// phpcs:enable


use ItalyStrap\Tests\UnitTestCase;

class WalkerNavMenuTest extends UnitTestCase
{
	// phpcs:ignore
	protected function _before() {
        parent::_before();
        $this->defineFunction('add_filter', fn(...$args) => true);

        $this->defineFunction('apply_filters', fn(...$args) => $args[1]);

        $this->defineFunction('esc_attr', fn(...$args) => $args[0]);

        $this->defineFunction('remove_filter', fn(...$args) => true);
    }

    protected function getInstance()
    {
        $sut = new \ItalyStrap\Navbar\BootstrapNavMenu();
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldReturnSubmenu()
    {
        $sut = $this->getInstance();

        $output = '';

        $sut->start_lvl($output);

        $this->assertStringMatchesFormat('<ul role="menu" class="sub-menu">', \trim($output), '');

//      codecept_debug( $output );
    }
}
