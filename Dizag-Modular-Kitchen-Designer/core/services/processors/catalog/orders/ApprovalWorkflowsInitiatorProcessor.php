<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class ApprovalWorkflowsInitiatorProcessor
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($approvalServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $approvalServiceUrl . "v2/workflows/create";
        }

        public function Process($orderCode)
        {
            $url = $this->Url;

            $this->Result = $this->HttpConnector->wp_post($url, $orderCode);
            
            return $this->Result;
        }
    }
?>