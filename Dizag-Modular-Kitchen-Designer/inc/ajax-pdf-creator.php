<?php
require_once get_template_directory() . '/inc/interfaces/IProcessor.php';
 
add_action('wp_ajax_pdf_creator_process', 'pdf_creator_process_callback');
add_action('wp_ajax_nopriv_pdf_creator_process', 'pdf_creator_process_callback');

function pdf_creator_process_callback() {

    global $СontainerDI;

    try {
        $arParams = json_decode(stripslashes($_POST['PARAMETERS']), true);
        $generator = $СontainerDI->get(IProcessor::class);
        $data['HTML'] = generate_order_html($arParams);
        $url = $generator->Process($data);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }

    wp_send_json_success($url); 
    wp_die();
}

function generate_order_html($data) {
    ob_start();
    get_template_part('parts/templates/pdf-order-template', null, $data);
    $html = ob_get_clean();
    return  $html;
}