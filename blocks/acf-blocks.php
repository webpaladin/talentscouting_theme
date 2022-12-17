<?php

add_action('acf/init', 'children_acf_init_block_types');
function children_acf_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
		acf_register_block_type(array(
            'name'              => 'projects-list',
            'title'             => __('Projects List'),
            'description'       => __('Show projects list'),
            'render_template'   => 'children/blocks/projects-list.php',
            'category'          => 'sc-avax-blocks',
            'icon'              => 'button',
            'keywords'          => array( 'project', 'list' ),
        ));

        acf_register_block_type(array(
            'name'              => 'management-list',
            'title'             => __('Management List'),
            'description'       => __('Show Management list'),
            'render_template'   => 'children/blocks/management-list.php',
            'category'          => 'sc-avax-blocks',
            'icon'              => 'button',
            'keywords'          => array( 'project', 'list', 'management' ),
        ));
		
    }
}