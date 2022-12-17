<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-howwework',
		get_template_directory_uri() .'/blocks/howwework/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	register_block_type( 'sc-avax/howwework', array(
		'editor_script' => 'sc-avax-script-howwework',
		'render_callback' => 'sc_avax_howwework_html',
	) );

} );

function sc_avax_howwework_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}