<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-aboutus',
		get_template_directory_uri() .'/blocks/aboutus/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	register_block_type( 'sc-avax/aboutus', array(
		'editor_script' => 'sc-avax-script-aboutus',
		'render_callback' => 'sc_avax_aboutus_html',
	) );
} );

function sc_avax_aboutus_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}