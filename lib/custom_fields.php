<?php
add_action('wp_insert_post', 'italystrap_set_default_custom_fields');
 
function italystrap_set_default_custom_fields($post_id)
{
 if (isset($_GET['post_type']) && $_GET['post_type'] == 'prodotti' ) {
 
        add_post_meta($post_id, 'title_headline', '', true);
		add_post_meta($post_id, 'headline', '', true);
        add_post_meta($post_id, 'call_to_action', '', true);
 
    }
    return true;
}