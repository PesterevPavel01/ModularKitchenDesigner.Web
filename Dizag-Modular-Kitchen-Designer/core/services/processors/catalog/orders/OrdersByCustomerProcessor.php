<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class OrdersByCustomerProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($orderServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $orderServiceUrl . "v2/orders/by-customer";
        }

        public function Process($userName, $arParams)
        {
            $Result = new BaseResult();

            $url = $this->Url . "/" . urlencode($userName) . "/" . $arParams['PERIOD'] 
            . '?ascending=' . ($arParams['ASCENDING'] ? 'true' : 'false')
            . '&incompleteOnly=' . ($arParams['INCOMPLETE_ONLY'] ? 'true' : 'false')
            . '&customOnly=' . ($arParams['CUSTOM_ONLY'] ? 'true' : 'false');

            $this->Result = $this->HttpConnector->GetMessageByUrl($url);
            
            return $this->Result;
        }
    }
?>