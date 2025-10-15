<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item");
?>

<?
$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if(!$arParams)
    return;
?>

<section class="catalog-oder-item-section d-flex flex-column gap20 w-100">
    
    <block class="order-item-top d-flex align-items-center w-100 justify-content-between w-100">
        <div class ="d-flex justify-content-start w-100 align-items-center gap-2">
            <i class="bi bi-exclamation-circle d-flex justify-content-start align-items-center"
                data-bs-toggle="tooltip" 
                data-bs-placement="top"    
                title="Требуется согласование конструктора">
            </i>
            <span class = "w-100">
                Требуетсь согласование конструктора!
            </span> 
        </div>
        <i class="icon-remove-section bi bi-x-lg d-flex justify-content-end"
            data-bs-toggle="tooltip" 
            data-bs-placement="top"    
            title="Удалить секцию фасадов"></i>
    </block>

    <section class="order-item-content-section d-flex w-100 gap-3">

        <div class="order-item-specification-block d-flex flex-shrink-0">

            <?get_template_part("parts/catalog/orders/order-item-specification/template");?>

        </div>

        <section class="order-item-right-section d-flex flex-column justify-content-start gap-3 w-100 m-0">
            <div class="order-item-configurator-block w-100">
                <?get_template_part("parts/catalog/orders/facade-configurator/template", null,
                [
                    'PARAMETER' =>  $args['PARAMETER']
                ]);?>
            </div>
            <div class="order-item-messanger-block w-100">
            <?get_template_part("parts/catalog/orders/order-item-messenger/template", null,
                [
                    'PARAMETER' =>  $args['PARAMETER']
                ]);?>
            </div>
        </section>
    </section>
</section>