<?
$title = isset($args['TITLE']) ? sanitize_text_field($args['TITLE']) : '';
$list_name = isset($args['LIST_NAME']) ? sanitize_text_field($args['LIST_NAME']) : '';
?>

<ul class="mt-2 p-0">
  <small class="checkbox_label primary-dark ps-1"><?=$title?>:</small>
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