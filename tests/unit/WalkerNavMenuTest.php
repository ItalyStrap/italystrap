<?php

declare(strict_types=1);

namespace ItalyStrap\Test;

// phpcs:disable
require_once \codecept_data_dir( 'stubs/' ) . 'class-wp-walker.php';
require_once \codecept_data_dir( 'stubs/' ) . 'class-walker-nav-menu.php';
// phpcs:enable

use Codeception\Test\Unit;
use ItalyStrap\Tests\BaseUnitTrait;
use Walker_Nav_Menu;

class WalkerNavMenuTest extends Unit
{
    use BaseUnitTrait;
    use UndefinedFunctionDefinitionTrait;

    /**
     * @var \UnitTester
     */
    protected $tester;

	// phpcs:ignore
	protected function _before() {
        $this->defineFunction('add_filter', fn(...$args) => true);

        $this->defineFunction('apply_filters', fn(...$args) => $args[1]);

        $this->defineFunction('esc_attr', fn(...$args) => $args[0]);

        $this->defineFunction('remove_filter', fn(...$args) => true);
    }

	// phpcs:ignore
	protected function _after() {
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
