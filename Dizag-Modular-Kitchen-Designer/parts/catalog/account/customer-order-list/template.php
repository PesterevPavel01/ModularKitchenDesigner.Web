<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-order-list");//подключаю файл <style class="css"></style>
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrdersByCustomerProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrdersByPeriodProcessor.php';
?>
<?
global $orderServiceUrl;

$current_user = wp_get_current_user();

$roles = $current_user->roles;

$arParams = $args;

$Result = new BaseResult();

$page = isset($args['PAGE']) ? intval(sanitize_text_field(wp_unslash($args['PAGE']))) : 0;

$account_page = get_page_by_path('account');

$account_page_id = $account_page->ID;

$pageSize = get_field('catalog_order_list_page_size', $account_page_id);

if(!$pageSize || trim($pageSize) === "")
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'MESSAGE' => 'Не задан параметер "Количество записей на странице"!'
    ]);
    
    return;
}

$arParams['PAGE_INDEX'] = $page;

$arParams['PAGE_SIZE'] = $pageSize;

$arParams['PAGED'] = true;

if(in_array('constructor', $roles))
{
    $role = 'constructor';

    $OrdersByPeriodProcessor = new OrdersByPeriodProcessor($orderServiceUrl);

    $Result = $OrdersByPeriodProcessor->Process($arParams);

    if(!$Result->isSuccess())
    {    
        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);
        
        return;
    }
    
}elseif(in_array('customer', $roles))
{
    $role = 'customer';

    $OrdersByCustomerProcessor = new OrdersByCustomerProcessor($orderServiceUrl);

    $Result = $OrdersByCustomerProcessor->Process($current_user->user_login, $arParams);

    if(!$Result->isSuccess())
    {    
        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);
        
        return;
    }
}
else
{
    return;
}

?>
<section class="customer-account-oder-list-content d-flex flex-column align-items-start w-100 justify-content-start gap-2 w-100 order-2 order-lg-1">
    
    <block class="title-block  d-flex align-items-center w-100 justify-content-between">
        
        <t2 class="title ps-2">Заказы</t2>

        <?if(in_array('customer', $roles)){?>

            <a href="<?=home_url('/order/')?>">
                <button class="ajax-update-button btn btn-primary m-0"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="Добавить новый заказ">
                    Новый заказ
                </button>
            </a>

        <?}?>

    </block> 

    <block class="list-items d-flex flex-column align-items-start w-100 justify-content-start gap-2 gap-lg-1">

        <?foreach($Result->data['items'] as $item){

            $params = [];

            $params = [
                'PARAMETER' =>  [
                    'TITLE' => $item['title'],
                    'USER_NAME' => $item['userName'], 
                    'ORDER_CODE' => $item['code'],
                    'IS_CUSTOM' => $item['isCustom'],
                    'IS_COMPLETED' => $item['isCompleted'],
                    'ROLE' => $role,
                ]
            ];

            //передаем массив с данными фильтра дальше!
            foreach($arParams as $key => $value )
                $params[$key] = $value;

            get_template_part("parts/catalog/account/customer-order-list-item/template", null, $params);

        }?>

        <?get_template_part("parts/catalog/forms/order-list-page-switcher-form/template", null,                 
            [
                'PERIOD' => $args['PERIOD'],
                'ASCENDING' => isset($arParams['ASCENDING']) && $arParams['ASCENDING'] ? true : false,
                'INCOMPLETE_ONLY' => isset($arParams['INCOMPLETE_ONLY']) && $arParams['INCOMPLETE_ONLY'] ? true : false,
                'CUSTOM_ONLY' => isset($arParams['CUSTOM_ONLY']) && $arParams['CUSTOM_ONLY'] ? true : false, 
                'TOTAL_COUNT' => $Result->data['totalCount'],
                'TOTAL_PAGES' => $Result->data['totalPages'],
                'PAGE' => $Result->data['pageIndex']
            ]);?>

    </block>

</section>