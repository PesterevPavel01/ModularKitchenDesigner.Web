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

$arParams = $args['PARAMETER'];

$Result = new BaseResult();

if(in_array('constructor', $roles))
{
    $OrdersByPeriodProcessor = new OrdersByPeriodProcessor($orderServiceUrl);

    $Result = $OrdersByPeriodProcessor->Process($arParams);

    if(!$Result->isSuccess())
    {?>
        <p><?=$Result->ErrorMessage?></p>
        <?return;
    }
    
}elseif(in_array('customer', $roles))
{
    $OrdersByCustomerProcessor = new OrdersByCustomerProcessor($orderServiceUrl);

    $Result = $OrdersByCustomerProcessor->Process($current_user->user_login, $arParams);

    if(!$Result->isSuccess())
    {?>
        <p><?=$Result->ErrorMessage?></p>
        <?return;
    }
}
else
{
    return;
}

?>
<section class="customer-account-oder-list-section d-flex flex-column align-items-start w-100 justify-content-start gap-3 w-100 order-2 order-lg-1">
    
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

    <block class="list-items d-flex flex-column align-items-start w-100 justify-content-start gap-1">

        <?foreach($Result->data as $item){

            get_template_part("parts/catalog/account/customer-order-list-item/template", null,                 
            [
                'PARAMETER' =>  [
                    'TITLE' => $item['title'],
                    'ORDER_CODE' => $item['code'],
                    'IS_CUSTOM' => $item['isCustom'],
                    'IS_COMPLETED' => $item['isCompleted'],
                ]
            ]);

        }?>

    </block>

</section>