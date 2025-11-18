<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-order-list-item");//подключаю файл <style class="css"></style>

$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

$role = isset($arParams['ROLE']) ? sanitize_text_field($arParams['ROLE']) : '';

$filter = [
    'PERIOD' => sanitize_text_field($args['PERIOD']),
    'ASCENDING' => (isset($args['ASCENDING']) && trim($args["ASCENDING"]) !== "") ? sanitize_text_field($args['ASCENDING']) : "",
    'INCOMPLETE_ONLY' => (isset($args['INCOMPLETE_ONLY']) && trim($args["INCOMPLETE_ONLY"]) !== "") ? sanitize_text_field($args['INCOMPLETE_ONLY']) : "",
    'CUSTOM_ONLY' => (isset($args['CUSTOM_ONLY']) && trim($args["CUSTOM_ONLY"]) !== "") ? sanitize_text_field($args['CUSTOM_ONLY']) : "",
];

if($arParams){

    $login = sanitize_text_field($arParams['USER_NAME']);

    $user = get_user_fullname_by_username($login);
?>
<div class="customer-order-list-item white-background d-flex p-3 w-100 align-items-center">

    <?if(!$arParams['IS_COMPLETED']){?>
        <i class="order-list-item bi bi-file-earmark d-flex flex-column col-1"></i>
    <?}else{?>
        <i class="order-list-item bi bi-file-earmark-check d-flex flex-column col-1"></i>
    <?}?>

    <p class="order-title black d-flex justify-content-start align-items-center m-0 col-5"><?=sanitize_text_field($arParams['TITLE'])?></p>

    <div class="order-list-item-user d-flex  d-flex flex-column align-items-center m-0 p-0 col-2">
        <span class="dark m-0 p-0 w-100 ">Пользователь:</span>
        <p class="order-title black d-flex justify-content-start align-items-center m-0 p-0 w-100"><?= empty($user) ? $login : $user['full_name'] ?></p>
    </div>

    <?php
        $Code = $arParams['ORDER_CODE'];
        $order_url = add_query_arg('Code', $Code, home_url('/order/'));
    ?>

    <block class="panel-control d-flex justify-content-end align-items-center gap-2 col-4">
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
                        data-bs-title="<?=sanitize_text_field($arParams['TITLE'])?>"
                        data-bs-parameters = <?= ($filter || !empty($filter))? htmlspecialchars(json_encode($filter, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>>
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