<?$value = isset($args['MESSEGE_COUNTER_VALUE']) ? sanitize_text_field($args['MESSEGE_COUNTER_VALUE']) : "";

if($value === "")
    return;
?>
<div class="order-item-message-counter text-center d-flex flex-column justify-content-center border br-10 w-20 h-20 bold-font m-0 p-0"><?=$value?></div>