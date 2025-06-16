<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';
    
    Class CustomKitchenProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($ApiUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $ApiUrl . "v1/KustomKitchen/";
        }

        public function GetByCode($kitchenCode)
        {
            $this->Result = $this->HttpConnector->GetByUrl( $this->Url ."GetByCode/". urlencode($kitchenCode));
            return $this->Result;
        }
    }
?>