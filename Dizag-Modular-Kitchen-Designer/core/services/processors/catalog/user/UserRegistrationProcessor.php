<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/HttpConnector.php';

Class UserRegistrationProcessor
{
    public $Url;
    public $HttpConnector;
    public $Result;

    public function __construct($clientServiceUrl){
        $this->HttpConnector = new HttpConnector();
        $this->Result = new BaseResult();
        $this->Url = $clientServiceUrl . "v2/user/";
    }

    public function Process(string $userName, string $password, string $role)
    {        
        $customerResult = new BaseResult();

        $customerResult = $this->HttpConnector->GetByUrl( $this->Url . urlencode($userName) ."/external-id");

        if(!$customerResult->isSuccess())
        {
            if($customerResult->ErrorMessage === "User not found!")
            {
                $body = [
                    "userName" => $userName,
                    "password" => $password,
                    "role" => $role
                ];

                $this->Result=$this->HttpConnector->GetDataByUrl($this->Url . 'create', $body);
            }
        }

        return $this->Result;
    }
}
?>