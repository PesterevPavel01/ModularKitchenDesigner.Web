<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/workflows/WorkflowProvider.php';
?>
<?
global $approvalServiceUrl;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

if(isset($args['WORKFLOWS']) && !empty($args['WORKFLOWS'])){
    
    //print_r($args['WORKFLOWS']);

    //Если этот параметер передан через AJAX
    if(!is_array($args['WORKFLOWS'])){

        $activeWorkflows = json_decode($moduleJson = stripslashes($args['WORKFLOWS']), true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            $activeWorkflows = [];?>

            <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
                <small>'Ошибка декодирования JSON: '<?= json_last_error_msg()?></small>
                <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
            </div><?

            return;
        }

    }else{

        $activeWorkflows = $args['WORKFLOWS'];
    
    }
}else{?>

    <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
        <small>Пустой массив 'WORKFLOWS'!</small>
        <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?return;

}

if(!isset($args['ORDER_CODE']) || empty($args['ORDER_CODE'])){?>

    <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
        <small>Не найден параметер 'ORDER_CODE'!</small>
        <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?  return;

}

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$Result = new BaseResult();

$workflowProvider = new WorkflowProvider($approvalServiceUrl);

foreach($activeWorkflows as $workflow){

    $workflowCode = sanitize_text_field($workflow['workflowCode']);

    $Result = $workflowProvider->CheckPermission($workflowCode, $user);

    if(!$Result->isSuccess() && trim($Result->data) !== 'Forbidden!')
    {?>
    
        <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
            <small><?=$Result->data?></small>
            <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    
        <?return;
    
    }elseif(trim($Result->data) === 'Forbidden!'){
    ?>
    
        <small class="error-message black text-center border p-2 m-width-200 w-100">Заказ на согласовании!</small>
        <?return;
    
    }

}?>

<form id = "catalog-order-approval-form" class="w-100" data-ajax-default-content-updater="refresh">

    <input type="hidden" name = "BLOCKED_ELEMENT" value = "#catalog-section-order">
    <input type="hidden" name = "TEMPLATE_PART" value = "parts/catalog/workflow/approval-form-action/template">
    <input type="hidden" name = "action" value="default_content_updater">
    <input type="hidden" name = "TARGET_CONTAINER" value="#catalog-section-order">
    <input type="hidden" name="DEPENDENT_FORM" value="#order-submit-reset-form">
    <input type="hidden" name = "ORDER_CODE" value = "<?=sanitize_text_field($orderCode)?>">
    <input type="hidden" name = "ACTIVE" value = <?=true?>>
    <input type="hidden" name = "USER" value = <?=$user?>>
    <input type="hidden" name = "ROLE" value = <?=$role?>>
    <input type="hidden" name = "WORKFLOWS" value="<?= ($activeWorkflows || !empty($activeWorkflows))? htmlspecialchars(json_encode($activeWorkflows, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>">

    <button type="submit" class="ajax-update-button btn btn-primary border m-0 w-100"
        data-bs-toggle="tooltip" 
        data-bs-placement="top"    
        title="Согласовать">
        Согласовать
    </button>

</form>
