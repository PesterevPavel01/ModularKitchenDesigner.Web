<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class PermissionProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($clientServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $clientServiceUrl . "v2/user/";
        }

        public function Process($userName)
        {
            $Result = new BaseResult();
            $this->Result = $this->HttpConnector->GetMessageByUrl( $this->Url . urlencode($userName) ."/roles");
            return $this->Result;
        }
    }
?>