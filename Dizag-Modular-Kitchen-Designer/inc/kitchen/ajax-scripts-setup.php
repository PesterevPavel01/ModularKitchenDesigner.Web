<?
add_action( 'wp_enqueue_scripts', 'ajax_kitchen_scripts_setup' );	

function ajax_kitchen_scripts_setup() {
    
    if(!is_page('kitchen'))
        return;

    $ajax_url = admin_url('admin-ajax.php');

    $main_parts_url = get_template_directory_uri() . '/parts/main/';
    $main_parts_path = get_template_directory() . '/parts/main/';
    $assets_ajax_scripts_path = get_template_directory() . '/assets/js/ajax/';
    $assets_ajax_scripts_url = get_template_directory_uri() . '/assets/js/ajax/';

    $pdf_order_creator_url = get_template_directory_uri() . '/parts/main/pdf-order-creator/';
    $pdf_order_creator_path = get_template_directory() . '/parts/main/pdf-order-creator/';

    enqueue_versioning_script( 'params-default-creator-js', $main_parts_url, $main_parts_path, 'params-default-creator.js', ['jquery-init']);
    enqueue_versioning_script( 'content-update-js', $main_parts_url, $main_parts_path,  'script.js', ['params-default-creator-js']);
    enqueue_versioning_script( 'pdf-order-creator-js', $pdf_order_creator_url , $pdf_order_creator_path,  'script.js', ['content-update-js']);

    wp_localize_script( 'content-update-js', 'ajax_url', $ajax_url);
    wp_localize_script( 'content-update-js', 'main_parts_url', $main_parts_url );
    wp_localize_script( 'content-update-js', 'pdf_order_creator_url', $pdf_order_creator_url );
    wp_localize_script( 'pdf-order-creator-js', 'ajax_url', $ajax_url);
}
?>