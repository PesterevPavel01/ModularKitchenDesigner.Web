<?php
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once get_template_directory() . '/core/services/processors/catalog/components/ComponentProvider.php';
require_once get_template_directory() . '/core/Result.php';

global $componentServiceUrl;

$nonce = $args['nonce'] ?? '';

$componentCode = $args['COMPONENT_CODE'] ?? '';

$ComponentProvider = new ComponentProvider($componentServiceUrl);

$ComponentResult = new BaseResult();

if($componentCode === ''){


    $order_page = get_page_by_path('order');

    $order_page_id = $order_page->ID;

    $millingCode = get_field('milling', $order_page_id);

    $ComponentResult = $ComponentProvider->CreateCustomMilling($millingCode, "Фрезеровка");

    if(!$ComponentResult->isSuccess())
    {?>
        <p><?=$ComponentResult->ErrorMessage?></p>
        <?return;
    }

    $componentCode = $ComponentResult->data[0]["componentCode"];
}

$current_user = wp_get_current_user();

$login = $current_user->user_login;

// Проверяем nonce
if (!wp_verify_nonce($nonce, 'blueprint_upload_nonce')) {
    echo '<div class="alert alert-danger">Ошибка безопасности</div>';
    return;
}

$uploaded_files_info = [];


if (!empty($_FILES['BLUEPRINTS']) && !empty($_FILES['BLUEPRINTS']['name'][0])) {
    
    // Получаем базовый путь загрузки WordPress
    $upload_dir = wp_upload_dir();
    $component_dir = $upload_dir['basedir'] . '/' . $login . '/' . $componentCode;
    $component_url = $upload_dir['baseurl'] . '/' . $login . '/' . $componentCode;
    
    // Создаем папку если ее нет
    if (!file_exists($component_dir)) {

        wp_mkdir_p($component_dir);

    } else {
        
        $files = glob($component_dir . '/*');

        foreach ($files as $file) {

            if (is_file($file))
                unlink($file);
        }
    }
    
    foreach ($_FILES['BLUEPRINTS']['name'] as $key => $filename) {
        
        if (empty($filename) || $_FILES['BLUEPRINTS']['error'][$key] !== UPLOAD_ERR_OK) {
            return;
        }
        
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file_name_without_extension = pathinfo($filename, PATHINFO_FILENAME);
        $new_filename = sanitize_file_name($file_name_without_extension . '.' . $file_extension);
        
        // Полный путь для сохранения в нужной папке
        $destination_path = $component_dir . '/' . $new_filename;
        
        // Перемещаем файл в нужную папку
        if (move_uploaded_file($_FILES['BLUEPRINTS']['tmp_name'][$key], $destination_path)) {
                        
            // Формируем URL файла
            $file_url = $component_url . '/' . $new_filename;
            
            $uploaded_files_info[] = [
                'name' => $filename,
                'saved_name' => $new_filename,
                'url' => $file_url,
                'type' => $_FILES['BLUEPRINTS']['type'][$key],
                'size' => $_FILES['BLUEPRINTS']['size'][$key],
                'upload_date' => current_time('mysql'),
                'path' => $destination_path
            ];
            
        } else {
            echo '<div class="alert alert-danger">Ошибка перемещения файла "' . esc_html($filename) . '" в папку ' . esc_html($componentCode) . '</div>';
            return;
        }
    }

    if(empty($uploaded_files_info))
    {
        echo '<div class="alert alert-warning">Файлы не были получены</div>';
        return;
    }

    $textParameters = [];

    $textParameters[] = [
        "type" => "CUSTOM COMPONENT",
        "typeCode" => "0000000CSTM",
        "value" => "CUSTOM COMPONENT"
    ];
    
    foreach ($uploaded_files_info as $item) {

        $textParameters[] = [
            "type" => "Чертеж",
            "typeCode" => "000000BPRNT",
            "value" => $item['url']
        ];

    }
    
    $body = [
        "componentCode" => $componentCode,
        "textParameters" => $textParameters
    ];

    $ComponentResult = $ComponentProvider->ReplaceTextParameters($body);

    if(!$ComponentResult->isSuccess())
    {?>
        <p><?=$ComponentResult->ErrorMessage?></p>
        <?return;
    }

    get_template_part("parts/catalog/orders/facade-configurator-blueprints/template",null,
        [
            'COMPONENT' =>  $ComponentResult->data
        ]);
    
} else {

    ?><div class="alert alert-danger text-center">Ошибка! Вы не можете удалить все чертежи!</div><?
    return;

}
?>