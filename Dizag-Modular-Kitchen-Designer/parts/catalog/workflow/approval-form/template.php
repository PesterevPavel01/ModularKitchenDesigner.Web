<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/workflows/WorkflowProvider.php';
?>
<?
global $approvalServiceUrl;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

if(isset($args['WORKFLOWS']) && !empty($args['WORKFLOWS'])){

    //Если этот параметер передан через AJAX
    if(!is_array($args['WORKFLOWS'])){

        $activeWorkflows = json_decode($moduleJson = stripslashes($args['WORKFLOWS']), true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            $activeWorkflows = [];

        get_template_part("parts/catalog/errors/default-error-message/template", null, 
            [
                'TITLE' => 'Ошибка декодирования JSON: ' . json_last_error_msg()
            ]);

            return;
        }

    }else{

        $activeWorkflows = $args['WORKFLOWS'];
    
    }
}else{

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => "Пустой массив 'WORKFLOWS'!"
        ]);
    
    return;

}

if(!isset($args['ORDER_CODE']) || empty($args['ORDER_CODE'])){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => "Не найден параметер 'ORDER_CODE'!"
        ]);

    return;

}

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$Result = new BaseResult();

$workflowProvider = new WorkflowProvider($approvalServiceUrl);

foreach($activeWorkflows as $workflow){

    $workflowCode = sanitize_text_field($workflow['workflowCode']);

    $Result = $workflowProvider->CheckPermission($workflowCode, $user);

    if(!$Result->isSuccess() && trim($Result->data) !== 'Forbidden!')
    {
        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);
        return;
    
    }elseif(trim($Result->data) === 'Forbidden!'){
    ?>
    
        <small class="error-message black text-center border p-2 m-width-200 w-100">Заказ на согласовании!</small>
        <?return;
    
    }

}?>

<form id = "catalog-order-approval-form" class="w-100" data-ajax-default-content-updater="refresh">

    <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#catalog-section-order">
    <input type="hidden" data-no-reset="true" name = "TEMPLATE_PART" value = "parts/catalog/workflow/approval-form/action/template">
    <input type="hidden" data-no-reset="true" name = "action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name = "TARGET_CONTAINER" value="#catalog-section-order">
    <input type="hidden" data-no-reset="true" name="DEPENDENT_FORM" value="#order-submit-reset-form">
    <input type="hidden" data-no-reset="true" name="DEPENDENT_FORM_SECOND" value="#order-item-send-to-configurator-form-">
    <input type="hidden" data-no-reset="true" name = "ORDER_CODE" value = "<?=sanitize_text_field($orderCode)?>">
    <input type="hidden" data-no-reset="true" name = "ACTIVE" value = <?=true?>>
    <input type="hidden" data-no-reset="true" name = "USER" value = <?=$user?>>
    <input type="hidden" data-no-reset="true" name = "ROLE" value = <?=$role?>>

    <button type="submit" class="custom-btn white p-2 border normal-font m-0"
        data-bs-toggle="tooltip" 
        data-bs-placement="top"    
        title="Согласовать">
        СОГЛАСОВАТЬ
    </button>

</form>
