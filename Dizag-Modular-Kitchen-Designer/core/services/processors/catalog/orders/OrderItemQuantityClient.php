<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class OrderItemQuantityClient
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($orderServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $orderServiceUrl . "v3/orders";
    }

    public function Execute(string $orderCode, string $moduleCode, int $quantity)
    {     
        if($quantity < 1)
        {
            $this->Result->ErrorMessage = "Quantity cannot be less than or equal to zero";
            return $this->Result;
        }

        $url = $this->Url . $orderItemCode . "/set-quantity";

        $body = [
            "orderCode" => $orderCode,
            "moduleCode" => $moduleCode,
            "quantity" => $quantity
        ];

        $this->Result=$this->HttpConnector->wp_patch($url,  $body);
        
        return $this->Result;
    }
}
?>