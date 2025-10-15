<?php
   
    Class UserPasswordProcessor
    {
        public $Result;

        public function __construct(){
        }

        public function Process()
        {
            $current_user = wp_get_current_user();

            $existing_encrypted_password = get_user_meta($current_user->ID, '_encrypted_app_password', true);
            
            if (empty($existing_encrypted_password)) {
                $app_password = wp_generate_password(12, true, true);
                // Шифруем пароль
                $encrypted_password = base64_encode($app_password);
                update_user_meta($current_user->ID, '_encrypted_app_password', $encrypted_password);
                update_user_meta($current_user->ID, '_app_password_generated', current_time('mysql'));
            }

            $encrypted = get_user_meta($current_user->ID, '_encrypted_app_password', true);
            $decrypted_password = base64_decode($encrypted);

            return $decrypted_password;
        }
    }
?>