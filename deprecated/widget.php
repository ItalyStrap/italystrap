<?php
/**
 * Customize your widget here
 * @link http://codex.wordpress.org/Function_Reference/the_widget
 * @link https://core.trac.wordpress.org/browser/tags/3.9.2/src/wp-includes/default-widgets.php#L0
 */

function italystrap_widgets_init() {
 // Widgets
	register_widget('ItalyStrap_Vcard_Widget');
}
add_action('widgets_init', 'italystrap_widgets_init');
/**
 * Example vCard widget
 */
class ItalyStrap_Vcard_Widget extends WP_Widget {
  private $fields = array(
    'title'          => 'Title optional',
    'street_address' => 'Street Address',
    'locality'       => 'City/Locality',
    'region'         => 'State/Region',
    'postal_code'    => 'Zipcode/Postal Code',
    'tel'            => 'Telephone',
    'email'          => 'Email'
  );

  function __construct() {
    $widget_ops = array('classname' => 'widget_italystrap_vcard', 'description' => __('Use this widget to add a vCard', 'ItalyStrap'));

    $this->WP_Widget('widget_italystrap_vcard', 'ItalyStrap: vCard', $widget_ops);
    $this->alt_option_name = 'widget_italystrap_vcard';

    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('widget_italystrap_vcard', 'widget');

    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = null;
    }

    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    ob_start();
    extract($args, EXTR_SKIP);

    $title = apply_filters('widget_title', empty($instance['title']) ? __('Company name', 'ItalyStrap') : $instance['title'], $instance, $this->id_base);

    foreach($this->fields as $name => $label) {
      if (!isset($instance[$name])) { $instance[$name] = ''; }
    }

    echo $before_widget;

    if ($title) {
      echo $before_title, $title, $after_title;
    }
  ?>
	<ul itemscope itemtype="https://schema.org/Organization" class="list-unstyled">
		<meta  itemprop="logo" content="<?php echo italystrap_logo();?>"/>
		<li><strong><a itemprop="url" href="<?php echo esc_attr( HOME_URL ); ?>"><span itemprop="name"><?php echo esc_attr( GET_BLOGINFO_NAME ); ?></span></a></strong></li>
			<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
				<li itemprop="streetAddress"><?php echo $instance['street_address']; ?></li>
				<li itemprop="addressLocality"><?php echo $instance['locality']; ?></li>
				<li itemprop="addressRegion"><?php echo $instance['region']; ?></li>
				<li itemprop="postalCode"><?php echo $instance['postal_code']; ?></li>
			</div>
		<li itemprop="telephone"><?php echo $instance['tel']; ?></li>
		<li itemprop="email"><a href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a></li>
	</ul>
  <?php
    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_italystrap_vcard', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = array_map('strip_tags', $new_instance);

    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');

    if (isset($alloptions['widget_italystrap_vcard'])) {
      delete_option('widget_italystrap_vcard');
    }

    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_italystrap_vcard', 'widget');
  }

  function form($instance) {
    foreach($this->fields as $name => $label) {
      ${$name} = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id($name)); ?>"><?php echo $label; ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id($name)); ?>" name="<?php echo esc_attr($this->get_field_name($name)); ?>" type="text" value="<?php echo ${$name}; ?>">
    </p>
    <?php
    }
  }
}