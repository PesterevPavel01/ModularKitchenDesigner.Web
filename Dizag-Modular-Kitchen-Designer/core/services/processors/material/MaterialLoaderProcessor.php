<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    global $ApiUrl;

    Class MaterialLoaderProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($ApiUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $ApiUrl . "v2/MaterialItem/GetByKitchenTypeCode/";
        }

        public function GetByKitchenTypeCode($KitchenTypeCode)
        {
            $this->Result = $this->HttpConnector->GetByUrl( $this->Url . urlencode($KitchenTypeCode));
            return $this->Result;
        }
    }
?>