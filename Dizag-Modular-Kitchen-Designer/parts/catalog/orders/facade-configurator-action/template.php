<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/modules/ModuleProvider.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderItemQuantityClient.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderItemCreator.php';

global $orderServiceUrl;
global $moduleServiceUrl;

$errors = 0;

$Result = new BaseResult();

$current_user = wp_get_current_user();

$login = $current_user->user_login;

$roles = $current_user->roles;

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$moduleCode = sanitize_text_field($args['MODULE_CODE']);
?>
<?
    if(!isset($args['MEMBRANE']) || trim($args['MEMBRANE']) === '' || $args['MEMBRANE'] === "0"){
        ?>
            <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                <strong>Внимание! Пленка - обязательное поле!</strong>
                <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?
        $errors++;
    }

    if(!isset($args['LENGTH']) || trim($args['LENGTH']) === ''){
    ?>
        <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
            <strong>Внимание! Высота - обязательное поле!</strong>
            <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?
    $errors++;
    }

    if(!isset($args['WIDTH']) || trim($args['WIDTH']) === ''){
    ?>
        <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
            <strong>Внимание! Ширина - обязательное поле!</strong>
            <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?
    $errors++;
    }

    if(!isset($args['QUANTITY']) || trim($args['QUANTITY']) === ''){
        ?>
            <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                <strong>Внимание! Количество - обязательное поле!</strong>
                <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?
        $errors++;
    }

    if(!isset($args['CORNER']) || trim($args['CORNER']) === '' || $args['CORNER'] === "0"){
        ?>
            <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                <strong>Внимание! Кромка - обязательное поле!</strong>
                <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?
        $errors++;
    }

    if(!isset($args['MILLING']) || trim($args['MILLING']) === '' || $args['MILLING'] === "0"){
        ?>
            <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                <strong>Внимание! Фрезеровка - обязательное поле!</strong>
                <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?
        $errors++;
    }

    if($errors === 0)
    {
        $ModuleProvider = new ModuleProvider($moduleServiceUrl);

        $arParams = $args;

        if($arParams['MILLING'] === "CUSTOM_MILLING")
            $arParams['MILLING'] = $arParams['CUSTOM_MILLING_COMPONENT_CODE'];

        if($arParams['HINGE'] === "CUSTOM_HINGE")
            $arParams['HINGE'] = $arParams['CUSTOM_HINGE_COMPONENT_CODE'];

        if(!$moduleCode)
        {
            $Result = $ModuleProvider->Create($arParams);

            if(!$Result->isSuccess())
            {?>
                <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                    <strong><?=$Result->ErrorMessage?></strong>
                    <strong><?=$Result->data?></strong>
                    <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?
            }

            $arParams['MODULE_CODE'] = sanitize_text_field($Result->data['moduleCode']);

            $moduleCode = sanitize_text_field($Result->data['moduleCode']);

            if($Result->isSuccess()){

                $OrderItemCreator = new OrderItemCreator($orderServiceUrl);

                $Result = $OrderItemCreator->Execute($orderCode, $moduleCode, absint(sanitize_text_field($arParams['QUANTITY'])));

                if(!$Result->isSuccess())
                {?>
                    <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                        <strong><?=$Result->ErrorMessage?></strong>
                        <strong><?=$Result->data?></strong>
                        <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?
                }
            }

        }else{

            $OrderItemQuantityClient = new OrderItemQuantityClient($orderServiceUrl);
        
            $Result = $OrderItemQuantityClient->Execute($orderCode, $moduleCode, absint(sanitize_text_field($arParams['QUANTITY'])));
    
            if(!$Result->isSuccess())
            {?>
                <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                    <strong><?=$Result->ErrorMessage?></strong>
                    <strong><?=$Result->data?></strong>
                    <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?
            }
        }

        if($Result->isSuccess())
            $Result = $ModuleProvider->Update($arParams);

        if(!$Result->isSuccess())
        {?>
            <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                <strong><?=$Result->ErrorMessage?></strong>
                <strong><?=$Result->data?></strong>
                <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?
        }
    }
?>
<?

$OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);
        
$Result = $OrderByCodeProcessor->Process($orderCode);

if(!$Result->isSuccess())
{?>
    <p><?=$Result->ErrorMessage?></p>
    <?return;
}

$order = $Result->data[0];

if($orderCode && !in_array('constructor', $roles) && $login != $order['userName'] ){
    ?><p class="error-message black">У пользователя нет необходимых прав!</p><?
    return;
}

get_template_part("parts/catalog/orders/order-item-list/template",null,
[
    'ORDER_CODE' =>  $orderCode,
    'MODULES' =>  $order['modules'],
    'ACTIVE_MODULE_CODE' => $moduleCode,
]);

/*
get_template_part("parts/catalog/orders/order-specification/template", null,
    [
        'MODULES' => $order['modules'],
        'ORDER_CODE' => $orderCode,
        //'ACTIVE_MODULE_CODE' => $moduleCode,
        'ACTIVATE_ELEMENT_GROUP' => 'specification-item-change-button'
    ]);?>*/