<?
$title = isset($args['TITLE']) ? sanitize_text_field($args['TITLE']) : "";

$message = isset($args['MESSAGE']) ? sanitize_text_field($args['MESSAGE']) : "";
?>

<div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert">
    
    <?if($title !== ""){?>
        <strong><?=$title?>. </strong>
    <?}?>

    <?if($message !== ""){?>
        <strong><?=$message?></strong>
    <?}?>

    <button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
</div>