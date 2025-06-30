<?php
require_once get_template_directory() . '/inc/interfaces/IPDFGeneratorProcessor.php';
 
add_action('wp_ajax_pdf_creator_process', 'pdf_creator_process_callback');
add_action('wp_ajax_nopriv_pdf_creator_process', 'pdf_creator_process_callback');

function pdf_creator_process_callback() {

    global $СontainerDI;
    global $GutenbergUrl;

    try {
        $arParams = json_decode(stripslashes($_POST['PARAMETERS']), true);
        $generator = $СontainerDI->get(IPDFGeneratorProcessor::class);
        $html = $generator->Process($arParams, $GutenbergUrl);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }

    wp_send_json_success($html); 
    wp_die();
}
