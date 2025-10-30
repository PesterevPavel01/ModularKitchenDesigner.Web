<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class OrderApprovalWorkflowLoaderProcessor
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($approvalServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $approvalServiceUrl . "v2/orders";
        }

        public function Process($orderCode)
        {
            $url = $this->Url . "/" . urlencode($orderCode);

            $this->Result = $this->HttpConnector->GetMessageByUrl($url);
            
            return $this->Result;
        }
    }
?>