<?

add_action( 'wp_enqueue_scripts', 'catalog_ajax_scripts_setup' );	

function catalog_ajax_scripts_setup() {

    if(!is_page('order') && !is_page('account'))
        return;
    
    $ajax_url = admin_url('admin-ajax.php');

    $assets_ajax_scripts_path = get_template_directory() . '/assets/js/ajax/';
    $assets_ajax_scripts_url = get_template_directory_uri() . '/assets/js/ajax/';

    $js_url = get_template_directory_uri() . '/assets/js/';
	$js_path = get_template_directory() . '/assets/js/';

    $preloader_url = get_template_directory_uri() . '/assets/img/icons/oval.svg';

    enqueue_versioning_script( 'default-content-updater-js', $assets_ajax_scripts_url, $assets_ajax_scripts_path,  'ajax-default-content-updater.js', ['jquery-init']);
    
    //библиотека для блокировки интерфейса при AJAX-запросах
    enqueue_versioning_script('jquery-blockui-js',  $js_url, $js_path,'lib/BlockUI/jquery.blockUI.min.js', ['jquery-init']);

    wp_localize_script( 'default-content-updater-js', 'ar_params', array(
        'ajax_url' => $ajax_url,
        'preloader_url' => $preloader_url));

    if(is_page('order')){

        enqueue_versioning_script( 'file-content-updater-js', $assets_ajax_scripts_url, $assets_ajax_scripts_path,  'ajax-file-content-updater.js', ['jquery-init']);
    
        wp_localize_script( 'file-content-updater-js', 'ar_params', array(
            'ajax_url' => $ajax_url,
            'preloader_url' => $preloader_url,
            'ajax_nonce' =>  wp_create_nonce('blueprint_upload_nonce')
        ));
        
    }
}

function enqueue_template_part_styles_scripts($part_path, $title, $deps = ['jquery-init']) {
	
	$handle = 'css-' . $title . '-style';

    $handle_js = 'js-' . $title . '-script';
	
	$path = $part_path . '/';
	
	$ajax_url = admin_url('admin-ajax.php');

    $catalog_parts_url = get_template_directory_uri() . '/parts/catalog/';

	$url = get_template_directory_uri() . str_replace(get_template_directory(), '', $part_path) . '/';

    $css_file = $path . 'style.css';

    if (file_exists($css_file)) {

        if (!wp_style_is($handle, 'enqueued'))
            enqueue_versioning_style($handle, $url, $path, 'style.css');
    }

    $js_file = $path . 'script.js';

    if (file_exists($js_file)) {
            enqueue_versioning_script($handle_js, $url, $path, 'script.js', ['jquery-init']);
    }
}