<?php
declare(strict_types=1);

namespace ItalyStrap\StdLib;

class CMB2Factory {
	public function make( array $meta_box_config ): \CMB2 {
		return \new_cmb2_box( $meta_box_config );
	}
}
