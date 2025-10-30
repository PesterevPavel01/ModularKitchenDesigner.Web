<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-list");
?>
<?
$arParams = isset($args['MODULES']) ? $args['MODULES'] : null;
?>
<section class="catalog-oder-section d-flex flex-column justify-content-centr gap-2 w-100 p-3 rounded">

    <div class="catalog-oder-content-conteiner d-flex flex-column gap20 w-100" id = "catalog-oder-content-conteiner">

        <div class="catalog-oder-content d-flex">

            <div class="catalog-order-specification-section d-flex flex-column align-items-start justify-content-start gap-2 p-2 m-0 col-9"
                id = "catalog-order-specification-section">
                <?if($arParams){?>
                <?
                    get_template_part("parts/catalog/orders/order-specification/template", null,
                    [
                        'MODULES' => $args['MODULES'],
                        'ORDER_CODE' => $args['ORDER_CODE']
                    ]);
                ?>
                <?}
                else{?>
                    <p class="error-message black">Необходимо добавить фасады, используя конфигуратор!</p>
                <?}
                ?>
            </div>

            <div class="catalog-order-item-redactor d-flex col-3 p-2" id = "catalog-order-item-redactor">

                    <div class="order-item-configurator-block w-100">
                        <?get_template_part("parts/catalog/orders/facade-configurator/template", null,
                        [
                            'MODULE' =>  null,
                            'ORDER_CODE' => $args['ORDER_CODE']
                        ]);?>
                    </div>
                
            </div>

        </div>

    </div>

    <block class="order-messanger-block w-100">
        <?get_template_part("parts/catalog/orders/order-item-messenger/template", null,
        [
            'MODULE' =>  $args['MODULE']
        ]);?>
    </block>

</section>