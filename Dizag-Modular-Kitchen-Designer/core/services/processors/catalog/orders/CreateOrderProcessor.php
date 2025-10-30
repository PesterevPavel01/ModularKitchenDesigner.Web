<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class CreateOrderProcessor
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($orderServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $orderServiceUrl . "v2/orders/create";
        }

        public function Process($createOrderDto)
        {
            $this->Result = $this->HttpConnector->wp_post($this->Url, $createOrderDto);
            
            return $this->Result;
        }
    }
?>