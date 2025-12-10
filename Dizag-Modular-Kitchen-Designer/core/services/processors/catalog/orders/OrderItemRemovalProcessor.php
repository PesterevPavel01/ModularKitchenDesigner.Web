<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class OrderItemRemovalProcessor
{
    public $Url;
    
    public $HttpConnector;

    public $Result;

    private $User;

    public function __construct($orderServiceUrl, $user){

        $this->HttpConnector = new HttpConnector();

        $this->Result = new BaseResult();

        $this->Url = $orderServiceUrl . "v3/orders/";

        $this->User = $user;
    }

    public function Process(string $orderCode, string $moduleCode)
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

        $url = $this->Url . $orderCode . "/remove/$moduleCode";

        $body = [
            "currentUser" =>  $this->User
        ];

        $this->Result=$this->HttpConnector->wp_delete($url, null, $body);
        
        return $this->Result;
    }
}
?>