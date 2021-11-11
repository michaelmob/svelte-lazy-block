<?php

/**
 * Plugin Name:     Svelte Lazy Block
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     svelte-lazy-block
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Svelte_Lazy_Block
 */

function svelte_component_render($result, $attributes, $context)
{
  $id = "svelte-component";
  return "
  <div id=\"${id}\"></div>
  <script>
  (function() {
    const svelte = new SvelteComponent({
      target: document.querySelector('#${id}'),
      props: " . json_encode($attributes) . "
    });
  })();
  </script>
  ";
}

add_action('wp_enqueue_scripts', function () {
  if (!has_block('lazyblock/svelte-component'))
    return;

  $filename = plugin_dir_url( __FILE__ ) . 'ui/dist/component';
  wp_enqueue_script('svelte-component', $filename . '.js');
  wp_enqueue_style('svelte-component', $filename . '.css');

  add_filter('lazyblock/svelte-component/callback', 'svelte_component_render', 10, 3);
});
