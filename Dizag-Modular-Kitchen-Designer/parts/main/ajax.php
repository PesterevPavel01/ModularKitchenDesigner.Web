<?php 

add_action( 'wp_enqueue_scripts', 'content_update_ajax_scripts' );	

function content_update_ajax_scripts() {

    $main_parts_url = get_template_directory_uri() . '/parts/main/';
    $main_parts_path = get_template_directory() . '/parts/main/';

    $js_url = get_template_directory_uri() . '/assets/js/';
	$js_path = get_template_directory() . '/assets/js/';

    enqueue_versioning_script( 'params-default-creator-js', $main_parts_url, $main_parts_path, 'params-default-creator.js', ['jquery-init']);

    enqueue_versioning_script( 'content-update-js', $main_parts_url, $main_parts_path,  'script.js', ['params-default-creator-js']);

    $ajax_url = admin_url('admin-ajax.php');
    wp_localize_script( 'content-update-js', 'ajax_url', $ajax_url);
    wp_localize_script( 'content-update-js', 'main_parts_url', $main_parts_url );

}

add_action('wp_ajax_content_update', 'content_update_callback');
add_action('wp_ajax_nopriv_content_update', 'content_update_callback');

function content_update_callback() {

    $arParams = json_decode(stripslashes($_POST['PARAMETERS']), true);
    //echo json_encode($arParams);
    
	$main_parts_url = get_template_directory_uri() . '/parts/main/';
	ob_start();
    //get_template_part("parts/main/kitchen-type/kitchen-type",null,array('Price_Segment' => $_POST['PRICE_SEGMENT_TITLE']));
    get_template_part($arParams['TEMPLATE_PART_TO_UPDATE'],null,$arParams['PARAMETERS']);
    $content = ob_get_clean();
    echo json_encode([
        'HTML_BLOCK' => $arParams['HTML_BLOCK_TO_UPDATE_CLASS'],
        'HTML_CONTENT' => $content,
        'SCRIPT' => $main_parts_url . 'script.js',
        'PARAMS' => $arParams
    ]);
	wp_die();
    //wp_send_json_success($content);
}

