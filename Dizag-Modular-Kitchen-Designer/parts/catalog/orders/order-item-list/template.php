<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-list");
?>
<?
$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if(!$arParams)
    return;
?>
<section class="catalog-oder-item-list-section d-flex flex-column justify-content-centr gap-2 w-100">

    <?$modules = $args['PARAMETER']['MODULES'];?>
    
    <?foreach($modules as $item){
        get_template_part("parts/catalog/orders/order-item/template", null,                 
        [
            'PARAMETER' =>  [
                'MODULE' => $item
            ]
        ]);

    }?>

</section>