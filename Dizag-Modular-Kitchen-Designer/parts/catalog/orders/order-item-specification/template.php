<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-specification");
?>

<?
$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;
?>
<section class="order-item-specification-section flex-column align-items-start justify-content-start gap-2 m-0 w-100">
    
    <p class="specification-title black p-1">Спецификация</p>

    <ul class="catalog-order-item-specification flex-grow-1 flex-column justify-content-start gap-2 w-100 white-background p-3 m-0">
        
        <?for($i = 0; $i < 2; $i++){?>
            <li class="specification-item w-100">

                <ul class="specification-list-facade-item d-flex align-items-end justify-content-start gap-1 m-0 overflow-y-auto" id = "123">
                    <?/*<input type="hidden" id="catalog-order-list-template_part_to_update" value=<?="template"?>>
                    <input type="hidden" id="catalog-order-list-html_block_to_update" value=<?="list-section"?>>*/?>

                    <li class="specification-list-item d-flex flex-column w-100 justify-content-end align-items-center">
                        <span class="order-item-specification-label w-100 primary-dark">Высота, мм</span>
                        <input type="number" step="1" min="0" max="2000" value="0" class="height w-100" name="height" id = "order-item-specification-height"/>
                    </li>

                    <li class="specification-list-item d-flex flex-column w-100 justify-content-start align-items-center">
                        <span class="order-item-specification-label w-100 primary-dark">Ширина, мм</span>
                        <input type="number" step="1" min="0" max="2000" value="0" class="order-item-specification-width w-100" name="order-item-specification-width" id = "order-item-specification-width"/>
                    </li>

                    <li class="specification-list-item d-flex flex-column w-100 justify-content-start align-items-center">
                        <span class="order-item-specification-label w-100 primary-dark">Количество</span>
                        <input type="number" step="1" min="0" max="2000" value="0" class="order-item-specification-quantity w-100" name="order-item-specification-quantity" id = "order-item-specification-quantity"/>
                    </li>

                    <li class="specification-list-item-remove  flex-column m-0 btn btn-primary">
                            <i class = "bi bi-x-lg flex-column w-100 primary-dark"                
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"    
                                title="Удалить элемент"></i>
                    </li>
                </ul>
            </li>
        <?}?>
        
        <li class="specification-item-add-new d-flex w-100 justify-content-start align-items-center btn btn-primary m-0">
            <i class = "bi bi-plus flex-column-start align-items-center w-100 primary-dark"></i>
        </li>
    </ul>
</section>