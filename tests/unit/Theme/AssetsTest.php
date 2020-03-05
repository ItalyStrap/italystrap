<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Asset\Asset_Factory;
use ItalyStrap\Theme\Assets;
use ItalyStrap\Theme\Registrable;

require_once 'BaseTheme.php';

class AssetsTest extends BaseTheme
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    	$consts = [
    		'TEMPLATEURL'			=> '',
    		'PARENTPATH'			=> '',
    		'CHILDPATH'				=> '',
    		'STYLESHEETURL'			=> '',
    		'CURRENT_TEMPLATE_SLUG'	=> '',
		];

    	foreach ( $consts as $const => $val ) {
    		if ( defined($const) ) {
    			continue;
			}

    		define($const, $val);
		}
    }

    protected function _after()
    {
    }

	protected function getInstance() {
		$sut = new Assets();
		$this->assertInstanceOf( Registrable::class, $sut, '');
		return $sut;
	}

	public function testFactory() {
		$fac = new Asset_Factory();
		$fac->add_style_and_script();
	}
}