<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class ComponentProvider
    {
        public $Url;
        public $HttpConnector;
        public $Result;
        private $User;

        public function __construct($componentServiceUrl, $user){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $componentServiceUrl . "v3/components";
            $this->User = $user;
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
            
            $numericParameters[] = [
                "type" => "Минимальная толщина",
                "typeCode" => "00000MNHGHT",
                "value" => 22
            ];

            $body = [
                "componentTypeCode" => $typeCode,
                "componentTypeTitle" => $typeTitle,
                "componentTitle" => "Нестандартная",
                "numericParameters"=> $numericParameters,
                "currentUser" =>  $this->User
            ];

            $url = $this->Url . $orderItemCode . "/create";

            $this->Result=$this->HttpConnector->wp_post($url, $body);
            
            return $this->Result;

        }

        public function CreateCustomHinge($typeCode, $typeTitle){

            $body = [
                "componentTypeCode" => $typeCode,
                "componentTypeTitle" => $typeTitle,
                "componentTitle" => "Нестандартная",
                "currentUser" =>  $this->User
            ];

            $url = $this->Url . $orderItemCode . "/create";

            $this->Result=$this->HttpConnector->wp_post($url, $body);
            
            return $this->Result;

        }
    }
?>