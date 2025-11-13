<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class OrderItemRemovalProcessor
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($orderServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $orderServiceUrl . "v3/orders/";
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

        $this->Result=$this->HttpConnector->wp_delete($url);
        
        return $this->Result;
    }
}
?>