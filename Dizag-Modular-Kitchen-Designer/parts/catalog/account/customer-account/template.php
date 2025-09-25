<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-account");//подключаю файл <style class="css"></style>
?>
<?get_template_part("parts/catalog/account/customer-order-list/template");?>