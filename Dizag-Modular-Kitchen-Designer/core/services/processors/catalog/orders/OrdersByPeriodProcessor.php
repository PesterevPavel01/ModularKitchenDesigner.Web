<?php
    require_once get_template_directory() . '/core/Result.php';
    require_once get_template_directory() . '/core/HttpConnector.php';

    Class OrdersByPeriodProcessor
    {

        public $Url;
        public $HttpConnector;
        public $Result;

        public function __construct($orderServiceUrl){
            $this->HttpConnector = new HttpConnector();
            $this->Result = new BaseResult();
            $this->Url = $orderServiceUrl . "v2/orders/by-period";
        }

        public function Process($arParams)
        {
            $Result = new BaseResult();

            $url = $this->Url . "/" . (isset($arParams['PERIOD']) && $arParams['PERIOD'] ? $arParams['PERIOD'] : 30)
            . '?ascending=' . (isset($arParams['ASCENDING']) && $arParams['ASCENDING'] ? 'true' : 'false')
            . '&incompleteOnly=' . (isset($arParams['INCOMPLETE_ONLY']) && $arParams['INCOMPLETE_ONLY'] ? 'true' : 'false')
            . '&customOnly=' . (isset($arParams['CUSTOM_ONLY']) && $arParams['CUSTOM_ONLY'] ? 'true' : 'false')
            . '&paged=' . ($arParams['PAGED'] ? 'true' : 'false')
            . '&pageSize=' . sanitize_text_field($arParams['PAGE_SIZE'])
            . '&pageIndex=' . ($arParams['PAGE_INDEX'] ? sanitize_text_field($arParams['PAGE_INDEX']) : '0');

            if (isset($arParams['TITLE_PATTERN']) && $arParams['TITLE_PATTERN']) 
                $url = $url . '&titlePattern=' . sanitize_text_field($arParams['TITLE_PATTERN']);

            if (!empty($arParams['STATUSES']) && is_array($arParams['STATUSES'])) {
                foreach ($arParams['STATUSES'] as $status) {
                    $clean_status = sanitize_text_field(trim($status));
                    if (!empty($clean_status)) {
                        $url .= '&statuses=' . urlencode($clean_status);
                    }
                }
            }

            if (!empty($arParams['USERS']) && is_array($arParams['USERS'])) {
                foreach ($arParams['USERS'] as $users) {
                    $clean_status = sanitize_text_field(trim($users));
                    if (!empty($clean_status)) {
                        $url .= '&customers=' . urlencode($clean_status);
                    }
                }
            }

            //$this->Result->ErrorMessage = $url;
            //$this->Result->data = $arParams['STATUSES'];
            $this->Result = $this->HttpConnector->GetMessageByUrl($url);
            
            return $this->Result;
        }
    }
?>