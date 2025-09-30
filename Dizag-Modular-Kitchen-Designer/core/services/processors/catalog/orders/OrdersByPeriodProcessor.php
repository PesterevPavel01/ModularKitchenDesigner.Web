<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class OrdersByPeriodProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($orderServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $orderServiceUrl . "v2/orders/by-period";
        }

        public function Process($arParams)
        {
            $Result = new BaseResult();

            $url = $this->Url . "/" . $arParams['PERIOD'] 
            . '?ascending=' . ($arParams['ASCENDING'] ? 'true' : 'false')
            . '&incompleteOnly=' . ($arParams['INCOMPLETE_ONLY'] ? 'true' : 'false')
            . '&customOnly=' . ($arParams['CUSTOM_ONLY'] ? 'true' : 'false');

            $this->Result = $this->HttpConnector->GetMessageByUrl($url);
            
            return $this->Result;
        }
    }
?>