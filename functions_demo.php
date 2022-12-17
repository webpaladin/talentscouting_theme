<?php

/* Отключаем админ панель для всех пользователей. */
show_admin_bar(false);



// Подключаем скрипты

add_action('wp_enqueue_scripts', 'my_scripts_method');
function my_scripts_method() {
  wp_enqueue_script('scg-script-theme',
    get_template_directory_uri() . '/js/main.js',
    array('jquery'), '1.0.0', true
);
  $translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
  wp_localize_script( 'scg-script-theme', 'object_name', $translation_array );
}
// var templateUrl = object_name.templateUrl;  - путь к папке темы в js





if(function_exists('register_sidebar'))
	register_sidebar(array(
        'name' => ' Боковой сайдбар',
        'id' => 'sidebar',
        'before_widget' => '<div class="vidget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'));

register_sidebar(array(
    'name' => 'Нижний сайдбар',
    'id' => 'bottomsidebar',
    'before_widget' => '<div class="vidget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'));



if (function_exists('add_theme_support')) {add_theme_support('menu');}
register_nav_menus( array(
  'topmenu' => 'Верхнее меню'
) );

	add_theme_support('post-thumbnails'); // поддержка миниатюр
	set_post_thumbnail_size(260, 400, TRUE);


    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'lawyers-archive', 330, 428, true );
        add_image_size( 'lawyer', 360, 400, true );
    }


	// Отключаем ссылки из меню на страницу на которой находимся
    function wp_nav_menu_extended($args = array()) {
        $_echo = array_key_exists('echo', $args) ? $args['echo'] : true;
        $args['echo'] = false;

        $menu = wp_nav_menu($args);

    // Load menu as xml
        $menu = simplexml_load_string($menu);

    // Find current menu item with xpath selector
        if (array_key_exists('xpath', $args)) {
            $xpath = $args['xpath'];
        } else {
            $xpath = '//li[contains(@class, "current-menu-item") or contains(@class, "current_page_item")]';
        }

        $current = $menu->xpath($xpath);

    // If current item exists
        if (!empty($current)) {
            $text_node = (string) $current[0]->children();

        // Remove link
            unset($current[0]->a);

        // Create required element with text from link
            $element_name = $args['replace_a_by'] ? $args['replace_a_by'] : 'span';

            $dom = dom_import_simplexml($current[0]);
            $n = $dom->insertBefore(
                $dom->ownerDocument->createElement($element_name, $text_node),
                $dom->firstChild
            );

            $current[0] = simplexml_import_dom($n);
        }

        $xml_doc = new DOMDocument('1.0', 'utf-8');
        $menu_x = $xml_doc->importNode(dom_import_simplexml($menu), true);
        $xml_doc->appendChild($menu_x);

        $menu = $xml_doc->saveXML($xml_doc->documentElement);

        if ($_echo) {
            echo $menu;
        } else {
            return $menu;
        }
    }


	// отключаем Эмоджо смайлы
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );


	// постраничная навигация. в месте где будет распологатся добавить: <?php if (function_exists('wp_corenavi')) wp_corenavi(); ? > 
	// (убрать пробел между ? и >) 
    function wp_corenavi() {
      global $wp_query;
      $pages = '';
      $max = $wp_query->max_num_pages;
      if (!$current = get_query_var('paged')) $current = 1;
      $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
      $a['total'] = $max;
      $a['current'] = $current;

  $total = 1; //1 - выводить текст "Страница N из N", 0 - не выводить
  $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
  $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
  $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
  $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"

  if ($max > 1) echo '<div class="navigation">';
  if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
  echo $pages . paginate_links($a);
  if ($max > 1) echo '</div>';
}

// добавление страницы опции темы в меню админки
if( function_exists('acf_add_options_page') ) {  
  acf_add_options_page(array(
    'page_title'    => 'Настройки сайта',
    'menu_title'    => 'Настройки сайта',
    'menu_slug'     => 'theme-general-settings',
    'capability'    => 'edit_posts',
    'redirect'      => true,
    'icon_url'      => 'dashicons-welcome-widgets-menus'
));
  acf_add_options_sub_page(array(
    'page_title'    => 'Главная',
    'menu_title'    => 'Главная',
    'parent_slug'   => 'theme-general-settings',
    'menu_slug'     => 'home-settings',
)); 
  acf_add_options_sub_page(array(
    'page_title'    => 'Контакты',
    'menu_title'    => 'Контакты',
    'parent_slug'   => 'theme-general-settings',
    'menu_slug'     => 'contacts-settings',
));
  acf_add_options_sub_page(array(
    'page_title'    => 'О компании',
    'menu_title'    => 'О компании',
    'parent_slug'   => 'theme-general-settings',
    'menu_slug'     => 'about-settings',
));
  acf_add_options_sub_page(array(
    'page_title'    => 'Дополнителные',
    'menu_title'    => 'Дополнителные',
    'parent_slug'   => 'theme-general-settings',
    'menu_slug'     => 'other-settings',
)); 
}

add_theme_support( 'html5', array( 'search-form' ) );


