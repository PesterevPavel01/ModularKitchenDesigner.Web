<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class OrderRemovalProcessor
{
    public $Url;

    public $HttpConnector;

    public $Result;

    private $User;

    public function __construct($orderServiceUrl, $user){

        $this->HttpConnector = new HttpConnector();

        $this->Result = new BaseResult();

        $this->Url = $orderServiceUrl . "v2/orders/";

        $this->User = $user;
    }

    public function Process(string $orderCode)
    {     
       
        $url = $this->Url . $orderCode . "/disable";

        $body = [
            "currentUser" =>  $this->User
        ];

        $this->Result=$this->HttpConnector->wp_patch($url, $body);
        
        return $this->Result;
    }
}
?>