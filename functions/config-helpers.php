<?php

namespace ItalyStrap\Config;

/**
 * @param Config_Interface $config
 * @param array $array_to_merge
 */
function merge_array_to_config( Config_Interface $config, array $array_to_merge = [] ) {
	$config->merge( $array_to_merge );
}
