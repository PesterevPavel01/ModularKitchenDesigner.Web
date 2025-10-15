<?php
// Безопасное подключение файлов
$core_dir = get_template_directory() . '/core/services/processors/catalog/user/';

require_once $core_dir . 'UserPasswordProcessor.php';
require_once $core_dir . 'AuthorizationProcessor.php';
require_once $core_dir . 'CustomerRemovalProcessor.php';

global $clientServiceUrl;

// Инициализация процессоров
$UserPasswordProcessor = new UserPasswordProcessor();
$password = $UserPasswordProcessor->Process();   

// Получение текущего пользователя
$current_user = wp_get_current_user();
if (!$current_user || !$current_user->exists()) {
    echo '<p class="error-message">Пользователь не авторизован</p>';
    return;
}

$login = sanitize_user($current_user->user_login);

// Авторизация
$AuthorizationProcessor = new AuthorizationProcessor($clientServiceUrl);
$tokenResult = $AuthorizationProcessor->Process($login, $password);

if (!$tokenResult->isSuccess()) {
    echo '<p class="error-message">' . esc_html($tokenResult->ErrorMessage) . '</p>';
    return;
}

// Проверка токена
if (empty($tokenResult->data) || !is_string($tokenResult->data)) {
    echo '<p class="error-message">Неверный токен авторизации</p>';
    return;
}

$token = sanitize_text_field($tokenResult->data);

// Проверка параметра CUSTOMER_LOGIN
$customer_login = isset($args["CUSTOMER_LOGIN"]) ? sanitize_user($args["CUSTOMER_LOGIN"]) : '';

if (empty($customer_login)) {
    echo '<p class="error-message">Параметр "CUSTOMER_LOGIN" не найден или пуст!</p>';
    return;
}

// Удаление клиента
$CustomerRemovalProcessor = new CustomerRemovalProcessor($clientServiceUrl);
$result = $CustomerRemovalProcessor->Process($customer_login, $token);

if (!$result->isSuccess()) {
    echo '<p class="error-message">' . esc_html($result->ErrorMessage) . '</p>';
    return;
}
?>

<p class="error-message black w-100 p-1">Выполнено!</p>