<?php 


add_action('wp_enqueue_scripts', 'my_scripts_method');
function my_scripts_method() {
	wp_enqueue_style("style-owl-min",get_bloginfo('stylesheet_directory')."/owlcarousel/owl.carousel.min.css");
	wp_enqueue_style("style-owl-default",get_bloginfo('stylesheet_directory')."/owlcarousel/owl.theme.default.min.css");
	wp_enqueue_style("style-theme",get_bloginfo('stylesheet_directory')."/style.css");
	wp_enqueue_script( "script-owl-js", get_template_directory_uri() . "/owlcarousel/owl.carousel.min.js", array("jquery"), "", TRUE );
    wp_enqueue_script( 'jquery-ui-slider', false, array('jquery'));
    wp_enqueue_script('script-theme', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true );
    global $wpdb;
    $max_salary = $wpdb->get_var( "SELECT MAX(cast(meta_value as unsigned)) FROM $wpdb->postmeta WHERE `meta_key` = 'annual_salary'" );
    wp_localize_script( 'script-theme', 'site', 
        array(
            "theme_path"    => get_template_directory_uri(),
            "max_salary"    => $max_salary,
        )
    );
}

include 'blocks/blocks.php';

function my_admin_stylesheet(){
    wp_enqueue_style("style-admin",get_bloginfo('stylesheet_directory')."/css/style-admin.css");
}
add_action('admin_head', 'my_admin_stylesheet');

if (function_exists('add_theme_support')) {add_theme_support('menu');}
register_nav_menus( array(
  'topmenu' => 'Top menu',
  'footermenu' => 'Footer menu'
) );

add_filter( 'upload_mimes', 'svg_upload_allow' );
function svg_upload_allow( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    return $mimes;
}
add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){
    if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
        $dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
    else
        $dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );
    if( $dosvg ){
        if( current_user_can('manage_options') ){
            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
        }
        else {
            $data['ext'] = $type_and_ext['type'] = false;
        }
    }
    return $data;
}
add_filter( 'wp_prepare_attachment_for_js', 'show_svg_in_media_library' );
function show_svg_in_media_library( $response ) {
    if ( $response['mime'] === 'image/svg+xml' ) {
        $response['image'] = [
            'src' => $response['url'],
        ];
    }
    return $response;
}

if( function_exists('acf_add_options_page') ) {  
  acf_add_options_page(array(
    'page_title'    => 'Theme settings',
    'menu_title'    => 'Theme settings',
    'menu_slug'     => 'theme-general-settings',
    'capability'    => 'edit_posts',
    'redirect'      => true,
    'icon_url'      => 'dashicons-welcome-widgets-menus'
));
}

add_action( 'init', 'create_post_jobs' );
function create_post_jobs() {
  register_post_type( 'jobs',
    array(
      'labels' => array(
        'name' => 'Jobs',
        'singular_name' => 'Jobs',
        'add_new' => 'Add job',
        'add_new_item' => 'Add new job',
        'edit' => 'Edit',
        'edit_item' => 'Edit job',
        'new_item' => 'New job',
        'view' => 'View',
        'view_item' => 'View job',
        'search_items' => 'Searcj jobs',
        'not_found' => 'Jobs not found',
        'not_found_in_trash' => 'No jobs in trash',
        'parent' => 'Parent job',
        'menu_name' => 'Jobs'
    ),
      'public' => true,
      'menu_position' => 5,
      'show_in_rest' => true,
      'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields'),
      'taxonomies' => array(''),
      'menu_icon' => 'dashicons-media-spreadsheet',
      'has_archive' => true,
      'rewrite' => array('slug' => 'jobs'),
  )
);
}

add_action('init', 'jobs_industries');
function jobs_industries(){
    $labels = array(
        'name'              => 'Industries',
        'singular_name'     => 'Industries',
        'search_items'      => 'Search industries',
        'all_items'         => 'All industries',
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => 'Edit industry',
        'update_item'       => 'Udate industry',
        'add_new_item'      => 'Add new industry',
        'new_item_name'     => 'New name for industry',
        'menu_name'         => 'Industries',
    ); 
    $args = array(
        'label'                 => '',
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => null,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_tagcloud'         => true,
        'hierarchical'          => true,
        'update_count_callback' => '',
        'rewrite'               => true,
        //'query_var'             => $taxonomy,
        'capabilities'          => array(),
        'meta_box_cb'           => null,
        'show_admin_column'     => true,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,
        'show_in_rest'      => true,
    );
    register_taxonomy('industries', array('jobs'), $args );
}

add_action('init', 'jobs_location');
function jobs_location(){
    $labels = array(
        'name'              => 'Locations',
        'singular_name'     => 'Locations',
        'search_items'      => 'Search locations',
        'all_items'         => 'All locations',
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => 'Edit location',
        'update_item'       => 'Udate location',
        'add_new_item'      => 'Add new location',
        'new_item_name'     => 'New name for location',
        'menu_name'         => 'Locations',
    ); 
    $args = array(
        'label'                 => '',
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => null,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_tagcloud'         => true,
        'hierarchical'          => true,
        'update_count_callback' => '',
        'rewrite'               => true,
        //'query_var'             => $taxonomy,
        'capabilities'          => array(),
        'meta_box_cb'           => null,
        'show_admin_column'     => true,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,
        'show_in_rest'      => true,
    );
    register_taxonomy('locations', array('jobs'), $args );
}

