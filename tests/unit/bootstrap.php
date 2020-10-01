<?php

use tad\FunctionMocker\FunctionMocker;

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

FunctionMocker::init(['blacklist' => dirname(__DIR__)]);
