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
<div class="customer-order-list-item white-background d-flex flex-column flex-sm-row p-3 p-sm-0 w-100 align-items-sm-center align-items-start shadow-lg shadow-lg-sm gap-1 gap-sm-0">

    <div class="order-list-item-title d-flex flex-row align-items-center justify-content-between justify-content-sm-start p-sm-2 col-12 col-sm-2">

        <?if(!$arParams['IS_COMPLETED']){?>

            <i class="order-list-item bi bi-file-earmark d-flex flex-column order-2 order-lg-1"></i>

        <?}else{?>

            <i class="order-list-item bi bi-file-earmark-check d-flex flex-column order-2 order-lg-1"></i>

        <?}?>

        <p class="order-title black d-none d-lg-flex justify-content-start align-items-center ps-sm-2 m-0 order-1 order-lg-2"><?=sanitize_text_field($arParams['TITLE'])?></p>
        <strong class="order-title black d-flex d-lg-none justify-content-start align-items-center ps-sm-2 m-0 order-1 order-lg-2"><?=sanitize_text_field($arParams['TITLE'])?></strong>

    </div>

    <div class="order-list-item-user d-flex flex-column align-items-center m-sm-0 p-0 col-12 col-sm-5 justify-content-start justify-content-sm-center">
        <span class="dark m-0 p-0 w-100 text-start text-sm-start">Пользователь:</span>
        <p class="order-title black d-none d-lg-flex text-start align-items-center m-0 p-0 w-100"><?= empty($user) ? $login : $user['full_name'] ?></p>
        <strong class="order-title black d-flex d-lg-none text-start align-items-center m-0 p-0 w-100"><?= empty($user) ? $login : $user['full_name'] ?></strong>
    </div>

    <?php
        $Code = $arParams['ORDER_CODE'];
        $order_url = add_query_arg('Code', $Code, home_url('/order/'));
    ?>

    <block class="panel-control d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start align-items-sm-center gap-2 col-12 col-sm-5">
        
        <?if($arParams['IS_CUSTOM']){?>
            <i class="bi bi-exclamation-circle d-flex col-1"
                data-bs-toggle="tooltip" 
                data-bs-placement="top"    
                title="Требуется согласование конструктора"></i>
        <?}?>

        <div class="d-flex flex-row justify-content-start justify-content-sm-end align-items-center p-0 p-sm-2 gap-1 <?=($role == 'customer' ||  $role == 'Administrator') ? "col-12 col-sm-8" : "col-12 col-sm-6"?>">
            
            <?if( $role == 'customer' ||  $role == 'Administrator' ){?>
                <button type="button" class="btn btn-primary border col-6"
                    data-bs-toggle="modal"
                    data-bs-target="#remove-order-modal"
                    data-bs-code="<?=htmlspecialchars($Code)?>"
                    data-bs-title="<?=sanitize_text_field($arParams['TITLE'])?>"
                    data-bs-order-user="<?=$login?>"
                    data-bs-parameters = <?= ($filter || !empty($filter))? htmlspecialchars(json_encode($filter, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>>
                    Удалить
                </button>
            <?}?>
            <a href="<?=esc_url($order_url)?>" class= "<?=($role == 'customer' ||  $role == 'Administrator') ? "col-6" : "w-100"?>">
                <button class="btn btn-primary border w-100">Открыть</button>
            </a>

        </div>
    </block>

</div>
    
<?}?>