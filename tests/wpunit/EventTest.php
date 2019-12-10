<?php

class EventTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    
    public function setUp(): void
    {
        // Before...
        parent::setUp();

        // Your set up methods here.
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }

	public function getIntance() {
		$sut = new \ItalyStrap\Event\Manager();
		$this->assertInstanceOf( \ItalyStrap\Event\Manager::class, $sut, '' );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldBeinstantiable()
	{
		$this->getIntance();
	}

	/**
	 * @test
	 */
	public function ItShouldBeinstantiablefgdfg()
	{
		$sut = $this->getIntance();
		$sut->add_subscriber( new class implements \ItalyStrap\Event\Subscriber_Interface {
			/**
			 * @inheritDoc
			 */
			public static function get_subscribed_events(): array {
				return [
					'italystrap_theme_load'	=> [
						\ItalyStrap\Event\Manager::CALLBACK	=> 'start',
						\ItalyStrap\Event\Manager::PRIORITY	=> 20,
					]
				];
			}
		});
	}
}
