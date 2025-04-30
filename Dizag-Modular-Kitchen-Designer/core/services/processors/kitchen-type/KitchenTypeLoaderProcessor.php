<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class KitchenTypeLoaderProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($ApiUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $ApiUrl . "v1/KitchenType/";
        }

        public function GetByPriceSegmentTitle($priceSegmentTitle)
        {
            $this->Result = $this->HttpConnector->GetByUrl( $this->Url ."GetByPriceSegment/". urlencode($priceSegmentTitle));
            return $this->Result;
        }

        public function GetByPriceSegmentCode($priceSegmentCode)
        {
            $this->Result = $this->HttpConnector->GetByUrl( $this->Url ."GetByPriceSegmentCode/". urlencode($priceSegmentCode));
            return $this->Result;
        }
    }
?>
            