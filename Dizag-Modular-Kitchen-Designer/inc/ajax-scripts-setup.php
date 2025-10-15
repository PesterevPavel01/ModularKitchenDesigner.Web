<?
add_action( 'wp_enqueue_scripts', 'ajax_scripts_setup' );	

function ajax_scripts_setup() {
    
    $ajax_url = admin_url('admin-ajax.php');

    $main_parts_url = get_template_directory_uri() . '/parts/main/';
    $main_parts_path = get_template_directory() . '/parts/main/';
    $assets_ajax_scripts_path = get_template_directory() . '/assets/js/ajax/';
    $assets_ajax_scripts_url = get_template_directory_uri() . '/assets/js/ajax/';

    $pdf_order_creator_url = get_template_directory_uri() . '/parts/main/pdf-order-creator/';
    $pdf_order_creator_path = get_template_directory() . '/parts/main/pdf-order-creator/';

    $js_url = get_template_directory_uri() . '/assets/js/';
	$js_path = get_template_directory() . '/assets/js/';

    $preloader_url = get_template_directory_uri() . '/assets/img/icons/oval.svg';

    enqueue_versioning_script( 'params-default-creator-js', $main_parts_url, $main_parts_path, 'params-default-creator.js', ['jquery-init']);
    enqueue_versioning_script( 'content-update-js', $main_parts_url, $main_parts_path,  'script.js', ['params-default-creator-js']);
    enqueue_versioning_script( 'default-content-updater-js', $assets_ajax_scripts_url, $assets_ajax_scripts_path,  'ajax-default-content-updater.js', ['jquery-init']);
    enqueue_versioning_script( 'pdf-order-creator-js', $pdf_order_creator_url , $pdf_order_creator_path,  'script.js', ['content-update-js']);


    wp_localize_script( 'content-update-js', 'ajax_url', $ajax_url);
    wp_localize_script( 'content-update-js', 'main_parts_url', $main_parts_url );
    wp_localize_script( 'content-update-js', 'pdf_order_creator_url', $pdf_order_creator_url );
    wp_localize_script( 'pdf-order-creator-js', 'ajax_url', $ajax_url);
    wp_localize_script( 'default-content-updater-js', 'ajax_url', $ajax_url);
    wp_localize_script( 'default-content-updater-js', 'preloader_url', $preloader_url );
}

function enqueue_template_part_styles_scripts($part_path, $title) {
	
	$handle = 'css-' . $title . '-style';
    $handle_js = 'js-' . $title . '-style';
	
	$path = $part_path . '/';
	
	$ajax_url = admin_url('admin-ajax.php');
    $catalog_parts_url = get_template_directory_uri() . '/parts/catalog/';

	$url = get_template_directory_uri() . str_replace(get_template_directory(), '', $part_path) . '/';

	if (!wp_style_is($handle, 'enqueued'))
	{
		enqueue_versioning_style($handle, $url, $path, 'style.css');
	}

	enqueue_versioning_script($handle_js, $url, $path, 'script.js', ['jquery-init']);

    wp_localize_script( $handle_js, 'ajax_url', $ajax_url);
    wp_localize_script( $handle_js, 'catalog_parts_url', $catalog_parts_url );
}