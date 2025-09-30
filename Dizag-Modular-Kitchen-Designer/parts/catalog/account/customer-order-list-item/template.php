<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-order-list-item");//подключаю файл <style class="css"></style>

$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($arParams){
?>
<div class="customer-order-list-item white-background flex-row">

    <?if(!$arParams['IS_COMPLETED']){?>
        <i class="order-list-item bi bi-file-earmark flex-column"></i>
    <?}else{?>
        <i class="order-list-item bi bi-file-earmark-check flex-column"></i>
    <?}?>

    <p class="order-title black flex-row-start"><?=$arParams['TITLE']?></p>

    <?if($arParams['IS_CUSTOM']){?>
        <i class="bi bi-exclamation-circle d-flex justify-content-end"
            data-bs-toggle="tooltip" 
            data-bs-placement="top"    
            title="Требуется согласование конструктора"></i>
    <?}?>

    <?php
        $Code = $arParams['ORDER_CODE'];
        $order_url = add_query_arg('Code', $Code, home_url('/order/'));
    ?>

    <block class="panel-control flex-row-end">
        <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
            <button class="btn btn-primary">Удалить</button>
            <a href="<?=esc_url($order_url)?>">
                <button class="btn btn-primary">Редактировать</button>
            </a>
        </div>
    </block>

</div>
    
<?}?>