<?php
    require_once get_template_directory() . '/core/Result.php';
    Class HttpConnector
    {
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
        /*
        public function GetByUrl($Url, $bodyData)
        {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $Url);
            // Установите максимальное время ожидания (например, 10 секунд)
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);

            $curl_result = curl_exec($curl);

            $result = new BaseResult();

            if (!$curl_result) {
                $result->ErrorMessage = curl_error($curl);
                $result->ErrorCode = curl_errno($curl);
                $result->ObjectName = "HttpConnector";
                curl_close($curl);
                return $result;
            }

            curl_close($curl);
    
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
        */
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

?>