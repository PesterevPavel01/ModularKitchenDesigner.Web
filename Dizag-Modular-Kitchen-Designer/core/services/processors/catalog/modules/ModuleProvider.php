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

        public function Update($args)
        {
            $url = $this->Url . "/update";
            
            $this->Validate($args);
            
            if(!$this->Result->isSuccess())
                return $this->Result;
            
            if(!isset($args["MODULE_CODE"]) || trim($args["MODULE_CODE"]) === ""){

                $this->Result->ErrorMessage = "Не указана код модуля!";

                return $this->Result; 
            }
            
            $moduleCode = sanitize_text_field(trim($args["MODULE_CODE"]));

            $this->Result->data['moduleCode'] = $moduleCode;

            return $this->HttpConnector->wp_patch($url, $this->Result->data);
        }

        public function Create($args)
        {
            $url = $this->Url . "/create";

            $this->Validate($args);
            
            if(!$this->Result->isSuccess())
                return $this->Result;

            if(!isset($args["MODULE_TYPE_CODE"]) || trim($args["MODULE_TYPE_CODE"]) === ""){

                $this->Result->ErrorMessage = 'Не указана код типа модуля!';

                return $this->Result;
            }
            
            $moduleTypeCode = sanitize_text_field(trim($args["MODULE_TYPE_CODE"]));

            $this->Result->data['moduleTypeCode'] = $moduleTypeCode;

            if(!isset($args["MODULE_TYPE"]) || trim($args["MODULE_TYPE"]) === ""){

                $this->Result->ErrorMessage = 'Не указана тип модуля!';

                return $this->Result; 
            }        

            $moduleType = sanitize_text_field(trim($args["MODULE_TYPE"]));

            $this->Result->data['moduleType'] = $moduleType;

            return $this->HttpConnector->wp_post($url, $this->Result->data);
        }

        private function Validate($args)
        {

            $components = [];

            if(isset($args["HINGE"]) && trim($args["HINGE"]) !== "" && trim($args["HINGE"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["HINGE"])),
                ];
                
            }

            if(isset($args["MEMBRANE"]) && trim($args["MEMBRANE"]) !== "" && trim($args["MEMBRANE"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["MEMBRANE"])),
                ];
                
            }else{

               $this->Result->ErrorMessage = "Не указана пленка!";

                return $this->Result; 

            }

            if(isset($args["BOARD"]) && trim($args["BOARD"]) !== "" && trim($args["BOARD"]) !== "0"){

                $components[]= [
                    "componentCode" => sanitize_text_field(trim($args["BOARD"])),
                ];
                
            }else{

                $this->Result->ErrorMessage = "Не указана плита!";

                return $this->Result;
                
            }

            if(isset($args["CORNER"]) && trim($args["CORNER"]) !== "" && trim($args["CORNER"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["CORNER"])),
                ];

            }

            if(isset($args["CORNER_TOP"]) && trim($args["CORNER_TOP"]) !== "" && trim($args["CORNER_TOP"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["CORNER_TOP"])),
                ];
                
            }

            if(isset($args["CORNER_BOTTOM"]) && trim($args["CORNER_BOTTOM"]) !== "" && trim($args["CORNER_BOTTOM"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["CORNER_BOTTOM"])),
                ];
                
            }

            if(isset($args["CORNER_LEFT"]) && trim($args["CORNER_LEFT"]) !== "" && trim($args["CORNER_LEFT"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["CORNER_LEFT"])),
                ];
                
            }

            if(isset($args["CORNER_RIGHT"]) && trim($args["CORNER_RIGHT"]) !== "" && trim($args["CORNER_RIGHT"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["CORNER_RIGHT"])),
                ];
                
            }

            if(isset($args["MILLING"]) && trim($args["MILLING"]) !== ""  && trim($args["MILLING"]) !== "0"){

                $components[] = [
                    "componentCode" => sanitize_text_field(trim($args["MILLING"])),
                ];
                
            }else{

                $this->Result->ErrorMessage = "Не указана фрезеровка!";

                return $this->Result;
                
            }
            
            $numericParameters = [];

            if(isset($args["WIDTH"]) && trim($args["WIDTH"]) !== ""){

                $numericParameters[] = [
                    "type" => "Ширина",
                    "typeCode" => "0000000WDHT",
                    "value" =>  sanitize_text_field(trim($args["WIDTH"]))
                ];
                
            }else{

                $this->Result->ErrorMessage = "Не указана ширина!";

                return $this->Result;
                
            }

            if(isset($args["LENGTH"]) && trim($args["LENGTH"]) !== ""){

                $numericParameters[] = [
                    "type" => "Высота",
                    "typeCode" => "000000LNGTH",
                    "value" =>  sanitize_text_field(trim($args["LENGTH"]))
                ];
                
            }else{

                $this->Result->ErrorMessage = "Не указана высота!";

                return $this->Result;
                
            }

            $body = [
                "components" => $components,
                "numericParameters" => $numericParameters,
                "textParameters" => []
            ];

            $this->Result->data = $body;
        }
    }
?>