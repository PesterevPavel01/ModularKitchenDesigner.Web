<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class ModuleLoaderProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($ApiUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $ApiUrl . "v4/Module/";
        }

        public function Process($moduleTypeTitle)
        {
            $this->Result = $this->HttpConnector->GetByUrl( $this->Url ."GetByType/". urlencode($moduleTypeTitle));
            return $this->Result;
        }
    }
?>