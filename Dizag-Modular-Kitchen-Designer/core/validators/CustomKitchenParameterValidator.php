<?php
    require_once get_template_directory() . '/core/Result.php';
    
    Class CustomKitchenParameterValidator
    {
        /*
        ( 
            [PARAMETER] => 
                Array 
                ( 
                    [KITCHEN_TYPE_CODE] => 00080200313 
                    [SECTIONS] => Array 
                    ( 
                        [0] => Array 
                        ( 
                            [moduleCode] => 00080202266 
                            [quantity] => 2 
                        ) 
                        [1] => Array 
                        ( 
                            [moduleCode] => 00080202229 
                            [quantity] => 2 
                        ) 
                    ) 
                    [MATERIALS] => Array 
                    ( 
                        [TOP] => Array
                        (
                            [TITLE] => 'ВЕРХНИЕ'
                            [VALUE] =>Array 
                            ( 
                                [TITLE] => МДФ Мокко металлик 
                                [CODE] => c5a0874e-d722-4e90-bdc4-938fcdace3bc 
                            ) 
                        )
                        [BOTTOM] => 
                            [TITLE] => 'НИЖНИЕ'
                            [VALUE] =>Array 
                            ( 
                                [TITLE] => ЛДСП Дуб кендал натуральный 
                                [CODE] => 50061b68-1bcf-45ac-b0b4-0ffe77c5ef2f 
                            )
                    ) 
                )   
        ) */
        public $Result;

        public function __construct(){
            $this->Result = new BaseResult();
        }

        public function Validate($parameter)
        {

            if(!isset($parameter['KITCHEN_TYPE_CODE']))
            {
                $this->Result->ErrorMessage = 'Не найден тип кухни';
                return $this->Result;
            }
            
            if($parameter['SECTIONS'] === null || empty($parameter['SECTIONS']))
            {
                $this->Result->ErrorMessage = 'Необходимо указать количество хотя бы у одного модуля';
                return $this->Result;
            }

            if($parameter['MATERIALS'] === null || empty($parameter['MATERIALS']))
            {
                $this->Result->ErrorMessage = 'Необходимо указать количество хотя бы у одного модуля';
                return $this->Result;
            }

            if($parameter['MATERIALS']['TOP']['VALUE']['TITLE'] === '' || !isset($parameter['MATERIALS']['TOP']['VALUE']['TITLE']) || empty($parameter['MATERIALS']['TOP']['VALUE']))
            {
                $this->Result->ErrorMessage = 'Необходимо указать материал верхних модулей';
                return $this->Result;
            }

            if($parameter['MATERIALS']['TOP']['VALUE']['CODE'] === '' || !isset($parameter['MATERIALS']['TOP']['VALUE']['CODE']))
            {
                $this->Result->ErrorMessage = 'Необходимо указать материал верхних модулей';
                return $this->Result;
            }

            if($parameter['MATERIALS']['BOTTOM']['VALUE']['TITLE'] === '' || !isset($parameter['MATERIALS']['BOTTOM']['VALUE']['TITLE']) || empty($parameter['MATERIALS']['BOTTOM']['VALUE']))
            {
                $this->Result->ErrorMessage = 'Необходимо указать материал нижних модулей';
                return $this->Result;
            }

            if($parameter['MATERIALS']['BOTTOM']['VALUE']['CODE'] === '' || !isset($parameter['MATERIALS']['BOTTOM']['VALUE']['CODE']))
            {
                $this->Result->ErrorMessage = 'Необходимо указать материал верхних модулей';
                return $this->Result;
            }

            return $this->Result;
        }
    }
?>