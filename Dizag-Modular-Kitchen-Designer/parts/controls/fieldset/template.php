<?
$title = isset($args['TITLE']) ? sanitize_text_field($args['TITLE']) : '';
$list_name = isset($args['LIST_NAME']) ? sanitize_text_field($args['LIST_NAME']) : '';
$conteinerClass =  isset($args['MAIN_CONTEINER_CLASS']) ? sanitize_text_field($args['MAIN_CONTEINER_CLASS']) : '';
$contentClass =  isset($args['CONTENT_CONTEINER_CLASS']) ? sanitize_text_field($args['CONTENT_CONTEINER_CLASS']) : '';
?>

<div class="mt-2 p-0 w-100 <?=$conteinerName?>">

  <small class="checkbox_label primary-dark ps-1"><?=$title?>:</small>

  <div class="<?=$contentClass?>">

    <div class = "h-100 overflow-auto">

      <ul class="d-flex flex-column align-items-start m-0 p-0">

        <?$count = 0;
        
        foreach ($args['ITEMS'] as $item) {?>
            
          <li class="form-check m-0 p-0">

            <input class="custom-checkbox border-primary m-0 p-0" type="checkbox" name="<?= sanitize_text_field($list_name)?>[]" id="option" . <?=$count?> value=<?=sanitize_text_field($item['VALUE'])?>>
            
            <small class="checkbox_label m-0 p-0" for="option" . <?=$count?>>
              <?=sanitize_text_field($item['NAME'])?>
            </small>

          </li>

          <?$count ++;

        }?>

      </ul>

    </div>

  </div>

</div>