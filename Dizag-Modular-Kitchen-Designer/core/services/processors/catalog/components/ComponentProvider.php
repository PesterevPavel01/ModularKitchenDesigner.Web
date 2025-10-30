<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class ComponentProvider
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($componentServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $componentServiceUrl . "v3/components";
        }

        public function GetComponentsByType($type)
        {
            $url = $this->Url . "/by-type/" . urlencode($type);

            $this->Result = $this->HttpConnector->GetMessageByUrl($url);

            return $this->Result;
        }

        public function ReplaceTextParameters($body){
            
            $url = $this->Url . $orderItemCode . "/text-parameter-replace";

            $this->Result=$this->HttpConnector->wp_patch($url, $body);
            
            return $this->Result;

        }

        public function CreateCustomMilling($typeCode, $typeTitle){
            
            $textParameters[] = [
                "type" => "Минимальная толщина",
                "typeCode" => "00000MNHGHT",
                "value" => 22
            ];

            $body = [
                "componentTypeCode" => $typeCode,
                "componentTypeTitle" => $typeTitle,
                "componentTitle" => "Нестандартная",
                "numericParameters"=> $textParameters
            ];

            $url = $this->Url . $orderItemCode . "/create";

            $this->Result=$this->HttpConnector->wp_post($url, $body);
            
            return $this->Result;

        }
    }
?>