<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-industries',
		get_template_directory_uri() .'/blocks/industries/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	register_block_type( 'sc-avax/industries', array(
		'editor_script' => 'sc-avax-script-industries',
		'render_callback' => 'sc_avax_industries_html',
	) );
} );

function sc_avax_industries_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}