<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class OrderEventQueryHandler
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($orderServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $orderServiceUrl . "v2/events";
        }

        public function Handle($userName, $arParams)
        {
            $Result = new BaseResult();

            $url = $this->Url 
                . "/" . urlencode($userName) 
                . '/' . ($arParams['PAGE_INDEX'] ? sanitize_text_field($arParams['PAGE_INDEX']) : '0')
                . "/". sanitize_text_field($arParams['PAGE_SIZE']);

            $this->Result = $this->HttpConnector->GetMessageByUrl($url);

            return $this->Result;
        }
    }
?>