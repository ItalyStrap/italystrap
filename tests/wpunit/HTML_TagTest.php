<?php

class HTML_TagTest extends \Codeception\TestCase\WPTestCase
{

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

	private function get_instance() {

    	static $sut = null;

    	if ( ! $sut ) {
			ItalyStrap\HTML\Tag::$is_debug = true;
    		$sut = new ItalyStrap\HTML\Tag;
		}

		return $sut;
    }

    // tests
    public function testIsCorrectInstance()
    {
    	$this->assertInstanceOf( ItalyStrap\HTML\Tag::class, $this->get_instance() );
    }

	public function testIsOpenAndCloseCorrect() {

		$open = $this->get_instance()->open( 'test', 'div' );
		$close = $this->get_instance()->close( 'test' );

		$this->assertContains( '<div>', $open );
		$this->assertContains( '</div>', $close );

		$open = $this->get_instance()->open( 'test2', 'div', [ 'class' => 'someClass' ] );
		$close = $this->get_instance()->close( 'test2' );

		$this->assertContains( '<div class="someClass">', $open );
		$this->assertContains( '</div>', $close );

    }

	public function testIsVoidCorrect() {

		$open = $this->get_instance()->void( 'test', 'input' );

		$this->assertContains( '<input/>', $open );

		$open = $this->get_instance()->void( 'test2', 'input', [ 'type' => 'text' ] );

		$this->assertContains( '<input type="text"/>', $open );
    }

	/**
	 * @throws Exception
	 */
//	public function testExpectedException() {
//
//		$this->expectException( \RuntimeException::class );
//
//		$open = $this->get_instance()->open( 'test', 'div' );
//		$this->get_instance()->check_non_closed_tags();
//    }

    /**
	 * @todo Make test for non close tags
	 * @todo make test for tag in context called more than once
	 */

//	public function testIs() {
//
//		$open = $this->get_instance()->open( 'test', 'main' );
//		$open2 = $this->get_instance()->open( 'test', 'main' );
//
//
////		$close = $this->get_instance()->close( 'test' );
//
//		$this->assertContains( '<main>', $open );
//    }
}