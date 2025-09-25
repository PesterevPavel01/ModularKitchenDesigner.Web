<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-order-list-item");//подключаю файл <style class="css"></style>

$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($arParams){
?>
<div class="customer-order-list-item white-background flex-row">

    <?if($arParams['APPROVAL']){?>
        <i class="order-list-item bi bi-file-earmark flex-column"></i>
    <?}else{?>
        <i class="order-list-item bi bi-file-earmark-check flex-column"></i>
    <?}?>

    <p class="order-title black flex-row-start"><?=$arParams['TITLE']?></p>

    <block class="panel-control flex-row-end">
        <?if($arParams['APPROVAL']){?>
            <i class="bi bi-exclamation-circle"></i>
            <span class="notification-label">согласование конструктора</span>
        <?}?>
        <div class="d-flex w-100 justify-content-end align-items-center gap10">
            <button class="btn btn-primary">Удалить</button>
            <button class="btn btn-primary">Редактировать</button>
        </div>
    </block>

</div>
    
<?}?>