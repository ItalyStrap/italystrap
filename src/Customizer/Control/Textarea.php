<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

use WP_Customize_Control;

class Textarea extends WP_Customize_Control
{
    /**
     * Render the control's content.
     *
     * Allows the content to be overriden without having to rewrite the wrapper.
     *
     * @since   10/16/2012
     * @return  void
     */
	// phpcs:ignore
	public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <textarea class="large-text" cols="20" rows="10" <?php $this->link(); ?>>
                <?php echo esc_textarea($this->value()); ?>
            </textarea>
        </label>
        <?php
    }
}
