<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-messenger");
?>
<?
$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

$current_user = wp_get_current_user();
$display_name = $current_user->display_name;

//print_r($arParams);
?>
<section class="order-item-massenger-section flex-column align-items-start justify-content-start gap-2 m-0 w-100">
    
    <div class="messenger-section-title d-flex w-100 align-items-center">
        <p class="massenger-title black p-1">Комментарии</p>
        <div class="d-flex align-items-center collapse-btn  collapsed" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#horizontalCollapse"
            data-bs-custom-toggle="tooltip" 
            title="Свернуть">
            <i class="bi bi-chevron-down collapse-icon transition-all"></i>
        </div>
    </div>

    <ul class="collapse transition-all order-item-message-list flex-column gap-1 w-100 white-background p-2" id="horizontalCollapse">
        <?for($i = 0; $i < 3; $i++){?>
            <li class="order-item-message d-flex w-100 m-0">

                <ul class="d-flex flex-column w-100 gap-1 border border-secondary rounded p-2" id = "123">
                    <li class="component-panel-controls w-100">
                        <span class = "p-1"><?=$i==1?"Конструктор": $display_name?></span>
                    </li>
                    <li class="component-panel-controls d-flex flex-column w-100 gap-1">
                        <p class="w-100 black mini-font">Текст сообщения, которое отправил конструктор или покупатель, для уточнения деталей заказа!</p>
                    </li>
                </ul>

            </li>
        <?}?>

        <div class="order-item-new-message-panel d-flex w-100 m-0">
            <ul class="d-flex flex-column w-100 gap-1" id = "123">
                <li class="component-panel-controls w-100">
                    <div class="w-100 m-0">
                        <textarea class="form-control" id="comment" rows="3" placeholder="Новый комментарий."></textarea>
                    </div>
                </li>
                <li class="component-panel-controls d-flex flex-column w-100 gap-1">
                    <div class="w-100 m-0 d-flex justify-content-end">
                        <button class="btn btn-primary d-flex">Добавить</button>
                    </div>
                </li>
            </ul>
        </div>

    </ul>
</section>