add_action('init', 'jobs_worktype');
function jobs_worktype(){
    $labels = array(
        'name'              => 'Work types',
        'singular_name'     => 'Work types',
        'search_items'      => 'Search work types',
        'all_items'         => 'All work types',
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => 'Edit work type',
        'update_item'       => 'Udate work type',
        'add_new_item'      => 'Add new work type',
        'new_item_name'     => 'New name for work type',
        'menu_name'         => 'Work types',
    ); 
    $args = array(
        'label'                 => '',
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => null,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_tagcloud'         => true,
        'hierarchical'          => true,
        'update_count_callback' => '',
        'rewrite'               => true,
        //'query_var'             => $taxonomy,
        'capabilities'          => array(),
        'meta_box_cb'           => null,
        'show_admin_column'     => true,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,
        'show_in_rest'      => true,
    );
    register_taxonomy('worktypes', array('jobs'), $args );
}

function true_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'true_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
        wp_die('Nothing to duplicate!');
    }
    $post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
    $post = get_post( $post_id );
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
    if (isset( $post ) && $post != null) {
        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'publish',
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );
        $new_post_id = wp_insert_post( $args );
        $taxonomies = get_object_taxonomies($post->post_type);
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }
        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                $meta_value = addslashes($meta_info->meta_value);
                $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }
        wp_redirect( admin_url( 'edit.php?post_type=jobs' ) );
        exit;
    } else {
        wp_die('Error creating post, can\'t find original post with ID=: ' . $post_id);
    }
}
add_action( 'admin_action_true_duplicate_post_as_draft', 'true_duplicate_post_as_draft' );
function true_duplicate_post_link( $actions, $post ) {

    $actions['duplicate'] = '<a href="admin.php?action=true_duplicate_post_as_draft&post=' . $post->ID . '" title="Duplicate this post" rel="permalink">Duplicate</a>';

    return $actions;
}
add_filter( 'post_row_actions', 'true_duplicate_post_link', 10, 2 );
add_filter( 'jobs_row_actions', 'true_duplicate_post_link', 10, 2 );

function wp_corenavi() {
  global $wp_query;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $a['total'] = $max;
  $a['current'] = $current;

  $total = 0;
  $a['mid_size'] = 1;
  $a['end_size'] = 1;
  $a['prev_text'] = '<svg viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.69 21.37L1.31997 11L11.69 0.630005" stroke-width="0.94" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  $a['next_text'] = '<svg viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.30994 0.629997L11.6799 11L1.30994 21.37" stroke-width="0.94" stroke-linecap="round" stroke-linejoin="round"/></svg>
';

  if ($max > 1) echo '<div class="navigation">';
  if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
  echo $pages . paginate_links($a);
  if ($max > 1) echo '</div>';
}

function pagination($page, $count_pages){
    // < 1 ... 3 4 5 ... 7 >
    $back = null;
    $firstpage = null;
    $prewpoints = null;
    $prevpage = null;
    $active = null;
    $nextpage = null;
    $nextpoints = null;
    $lastpage = null;
    $forward = null;
    

    if( $page > 1 ){
        $back = '<a class="prev page-numbers" data-page="' .($page-1). '" href="#"><svg viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.69 21.37L1.31997 11L11.69 0.630005" stroke-width="0.94" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>';
    }
    if( $page < $count_pages ){
        $forward = '<a class="next page-numbers" data-page="' .($page+1). '" href="#"><svg viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.30994 0.629997L11.6799 11L1.30994 21.37" stroke-width="0.94" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>';
    }
    if( $page > 2 ){
        $firstpage = '<a class="page-numbers" href="#" data-page="1">1</a>';
    }
    if( $page > 3 ) {
        $prewpoints = '<span class="page-numbers dots">…</span>';
    }
    if( $page < ($count_pages - 1) ){
        $lastpage = '<a class="page-numbers" href="#" data-page="'.$count_pages.'">'.$count_pages.'</a>';
    }
    if( $page < ($count_pages - 2) ){
        $nextpoints = '<span class="page-numbers dots">…</span>';
    }

    if( $page - 1 > 0 ){
        $prevpage = '<a class="page-numbers" href="#" data-page="'.($page-1).'">'.($page-1).'</a>';
    }
    if( $page + 1 <= $count_pages ){
        $nextpage = '<a class="page-numbers" href="#" data-page="'.($page+1).'">'.($page+1).'</a>';
    }


    return $back.$firstpage.$prewpoints.$prevpage.'<span aria-current="page" class="page-numbers current" data-page="'.($page).'">'.($page).'</span>'.$nextpage.$nextpoints.$lastpage.$forward;
}