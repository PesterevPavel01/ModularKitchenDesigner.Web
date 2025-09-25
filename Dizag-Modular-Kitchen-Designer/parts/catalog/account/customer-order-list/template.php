<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-order-list");//подключаю файл <style class="css"></style>
?>
<?
$current_user = wp_get_current_user();

$roles = $current_user->roles;

if(in_array('constructor', $roles))
{
    //загрузка заказов всех пользователей
}elseif(in_array('customer', $roles))
{
    //загрузка заказов всех текущего пользователя
}
else
{
    return;
}
?>
<section class="customer-order-list flex-row gap40">

    <section class="oder-list-section flex-column-start gap20">
        
        <t2 class="title">Мои заказы</t2>

        <block class="list-items flex-column-start gap2">
            <?for($item = 1; $item < 10; $item++){
                get_template_part("parts/catalog/account/customer-order-list-item/template", null,                 
                [
                    'PARAMETER' =>  [
                        'TITLE' => 'заказ 18.09.2025 9:59:56.303272',
                        'APPROVAL' => true
                    ]
                ]);
            }?>
            <?for($item = 1; $item < 10; $item++){
                get_template_part("parts/catalog/account/customer-order-list-item/template", null,                 
                [
                    'PARAMETER' =>  [
                        'TITLE' => 'заказ 18.09.2025 9:59:56.303272',
                        'APPROVAL' => false
                    ]
                ]);
            }?>
        </block>

    </section>

    <section class="order-list-parameters-section flex-column align-items-start justify-content-start mx-width-350 gap20 m-0">
        
        <t2 class="title">Параметры</t2>

        <ul class="parameters-section d-flex flex-column align-items-start justify-content-start w-100 gap10 white-background m-0">
            
            <li class="parameter-item d-flex w-100 justify-content-start">
                <div class="approval-orders-only d-flex align-items-center w-100 gap6">
                    <span class="checkbox_label">Период, дн.</span>
                    <input type="number" step="1" min="0" max="100" value="30" class="quantity-value" name="quantity"/>
                </div>
            </li>

            <li class="parameter-item-active d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" type="checkbox" id="approvalCheck">
                <span class="checkbox_label">только активные заказы</span>
            </li>

            <li class="parameter-item-approval d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" type="checkbox" id="approvalCheck">
                <span class="checkbox_label">только на согласовании</span>
            </li>

            <li class="parameter-item-sort d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" type="checkbox" id="approvalCheck">
                <span class="checkbox_label">сначала старые заказы</span>
            </li>

            <button class="btn btn-primary w-100">
                <span class="btn_label">Применить</span>
                <span class="bi bi-arrow-repeat"></span>
            </button>

        </ul>

        <t2 class="title">Последняя активность</t2>

        <ul class="new-comments-block d-flex flex-column align-items-start justify-content-start w-100 gap10 white-background m-0">
            
            <li class="parameter-item-active d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title">заказ 18.09.2025 9:59:56.303272</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

            <li class="parameter-item-active d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title">заказ 18.09.2025 9:59:56.303272</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

            <li class="parameter-item-approval d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title">заказ 18.09.2025 9:59:56.303272</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

            <li class="parameter-item-sort d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title">заказ 18.09.2025 9:59:56.303272</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

        </ul>

    </section>

</section>