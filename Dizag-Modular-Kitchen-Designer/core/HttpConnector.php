<?php
    require_once get_template_directory() . '/core/Result.php';
    
    Class HttpConnector
    {
        public function wp_patch($Url, $bodyData = [], $token = null)
        {
            $result = new BaseResult();
            
            // Подготавливаем заголовки
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'WordPress/' . get_bloginfo('version')
            ];
            
            // Добавляем Bearer token если передан и валиден
            if (!is_null($token) && is_string($token) && !empty(trim($token))) {
                $headers['Authorization'] = 'Bearer ' . sanitize_text_field($token);
            }
        
            $request_args = [
                'method' => 'PATCH', // Указываем метод PATCH
                'headers' => $headers,
                'body' => wp_json_encode($bodyData),
                'timeout' => 30,
                'redirection' => 5,
                'httpversion' => '1.1',
                'blocking' => true,
                'sslverify' => apply_filters('https_local_ssl_verify', false)
            ];
        
            $response = wp_remote_request($Url, $request_args); // Используем wp_remote_request для PATCH
            
            // Записываем время соединения
            $result->connectionTime = current_time('mysql');
        
            // Обработка ответа
            if (is_wp_error($response)) {

                $result->ErrorMessage = 'Network error: ' . $response->get_error_message();
                $result->ErrorCode = 500;
                $result->data = null;
                $result->ObjectName = 'HTTP_Request';

            } else {

                $response_code = wp_remote_retrieve_response_code($response);
                $response_body = wp_remote_retrieve_body($response);
                
                $result->ErrorMessage = ($response_code >= 200 && $response_code < 300) ? null : get_status_header_desc($response_code);
                $result->ErrorCode = $response_code;
                $result->ObjectName = 'API_Response';
                
                // Всегда декодируем body, если он не пустой
                if (!empty(trim($response_body))) {

                    //$result->data = $response_body;
                    $result->data = json_decode($response_body, true);

                } else {

                    $result->data = null;

                }

            }
        
            return $result;
        }


        public function wp_post($Url, $bodyData, $token = null)
        {
            $result = new BaseResult();
        
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => '*/*', 
                'User-Agent' => 'WordPress/' . get_bloginfo('version')
            ];
            
            // Добавляем Bearer token если передан и валиден
            if (!is_null($token) && is_string($token) && !empty(trim($token))) {
                $headers['Authorization'] = 'Bearer ' . sanitize_text_field($token);
            }
        
            if (is_string($bodyData)) {
                
                json_decode($bodyData);

                if (json_last_error() === JSON_ERROR_NONE) {
                    
                    $request_body = $bodyData;

                } else {

                    $request_body = '"' . $bodyData . '"';

                }

            } else {
                
                $request_body = wp_json_encode($bodyData);

            }
        
            $request_args = [
                'headers' => $headers,
                'body' => $request_body,
                'timeout' => 30,
                'redirection' => 5,
                'httpversion' => '1.1',
                'blocking' => true,
                'sslverify' => apply_filters('https_local_ssl_verify', false)
            ];
        
            $response = wp_remote_post($Url, $request_args);
            
            $result->connectionTime = current_time('mysql');
        
            // Обработка ответа
            if (is_wp_error($response)) {

                $result->ErrorMessage = 'Network error: ' . $response->get_error_message();
                $result->ErrorCode = 500;
                $result->data = null;
                $result->ObjectName = 'HTTP_Request';

            } else {

                $response_code = wp_remote_retrieve_response_code($response);
                $response_body = wp_remote_retrieve_body($response);
                
                $result->ErrorMessage = ($response_code >= 200 && $response_code < 300) ? null : get_status_header_desc($response_code);
                $result->ErrorCode = $response_code;
                $result->ObjectName = 'API_Response';
                
                // Всегда декодируем body, если он не пустой
                if (!empty(trim($response_body))) {

                    //$result->data = $response_body;
                    $result->data = json_decode($response_body, true);

                } else {

                    $result->data = null;

                }

            }
        
            return $result;
        }

        public function wp_delete($Url, $token = null)
        {
            $result = new BaseResult();
            
            // Подготавливаем заголовки
            $headers = [
                'Accept' => 'application/json',
                'User-Agent' => 'WordPress/' . get_bloginfo('version')
            ];
            
            // Добавляем Bearer token если передан и валиден
            if (!is_null($token) && is_string($token) && !empty(trim($token))) {
                $headers['Authorization'] = 'Bearer ' . sanitize_text_field($token);
            }
        
            $request_args = [
                'method' => 'DELETE', // Указываем метод DELETE
                'headers' => $headers,
                'timeout' => 30,
                'redirection' => 5,
                'httpversion' => '1.1',
                'blocking' => true,
                'sslverify' => apply_filters('https_local_ssl_verify', false)
            ];
        
            $response = wp_remote_request($Url, $request_args);
            
            // Записываем время соединения
            $result->connectionTime = current_time('mysql');
        
            // Обработка ответа
            if (is_wp_error($response)) {
                $result->ErrorMessage = 'Network error: ' . $response->get_error_message();
                $result->ErrorCode = 500;
                $result->data = null;
                $result->ObjectName = 'HTTP_Request';
            } else {
                $response_code = wp_remote_retrieve_response_code($response);
                $response_body = wp_remote_retrieve_body($response);
                
                $result->ErrorMessage = ($response_code >= 200 && $response_code < 300) ? null : get_status_header_desc($response_code);
                $result->ErrorCode = $response_code;
                $result->ObjectName = 'API_Response';
                
                // Всегда декодируем body, если он не пустой
                if (!empty(trim($response_body))) {
                    $result->data = json_decode($response_body, true);
                } else {
                    $result->data = null;
                }
            }
        
            return $result;
        }

        public function GetByUrl($Url, $bodyData = [])
        {
            // Инициализация cURL
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $Url);
            
            // Установите метод запроса GET
            curl_setopt($curl, CURLOPT_HTTPGET, true);

            // Установите максимальное время ожидания (например, 10 секунд)
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);

            // Если есть данные для передачи в запросе, добавьте их к URL
            if (!empty($bodyData)) {
                $Url .= '?' . http_build_query($bodyData);
                curl_setopt($curl, CURLOPT_URL, $Url);
            }

            $curl_result = curl_exec($curl);

            $result = new BaseResult();

            if (!$curl_result) {
                $result->ErrorMessage = curl_error($curl);
                $result->ErrorCode = curl_errno($curl);
                $result->ObjectName = "HttpConnector";
                curl_close($curl);
                return $result;
            }
            
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if($http_code >= 400)
            {
                $result->ErrorMessage = json_decode($curl_result, true);
                $result->ErrorCode = $http_code;
                $result->ObjectName = "HttpConnector";
                curl_close($curl);
                return $result;
            }
            
            curl_close($curl);
            
            // Декодируем JSON ответ
            $response = json_decode($curl_result, true);
            
            if (!$response['isSuccess']) {
                $result->ErrorMessage = $response['errorMessage'];
                $result->ErrorCode = $response['errorCode'];
                $result->ObjectName = $response['objectName'];
                return $result;
            }

            $result->data = $response['data'];
            $result->connectionTime = $response['connectionTime'];
            return $result;
        }

        public function GetMessageByUrl($Url, $bodyData = [])
        {
            $result = new BaseResult();
            
            // Добавляем параметры к URL если есть
            if (!empty($bodyData)) {
                $Url = add_query_arg($bodyData, $Url);
            }

            // Аргументы для запроса
            $args = [
                'timeout'     => 10,
                'redirection' => 5,
                'httpversion' => '1.0',
                'user-agent'  => 'WordPress/' . get_bloginfo('version'),
                'blocking'    => true,
                'headers'     => [],
                'cookies'     => [],
                'body'        => null,
                'compress'    => false,
                'decompress'  => true,
                'sslverify'   => true,
            ];

            // Выполняем GET запрос
            $response = wp_remote_get($Url, $args);

            // Проверяем на ошибки
            if (is_wp_error($response)) {
                $result->ErrorMessage = $response->get_error_message();
                $result->ErrorCode = $response->get_error_code();
                $result->ObjectName = "HttpConnector";
                return $result;
            }

            // Получаем HTTP код
            $http_code = wp_remote_retrieve_response_code($response);
            
            if ($http_code >= 400) {
                $result->ErrorMessage = wp_remote_retrieve_body($response);
                $result->ErrorCode = $http_code;
                $result->ObjectName = "HttpConnector";
                return $result;
            }

            // Получаем тело ответа
            $body = wp_remote_retrieve_body($response);
            
            // Декодируем JSON
            $response_data = json_decode($body, true);

            $result->data = $response_data;
            return $result;
        }

        public function GetDataByUrl($Url, $bodyData)
        {
            $result = new BaseResult();

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $Url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                          // Установите максимальное время ожидания (например, 10 секунд)
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                
            $headers = array(
              "Accept: application/json",
              "Content-Type: application/json",
            );
          
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($bodyData, JSON_UNESCAPED_UNICODE));
            
            try
            {    
                $curl_result = curl_exec($curl);
                
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                $result = new BaseResult();

                if (!$curl_result || $http_code!=200) {
                    $result->ErrorMessage = "HTTP статус код: $http_code";
                    $result->ErrorCode = $http_code;
                    $result->ObjectName = "HttpConnector";
                    $result->data=$curl_result;
                    return $result;
                }

                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if($http_code >= 400)
                {
                    $result->ErrorMessage = json_decode($curl_result, true);
                    $result->ErrorCode = $http_code;
                    $result->ObjectName = "HttpConnector";
                    return $result;
                }
            }
            catch (Exception $e) 
            {
                $result->ErrorMessage = "Exception: " . $e->getMessage(); // Получить сообщение об ошибке
                $result->ErrorCode = "Exception"; // Можно установить код ошибки как "Exception"
                $result->ObjectName = "HttpConnector";
                $result->data=$curl_result;
                return $result; 
            }
            finally 
            {
                curl_close($curl);
            }
            
            $response=json_decode($curl_result,true);

            if(!$response['isSuccess'])
            {
                $result->ErrorMessage = $response['errorMessage'];
                $result->ErrorCode = $response['errorCode'];
                $result->ObjectName =  $response['objectName'];
                return $result;
            }

            $result->data=$response['data'];
            $result->connectionTime=$response['connectionTime'];
            return $result;
        }
        
        public function uploadImage($imagePath, $uploadUrl) {

            // Проверьте, существует ли файл
            if (!file_exists($imagePath)) {
                die("Файл не существует");
            }
        
            // Инициализируем cURL
            $curl = curl_init();
        
            // Создаём файл-загрузку с помощью CURLFile
            $cfile = new CURLFile($imagePath);
        
            // Определяем массив с данными для отправки
            $data = array(
                'file' => $cfile
            );
        
            // Настройки cURL
            curl_setopt($curl, CURLOPT_URL, $uploadUrl);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        
            // Выполняем запрос
            $response = curl_exec($curl);
        
            // Проверяем на ошибки
            if (curl_errno($curl)) {
                echo 'Ошибка: ' . curl_error($curl);
            } else {
                // Выводим ответ от сервера
                echo 'Ответ от сервера: ' . $response;
            }
        
            // Закрываем cURL
            curl_close($curl);
            
        }
    }
/*global $exchangeServiceUrl;

$response = wp_remote_post($exchangeServiceUrl . 'v1/autorize/autenticate', array(
    'timeout' => 30,
    'headers' => array(
        'Content-Type' => 'application/json',
        'accept' => 'application/json'
    ),
    'body' => json_encode(array(
        'userName' => 'Administrator',
        'password' => 'Qwerty1234!'
    ))
));

if (!is_wp_error($response)) {
    $body = wp_remote_retrieve_body($response);
    $token = json_decode($body);
    // Обработка ответа
}*/

?>