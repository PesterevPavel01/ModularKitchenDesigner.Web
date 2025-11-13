<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-order-list-item");//подключаю файл <style class="css"></style>

$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

$role = isset($arParams['ROLE']) ? sanitize_text_field($arParams['ROLE']) : '';

if($arParams){
?>
<div class="customer-order-list-item white-background d-flex w-100 gap-2 p-3 align-items-center">

    <?if(!$arParams['IS_COMPLETED']){?>
        <i class="order-list-item bi bi-file-earmark d-flex flex-column"></i>
    <?}else{?>
        <i class="order-list-item bi bi-file-earmark-check d-flex flex-column"></i>
    <?}?>

    <p class="order-title w-50 black d-flex justify-content-start align-items-center m-0"><?=sanitize_text_field($arParams['TITLE'])?></p>

    <?php
        $Code = $arParams['ORDER_CODE'];
        $order_url = add_query_arg('Code', $Code, home_url('/order/'));
    ?>

    <block class="panel-control d-flex justify-content-end align-items-center w-50 gap-2">
        <?if($arParams['IS_CUSTOM']){?>
            <i class="bi bi-exclamation-circle d-flex"
                data-bs-toggle="tooltip" 
                data-bs-placement="top"    
                title="Требуется согласование конструктора"></i>
        <?}?>

            <div class="d-flex flex-column justify-content-end align-items-center gap-1 flex-xl-row">
                <?if( $role == 'customer' ||  $role == 'Administrator' ){?>
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#remove-order-modal"
                        data-bs-code="<?=htmlspecialchars($Code)?>"
                        data-bs-title="<?=sanitize_text_field($arParams['TITLE'])?>">
                        Удалить
                    </button>
                <?}?>
                <a href="<?=esc_url($order_url)?>">
                    <button class="btn btn-primary">Редактировать</button>
                </a>
            </div>
    </block>

</div>
    
<?}?>