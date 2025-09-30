<?php 
add_action('wp_ajax_catalog_content_update', 'catalog_content_update_callback');
add_action('wp_ajax_nopriv_catalog_content_update', 'catalog_content_update_callback');

function catalog_content_update_callback() {

    $arParams = json_decode(stripslashes($_POST['PARAMETERS']), true);
    
	$catalog_parts_url = get_template_directory_uri() . '/parts/catalog/';
	ob_start();
    get_template_part($arParams['TEMPLATE_PART_TO_UPDATE'],null,$arParams['PARAMETERS']);
    $content = ob_get_clean();
    echo json_encode([
        'HTML_BLOCK' => $arParams['HTML_BLOCK_TO_UPDATE_CLASS'],
        'HTML_CONTENT' => $content,
        'SCRIPT' => $catalog_parts_url . 'script.js',
        'PARAMS' => $arParams
    ]);
	wp_die();
}