<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class WorkflowProvider
    {
        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($approvalServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $approvalServiceUrl . "v2/orders/";
        }

        public function CheckPermission($workflowCode, $login)
        {
            $url = $this->Url . "permission";

            $body = [
                'workflowCode' => $workflowCode,
                'userName' => $login
            ];

            $this->Result = $this->HttpConnector->wp_post($url, $body);
            
            return $this->Result;
        }

        public function Approve($workflowCode, $login)
        {
            $url = $this->Url . "approve";

            $body = [
                'workflowCode' => $workflowCode,
                'userName' => $login
            ];

            $this->Result = $this->HttpConnector->wp_post($url, $body);
            
            return $this->Result;
        }
    }
?>