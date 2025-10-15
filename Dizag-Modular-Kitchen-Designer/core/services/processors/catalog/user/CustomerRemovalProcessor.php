<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class CustomerRemovalProcessor
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($clientServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $clientServiceUrl . "v2/user/";
    }

    public function Process(string $userName, string $token)
    {     
        //return $userName;
        $url = $this->Url . $userName . "/disable";

        $this->Result=$this->HttpConnector->wp_patch($url, [], $token);
        
        return $this->Result;
    }
}
?>