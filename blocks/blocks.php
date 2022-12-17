<?php

function sc_custom_block_category( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug' => 'sc-blocks',
				'title' => 'Custom blocks',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'sc_custom_block_category', 10, 2);

function sc_custom_block_category_secondary( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'sc-blocks-secondary',
				'title' => 'secondary blocks',
				'description' => 'secondary blocks, not used independently'
			),
		)
	);
}
add_filter( 'block_categories_all', 'sc_custom_block_category_secondary', 10, 2);

$blocks_array = array(
	'hero',
	'weworkwith',
	'aboutus',
	'industries',
	'ourteam',
	'calendly',
	'feedbacks',
	'howwework',
);

foreach ($blocks_array as $block) {
	include $block.'/block.php';
}

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_style(
		'sc-avax-blocks-style',
		get_template_directory_uri() .'/blocks/style.css',
		array()
	);
} );

add_action('admin_head', function(){
	wp_enqueue_style(
		'sc-avax-blocks-editor-style',
		get_template_directory_uri() .'/blocks/editor.css',
		array( 'wp-edit-blocks' )
	);
});