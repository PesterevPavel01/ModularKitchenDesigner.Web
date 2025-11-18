<?php 

add_action('wp_ajax_default_content_updater', 'default_content_updater_callback');
add_action('wp_ajax_nopriv_default_content_updater', 'default_content_updater_callback');

function default_content_updater_callback() {

    ob_start();

    $template_data = [];

    if($_POST['ERROR_CONTAINER'] && !empty($_POST['ERROR_CONTAINER']))
    {
        $template_data['ERRORS'] = false;

        $set_template_data = function($key, $value) use (&$template_data) {

            $template_data[$key] = $value;

        };
    }

    if($_POST['TEMPLATE_PART'] && !empty($_POST['TEMPLATE_PART'])){

        if(!empty($template_data))
            $GLOBALS['set_template_data'] = $set_template_data;

        get_template_part($_POST['TEMPLATE_PART'],null,$_POST);

        $content = ob_get_clean();

        if (isset($template_data['ERRORS']) && $template_data['ERRORS'] === true) {

            echo json_encode([
                'ERRORS' => $template_data['ERRORS'],
                'HTML_CONTENT' => $content,
                'ERROR_CONTAINER' => $_POST['ERROR_CONTAINER']
            ]);

        } else {

            echo json_encode([
                'ERRORS' => false,
                'HTML_CONTENT' => $content,
                'ERROR_CONTAINER' => $_POST['ERROR_CONTAINER']
            ]);

        }

        if(!empty($template_data))
            unset($GLOBALS['set_template_data']);

    }else{

        echo json_encode([
            'ERRORS' => false,
            'HTML_CONTENT' => $_POST['action'],
            'ERROR_CONTAINER' => $_POST['ERROR_CONTAINER']
        ]);

    }
    
    wp_die();
}