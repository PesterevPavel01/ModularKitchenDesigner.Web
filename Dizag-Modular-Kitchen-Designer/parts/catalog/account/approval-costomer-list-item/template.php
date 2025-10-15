<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "approval-customer-list-item");//подключаю файл <style class="css"></style>

$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($arParams){
?>
<div class="approval-customer-list-item white-background d-flex justify-content-between align-items-center w-100 gap-2 p-2">

    <block class="approval-item-content d-flex align-items-center justify-content-between w-100 gap-2 p-2">
        <div class="customer-name  d-flex align-items-center gap-2">
            <i class="customer-list-item bi bi-person  d-flex align-items-center justify-content-center"></i>
            <p class="customer-name black d-flex justify-content-start align-items-center small"><?=$arParams['CLIENT_NAME']?></p>
        </div>

        <div class="customer-login-block d-flex flex-column w-100 justify-content-start align-items-center gap-1 flex-xl-row">
            <label class="customer-name-label small">Логин:</label>
            <p class="customer-name black fs-10"><?=$arParams['CLIENT_LOGIN']?></p>
        </div>

    </block>

    <block class="panel-control flex-row-end d-flex justify-content-end align-items-center flex-xl-row p-2">
        <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
            <button type="button" class="btn btn-primary"
                data-bs-toggle="modal" 
                data-bs-target="#remove-customer-modal"
                data-bs-login="<?=htmlspecialchars($arParams['CLIENT_LOGIN'])?>"
                data-bs-name="<?=htmlspecialchars($arParams['CLIENT_NAME'])?>">
                Удалить
            </button>
            <button type="button" class="btn btn-primary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#approve-customer-modal"
                    data-bs-login="<?=htmlspecialchars($arParams['CLIENT_LOGIN'])?>"
                    data-bs-name="<?=htmlspecialchars($arParams['CLIENT_NAME'])?>">
                Согласовать
            </button>
        </div>
    </block>

</div>
    
<?}?>