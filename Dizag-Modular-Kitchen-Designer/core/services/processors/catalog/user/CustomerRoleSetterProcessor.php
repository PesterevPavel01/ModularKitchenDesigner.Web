<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class CustomerRoleSetterProcessor
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($clientServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $clientServiceUrl . "v2/user/set-customer-role";
    }

    public function Process(string $userName, string $externalId, string $token)
    {     
        //return $userName;
        
        $body = [
            "userName" => $userName,
            "externalId" => $externalId
        ];

        $this->Result=$this->HttpConnector->wp_post($this->Url, $body, $token);
        
        return $this->Result;
    }
}
?>