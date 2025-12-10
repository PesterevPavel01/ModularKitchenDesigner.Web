<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-list");
?>
<?

$code = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";
?>

<div class="catalog-oder-content-conteiner d-flex flex-column gap20 w-100" id = "catalog-oder-content-conteiner">

    <div class="catalog-oder-content d-flex flex-column flex-lg-row">

        <div class="catalog-order-specification-section d-flex flex-column align-items-start justify-content-start gap-2 p-o p-lg-2 m-0 col-12 col-lg-9 order-2 order-lg-1"

            id = "catalog-order-specification-section">
            <?
                get_template_part("parts/catalog/orders/order-specification/template", null,
                [
                    'ORDER_CODE' => $code,
                    'USER' => $user,
                    'ROLE' => $role,
                    'MODULES' =>  $args['MODULES'],
                    'IS_COMPLETED' => $args['IS_COMPLETED'],
                ]);
            ?>
        </div>

        <?//КОНФИГУРАТОР?>

        <div class="catalog-order-item-redactor d-none d-lg-flex gap-2 gap-lg-0 col-12 col-lg-3 p-2 order-1 order-lg-2">

            <div class="order-item-redactor-content w-100" id = "order-item-redactor-content">

                <?/*При загрузке страницы конфигуратор загрузится через AJAX вызовом события submit формы в файле ../Order/script.js*/ ?>

            </div>
            
        </div>

    </div>

</div>

<?//Конфигуратор для мобильной версии?>

<div class="catalog-order-item-redactor offcanvas offcanvas-start w-100 d-lg-none" tabindex="-1" id = "catalog-order-item-redactor-modal" aria-labelledby="catalog-order-item-redactor-modal-label" aria-hidden="true">
    
    <div class="offcanvas-body">

        <div class="modal-content">

            <div class="order-item-redactor-content-modile w-100" id = "order-item-redactor-content-mobile">
               <?/*При загрузке страницы использую форму для вызова AJAX-загрузки конфигуратора с учетом размера экрана*/?> 
            </div>

            <?get_template_part("parts/catalog/orders/order-item-messenger-mobile/template");?>

        </div>

    </div>

</div>

<?get_template_part("parts/catalog/forms/order-item-remove-form/template");?>

