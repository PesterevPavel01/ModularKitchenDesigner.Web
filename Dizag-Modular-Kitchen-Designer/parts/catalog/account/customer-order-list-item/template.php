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
<div class="customer-order-list-item white-background d-flex flex-column flex-sm-row w-100 align-items-start align-items-sm-center align-items-start shadow-sm">

    <div class="order-list-item-title d-flex flex-column flex-sm-row align-items-center p-sm-2 col-12 col-sm-2">

        <?if(!$arParams['IS_COMPLETED']){?>

            <i class="order-list-item bi bi-file-earmark d-flex flex-column"></i>

        <?}else{?>

            <i class="order-list-item bi bi-file-earmark-check d-flex flex-column"></i>

        <?}?>

        <p class="order-title black d-flex justify-content-start align-items-center ps-sm-2 m-0"><?=sanitize_text_field($arParams['TITLE'])?></p>

    </div>

    <div class="order-list-item-user d-flex flex-column align-items-center m-auto m-sm-0 p-0 col-12 col-sm-5">
        <span class="dark m-0 p-0 w-100 text-center text-sm-start">Пользователь:</span>
        <p class="order-title black text-center text-sm-start align-items-center m-0 p-0 w-100"><?= empty($user) ? $login : $user['full_name'] ?></p>
    </div>

    <?php
        $Code = $arParams['ORDER_CODE'];
        $order_url = add_query_arg('Code', $Code, home_url('/order/'));
    ?>

    <block class="panel-control d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-center gap-2 col-12 col-sm-5">
        
        <?if($arParams['IS_CUSTOM']){?>
            <i class="bi bi-exclamation-circle d-flex"
                data-bs-toggle="tooltip" 
                data-bs-placement="top"    
                title="Требуется согласование конструктора"></i>
        <?}?>

        <div class="d-flex flex-column justify-content-start justify-content-sm-end align-items-center p-2 gap-1 flex-xl-row">
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
                <button class="btn btn-primary">Открыть</button>
            </a>
        </div>
    </block>

</div>
    
<?}?>