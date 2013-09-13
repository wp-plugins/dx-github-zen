<?php
add_action( 'init', 'dx_github_zen_register_shortcode' );

function dx_github_zen_register_shortcode() {
	add_shortcode( 'dx_github_zen' ,  'dx_github_zen_register_shortcode_callback' );
}

/**
 * Register dx_github_zen callback
 * 
 * @return string GitHub message
 */
function dx_github_zen_register_shortcode_callback() {
	$zen_message_object = new DX_GitHub_Zen_Message();
	
	$zen_message = $zen_message_object->get_zen_message();
	
	return apply_filters( 'dx_zen_message_shortcode_output', $zen_message );
}