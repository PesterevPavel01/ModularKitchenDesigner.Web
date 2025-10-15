<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class AuthorizationProcessor
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($clientServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $clientServiceUrl . "v1/authorize/authenticate";
    }

    public function Process(string $userName, string $password)
    {        
        $body = [
            "userName" => $userName,
            "password" => $password,
        ];

        $this->Result=$this->HttpConnector->wp_post($this->Url, $body);
        
        return $this->Result;
    }
}
?>