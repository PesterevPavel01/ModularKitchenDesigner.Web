<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class UnassignedUserProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($clientServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $clientServiceUrl . "v2/user/unassigned";
        }

        public function Process()
        {
            $Result = new BaseResult();
            $Result = $this->HttpConnector->GetMessageByUrl($this->Url);

            if(!$Result->IsSuccess())
                return $Result;

            $this->Result->data = $this->get_filtered_customers($Result->data);

            return $this->Result;
        }

        function get_filtered_customers($users_data) {
            
            $result = [];
            
            foreach ($users_data as $user_item) {
                // Валидация входных данных
                $username = sanitize_user($user_item['userName'] ?? '');
                
                if (empty($username)) {
                    continue;
                }
                
                // Поиск пользователя в WordPress
                $wp_user = get_user_by('login', $username);
                
                if (!$wp_user) {
                    continue;
                }
                
                // Проверка роли customer
                if (!in_array('customer', (array)$wp_user->roles)) {
                    continue;
                }
                
                // Формирование безопасного массива
                $result[] = [
                    'Name' => esc_html($wp_user->display_name),
                    'Login' => esc_html($wp_user->user_login),
                    'Registered' => $wp_user->user_registered,
                    'Email' => esc_html($wp_user->user_email),
                    'ID' => (int)$wp_user->ID
                ];
            }
            
            // Сортировка по дате регистрации (DESC - новые первыми)
            usort($result, function($a, $b) {
                $time_a = strtotime($a['Registered']);
                $time_b = strtotime($b['Registered']);
                return $time_b - $time_a; // Для ASC поменяйте местами
            });
            
            return $result;
        }
    }
?>