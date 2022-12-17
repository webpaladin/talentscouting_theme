<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-ourteam',
		get_template_directory_uri() .'/blocks/ourteam/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	wp_localize_script( 'sc-avax-script-ourteam', 'folder', array(
		'img' => get_template_directory_uri() .'/img/socials/',
	));

	register_block_type( 'sc-avax/ourteam', array(
		'editor_script' => 'sc-avax-script-ourteam',
		'render_callback' => 'sc_avax_ourteam_html',
	) );
} );

function sc_avax_ourteam_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}