<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-calendly',
		get_template_directory_uri() .'/blocks/calendly/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	register_block_type( 'sc-avax/calendly', array(
		'editor_script' => 'sc-avax-script-calendly',
		'render_callback' => 'sc_avax_calendly_html',
	) );
} );

function sc_avax_calendly_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}