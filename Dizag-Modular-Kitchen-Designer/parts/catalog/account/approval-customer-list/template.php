<?
enqueue_template_part_styles_scripts( __DIR__, "approval-customer-list");

require_once get_template_directory() . '/core/services/processors/catalog/user/UnassignedUserProcessor.php';
require_once get_template_directory() . '/core/Result.php';

global $clientServiceUrl;
?>


<div class="list-items d-flex flex-column w-100 justify-content-start align-items-center gap-1">
    <?
    $UnassignedUserProcessor = new UnassignedUserProcessor($clientServiceUrl);

    $unassignedUsersResult = new BaseResult();

    $unassignedUsersResult = $UnassignedUserProcessor->Process(); 

    if(!$unassignedUsersResult->IsSuccess())
    {
        ?>
        <p class="error-message black"><?=$unassignedUsersResult->ErrorMessage == "Users not found!" ? "Нет новых пользователей!" : $unassignedUsersResult->ErrorMessage?></p>
        <?
        return;
    }
    ?>
    <?foreach ($unassignedUsersResult->data as $user) {
        get_template_part("parts/catalog/account/approval-costomer-list-item/template", null,                 
        [
            'PARAMETER' =>  [
                'CLIENT_NAME' => $user['Name'],
                'CLIENT_LOGIN' => $user['Login']
            ]
        ]);
    }?>
</div>