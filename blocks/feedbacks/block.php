<?php
add_action( 'init',function(){
	wp_register_script(
		'sc-avax-script-feedbacks',
		get_template_directory_uri() .'/blocks/feedbacks/block.js',
		array(
			'wp-blocks',
			'wp-element',
			'wp-editor'    
		)
	);

	register_block_type( 'sc-avax/feedbacks', array(
		'editor_script' => 'sc-avax-script-feedbacks',
		'render_callback' => 'sc_avax_feedbacks_html',
	) );

	add_action('wp_enqueue_scripts', function() {
		wp_enqueue_script('sc-avax-feedbacks-front-script',
			get_template_directory_uri() .'/blocks/feedbacks/sc-avax-feedbacks-front-script.js',
			array('jquery'), '1.0.0', true );
	});
} );

function sc_avax_feedbacks_html( $attributes, $content ) {

	$content = str_replace(' undefined', '', $content);

	return html_entity_decode($content);
}