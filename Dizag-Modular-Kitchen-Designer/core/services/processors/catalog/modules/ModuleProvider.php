<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class ModuleProvider
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($moduleServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $moduleServiceUrl . "v2/modules";
        }

        public function GetModuleByCode($code)
        {
            $url = $this->Url . "/by-code/" . urlencode($code);

            $this->Result = $this->HttpConnector->GetMessageByUrl($url);
            
            return $this->Result;
        }
        
        public function AddComponent($moduleCode, $componentCode)
        {
            $url = $this->Url . "/add-component";

            $body = [
                "moduleCode" => $moduleCode,
                "componentCode" => $componentCode
            ];

            $this->Result = $this->HttpConnector->wp_post($url);
            
            return $this->Result;
        }
    }
?>