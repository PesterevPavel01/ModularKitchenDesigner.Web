<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';
    
    Class PriceSegmentLoaderProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($ApiUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $ApiUrl . "v5/PriceSegment";
        }

        public function Process()
        {
            $this->Result = $this->HttpConnector->GetByUrl($this->Url);
            return $this->Result;
        }
    }
?>