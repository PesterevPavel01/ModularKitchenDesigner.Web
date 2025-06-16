<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class KitchenCreatorProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($ApiUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $ApiUrl . "v2/Kitchen/CreateMultiple";
        }

        public function Process($body)
        {
            $Date=new DateTime();

            try
            {
                $this->Result=$this->HttpConnector->GetDataByUrl($this->Url,$body);
            }
            catch (Exception $e)
            {
                $this->Result->ErrorMessage = $e->getMessage();
                $this->Result->ObjectName = "KitchenCreatorProcessor";
            }

            return  $this->Result;
        }
    }
?>