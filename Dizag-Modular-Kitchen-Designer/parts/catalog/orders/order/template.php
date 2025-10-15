<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order");
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';
?>
<?
global $orderServiceUrl;

$current_user = wp_get_current_user();

$roles = $current_user->roles;

$code = $args['PARAMETER']['ORDER_CODE'];

$Result = new BaseResult();

$OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

$Result = $OrderByCodeProcessor->Process($code);

if(!$Result->isSuccess())
{?>
    <p><?=$Result->ErrorMessage?></p>
    <?return;
}

$Order = $Result->data[0];

?>
<section class="section-order d-flex flex-column align-items-start gap-3 w-100 catalog_content_update">
    
    <block class="title-block d-flex flex-column w-100 justify-content-between w-100 flex-lg-row align-items-lg-center">
        
        <t2 class="title w-100">Заказ: <?=$Order['title']?></t2>
        
        <?if(in_array('customer', $roles)){?>
            
            <block class="panel-control d-flex justify-content-start justify-content-xl-end">
                
                <?/*<input type="hidden" id="catalog-order-template_part_to_update" value=<?="parts/catalog/account/customer-order-list/template"?>>
                <input type="hidden" id="catalog-order-html_block_to_update" value=<?="customer-account-oder-list-section"?>>*/?>
                <input type="hidden" id="catalog-order-code" value=<?=$Order['code']?>>

                <div class="d-flex flex-column justify-content-start align-items-center gap-1 flex-xl-row justify-content-xl-end m-0">

                    <a href="<?=home_url('/order/')?>">
                        <button class="ajax-update-button btn btn-primary m-0"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top"    
                            title="Добавить фасады к заказу">
                            Добавить
                        </button>
                    </a>

                    <a href="<?=home_url('/order/')?>">
                        <button class="ajax-update-button btn btn-primary m-0"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top"    
                            title="Заказать">
                            Заказать
                        </button>
                    </a>

                </div>

                
            </block>

        <?}?>

    </block> 

    <?get_template_part("parts/catalog/orders/order-item-list/template",null,
        [
            'PARAMETER'=> [
                'MODULES' =>  $Order['modules']
            ]
        ]);?>

    <?/*get_template_part("parts/catalog/orders/order-item-list/template",null,
        [
            'PARAMETER'=> [
                'MODULES' =>  $Order['modules']
            ]
        ]);*/?>

</section>
<?
?>