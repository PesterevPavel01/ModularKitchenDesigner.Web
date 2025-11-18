<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderApprovalWorkflowLoaderProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/workflows/WorkflowProvider.php';

global $approvalServiceUrl;
?>
<?$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$Result = new BaseResult();

if(isset($args['WORKFLOWS']) && $args['WORKFLOWS']){

    if(!is_array($args['WORKFLOWS'])){

        $activeWorkflows = json_decode($moduleJson = stripslashes($args['WORKFLOWS']), true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            $activeWorkflows = [];

            echo 'Ошибка декодирования JSON: ' . json_last_error_msg();
            
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

$workflowProvider = new WorkflowProvider($approvalServiceUrl);

foreach($activeWorkflows as $workflow){

    $workflowCode = sanitize_text_field($workflow['workflowCode']);

    $Result = $workflowProvider->Approve($workflowCode, $user);

    if(!$Result->isSuccess())
    {?>
    
        <div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
            <small><?=$Result->ErrorMessage?></small>
            <small><?=$Result->data?></small>
            <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    
        <?break;
    
    }
}

get_template_part("parts/catalog/orders/order/template",null,
    [
        'ORDER_CODE' =>  $orderCode
    ]);?>