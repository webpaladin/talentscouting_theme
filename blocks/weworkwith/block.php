<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-weworkwith',
		get_template_directory_uri() .'/blocks/weworkwith/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	register_block_type( 'sc-avax/weworkwith', array(
		'editor_script' => 'sc-avax-script-weworkwith',
		'render_callback' => 'sc_avax_weworkwith_html',
	) );

	add_action('wp_enqueue_scripts', function() {
		wp_enqueue_script('sc-avax-weworkwith-front-script',
			get_template_directory_uri() .'/blocks/weworkwith/sc-avax-weworkwith-front-script.js',
			array('jquery'), '1.0.0', true );
	});
} );

function sc_avax_weworkwith_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}