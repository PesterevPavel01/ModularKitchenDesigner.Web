<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class OrderRemovalProcessor
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($orderServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $orderServiceUrl . "v2/orders/";
    }

    public function Process(string $orderCode)
    {     
       
        $url = $this->Url . $orderCode . "/disable";

        $this->Result=$this->HttpConnector->wp_patch($url, []);
        
        return $this->Result;
    }
}
?>