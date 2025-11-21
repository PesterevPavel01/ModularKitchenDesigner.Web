<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class AddNewMessage
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($orderServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $orderServiceUrl . "v2/orders/add-message";
    }

    public function Execute(string $orderCode, string $moduleCode, string $sender, string $message )
    {     
        if(!$orderCode || trim($orderCode) === "")
        {
            $this->Result->ErrorMessage = "Не указан код заказа!";

            return $this->Result;
        }

        if(!$moduleCode || trim($moduleCode) === "")
        {
            $this->Result->ErrorMessage = "Не указан код модуля!";

            return $this->Result;
        }

        if(!$sender || trim($sender) === "")
        {
            $this->Result->ErrorMessage = "Не указан логин!";

            return $this->Result;
        }

        if(!$message || trim($message) === "")
        {
            $this->Result->ErrorMessage = "Текст комментария не найден!";

            return $this->Result;
        }

        $url = $this->Url;
        
        $body = [
            "orderCode" => trim($orderCode),
            "moduleCode" => trim($moduleCode),
            "text" => trim($message),
            "senderName" => trim($sender),
        ];

        $this->Result = $this->HttpConnector->wp_patch($url, $body);
        
        return $this->Result;
    }
}
?>