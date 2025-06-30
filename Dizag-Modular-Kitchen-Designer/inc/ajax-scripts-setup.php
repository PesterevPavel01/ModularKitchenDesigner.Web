<?
add_action( 'wp_enqueue_scripts', 'ajax_scripts_setup' );	

function ajax_scripts_setup() {
    
    $ajax_url = admin_url('admin-ajax.php');

    $main_parts_url = get_template_directory_uri() . '/parts/main/';
    $main_parts_path = get_template_directory() . '/parts/main/';
    $assets_path = get_template_directory() . '/parts/assets/';

    $pdf_order_creator_url = get_template_directory_uri() . '/parts/main/pdf-order-creator/';
    $pdf_order_creator_path = get_template_directory() . '/parts/main/pdf-order-creator/';

    $js_url = get_template_directory_uri() . '/assets/js/';
	$js_path = get_template_directory() . '/assets/js/';

    enqueue_versioning_script( 'params-default-creator-js', $main_parts_url, $main_parts_path, 'params-default-creator.js', ['jquery-init']);
    enqueue_versioning_script( 'content-update-js', $main_parts_url, $main_parts_path,  'script.js', ['params-default-creator-js']);
    enqueue_versioning_script( 'pdf-order-creator-js', $pdf_order_creator_url , $pdf_order_creator_path,  'script.js', ['content-update-js']);


    wp_localize_script( 'content-update-js', 'ajax_url', $ajax_url);
    wp_localize_script( 'content-update-js', 'main_parts_url', $main_parts_url );
    wp_localize_script( 'content-update-js', 'pdf_order_creator_url', $pdf_order_creator_url );
    wp_localize_script( 'pdf-order-creator-js', 'ajax_url', $ajax_url);
}