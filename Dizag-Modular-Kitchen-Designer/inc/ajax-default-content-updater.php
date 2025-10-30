<?php 

add_action('wp_ajax_default_content_updater', 'default_content_updater_callback');
add_action('wp_ajax_nopriv_default_content_updater', 'default_content_updater_callback');

function default_content_updater_callback() {
   
    ob_start();

    if($_POST['TEMPLATE_PART'] && ! empty($_POST['TEMPLATE_PART'])){

        get_template_part($_POST['TEMPLATE_PART'],null,$_POST);

        $content = ob_get_clean();

    }else{

        $content = $_POST['action'];

    }

    echo $content;
    
    wp_die();
}