<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "approval-customer-list-item");//подключаю файл <style class="css"></style>

$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($arParams){
?>
<div class="approval-customer-list-item white-background flex-row">

    <i class="customer-list-item bi bi-person flex-column"></i>
    <p class="customer-name black flex-row-start small"><?=$arParams['CLIENT_NAME']?></p>
    
    <div class="customer-login-block d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
        <label class="customer-name-label small">Логин:</label>
        <p class="customer-name black fs-10"><?=$arParams['CLIENT_LOGIN']?></p>
    </div>
    
    <block class="panel-control flex-row-end">
        <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
            <button class="btn btn-primary">Удалить</button>
            <button type="button" class="btn btn-primary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#approve-modal"
                    data-bs-login="<?=htmlspecialchars($arParams['CLIENT_LOGIN'])?>"
                    data-bs-name="<?=htmlspecialchars($arParams['CLIENT_NAME'])?>">
                Согласовать
            </button>
        </div>
    </block>

</div>
    
<?}?>