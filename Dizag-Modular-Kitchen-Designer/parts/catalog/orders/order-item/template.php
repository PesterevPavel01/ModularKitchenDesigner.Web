<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item");
?>

<?
//$arParams = isset($args['MODULE']) ? $args['MODULE'] : null;
/*
if(!$arParams)
    return;*/
?>

<div class="order-item-right-section d-flex flex-column justify-content-start gap-3 w-100 m-0">

    <div class="order-item-configurator-block w-100">
        <?get_template_part("parts/catalog/orders/facade-configurator/template", null,
        [
            'MODULE' =>  $args['MODULE']
        ]);?>
    </div>

</div>