// регистрируем блок Услуги
add_action( 'init', 'create_post_services' );
function create_post_services() {
  register_post_type( 'services',
    array(
      'labels' => array(
        'name' => 'Услуги',
        'singular_name' => 'Услуги',
        'add_new' => 'Добавить услугу',
        'add_new_item' => 'Добавить новую услугу',
        'edit' => 'Редактировать',
        'edit_item' => 'Редактировать услугу',
        'new_item' => 'Новая услуга',
        'view' => 'Просмотреть',
        'view_item' => 'Просмотр услуги',
        'search_items' => 'Поиск услуги',
        'not_found' => 'услуги не найдены',
        'not_found_in_trash' => 'В корзине нет услуг',
        'parent' => 'Родитеская услуга',
                'menu_name' => 'Услуги' // ссылка в меню в админке  
            ),
      'public' => true,
      'menu_position' => 5,
      'show_in_rest' => true, // gutenberg editor
      'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields', ),
      'taxonomies' => array(''),
      'menu_icon' => 'dashicons-media-spreadsheet',
      'has_archive' => true,
      'rewrite' => array('slug' => 'services'),
  )
);
}

// добавляем категории услуг
add_action('init', 'services_category');
function services_category(){
    // заголовки
    $labels = array(
        'name'              => 'Категории услуг',
        'singular_name'     => 'Категории услуг',
        'search_items'      => 'Поиск категории услуг',
        'all_items'         => 'Все категории услуг',
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => 'редактировать категорию услуг',
        'update_item'       => 'Обновить категорию услуг',
        'add_new_item'      => 'Добавить новыю категорию услуг',
        'new_item_name'     => 'Новое название категории услуг',
        'menu_name'         => 'Категории услуг',
    ); 
    // параметры
    $args = array(
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => null, // равен аргументу public
        'show_in_nav_menus'     => true, // равен аргументу public
        'show_ui'               => true, // равен аргументу public
        'show_tagcloud'         => true, // равен аргументу show_ui
        'hierarchical'          => true,
        'update_count_callback' => '',
        'rewrite'               => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities'          => array(),
        'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
        'show_admin_column'     => false, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
        '_builtin'              => false,
        'show_in_quick_edit'    => null, // по умолчанию значение show_ui
    );
    register_taxonomy('services_category', array('services'), $args );
}


// Переименовываем записи в статьи
function edit_admin_menus() {
    global $menu;
// здесь будут пункты меню, которые нужно менять
    $menu[5][0] = 'Статьи'; // Изменить название
}
add_action( 'admin_menu', 'edit_admin_menus' );


// Шорткод для вставки фрмы подписки в статью [form]
function form_func(){
 return '<div class="get-consultation subscribe">
 <div class="consultation-wrapper">
 <div class="get-consultation_content">
 <p class="get-consultation_title">Не пропустите важные изменения в законодательстве!</p>
 <p class="get-consultation_text">Будьте в курсе последних новостей в сфере защиты интеллектуальной собственности.</p>
 <p class="get-consultation_text-attention">Только полезная рассылка!</p>
 </div>
 <form class="subscribe-form">
 <input type="email" placeholder="E-mail" name="email">
 <input type="submit" value="Подписаться">
 </form>
 </div>
 </div>';
}
add_shortcode('form', 'form_func');


// стили в админке
function my_stylesheet1(){
    wp_enqueue_style("style-admin",get_bloginfo('stylesheet_directory')."/css/style-admin.css");
}
add_action('admin_head', 'my_stylesheet1');


// своя палитра в блоках гутенбкрг
add_theme_support( 'editor-color-palette', array(
    array(
        'name'  => __( 'Orrange', 'genesis-sample' ),
        'slug'  => 'orrange',
        'color' => '#F7AC6A',
    ),
    array(
        'name'  => __( 'Black', 'genesis-sample' ),
        'slug'  => 'medium-black',
        'color' => '#02111B',
    ),
    array(
        'name'  => __( 'Peach', 'genesis-sample' ),
        'slug'  => 'peach',
        'color' => '#F5BDA4',
    ),
) );


//Подключение svg
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






// Breadcrumbs
function custom_breadcrumbs() {
 
    // Settings
    $separator          = '»';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
    
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
    
    // Get the query & post information
    global $post,$wp_query;
    
    // Do not display on the homepage
    if ( !is_front_page() ) {
     
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
        
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
        
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
          
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
            
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
          
            // If post is a custom post type
            $post_type = get_post_type();
            
            // If it is a custom post type display name and link
            if($post_type != 'post') {
              
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                
            }
            
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
            
        } else if ( is_single() ) {
          
            // If post is a custom post type
            $post_type = get_post_type();
            
            // If it is a custom post type display name and link
            if($post_type != 'post') {
              
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                
            }
            
            // Get post category info
            $category = get_the_category();
            
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
                
            }
            
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
             
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
                
            }
            
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
              
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                
            } else {
              
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                
            }
            
        } else if ( is_category() ) {
         
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
            
        } else if ( is_page() ) {
         
            // Standard page
            if( $post->post_parent ){
             
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                
                // Get parents in the right order
                $anc = array_reverse($anc);
                
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                
                // Display parent pages
                echo $parents;
                
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                
            } else {
             
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                
            }
            
        } else if ( is_tag() ) {
         
            // Tag page
         
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
            
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
            
        } elseif ( is_day() ) {
         
            // Day archive
         
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
            
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
            
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
            
        } else if ( is_month() ) {
         
            // Month Archive
         
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
            
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
            
        } else if ( is_year() ) {
         
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
            
        } else if ( is_author() ) {
         
            // Auhor archive
         
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
            
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
            
        } else if ( get_query_var('paged') ) {
         
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
            
        } else if ( is_search() ) {
         
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
            
        } elseif ( is_404() ) {
         
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
        
        echo '</ul>';
        
    }
    
}