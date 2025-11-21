<?php

$currentComponent = isset($args['COMPONENT']) ? $args['COMPONENT'] : [];

$componentType = isset($args['COMPONENT_TYPE']) ? sanitize_text_field($args['COMPONENT_TYPE']) : "";

if($componentType === ""){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Не указан тип компонента!',
    ]);
}

$componentCode = !empty($currentComponent) ? sanitize_text_field($currentComponent['componentCode']) : "";

?>

<div class="order-item-blueprints-panel d-flex w-100 m-0">

    <ul class="d-flex flex-column w-100 gap-1 m-0 p-0">

        <li class="facade-configurator-file-list d-flex flex-column w-100 m-0" id = "catalog-facade-configurator-<?=$componentType?>-file-list">

            <?
            $blueprints = [];

            if($currentComponent){

                $blueprints = array_filter($currentComponent['textParameters'], function($item)
                    {
                        return $item['typeCode'] === '000000BPRNT';
                    }
                );
            }

            if($blueprints && !empty($blueprints)){

                foreach($blueprints as $index => $blueprint){?>

                    <input type="text" value="" readonly class="combobox-input-file-path w-100 d-none" name="BLUEPRINT-<?=$index?>" id = "order-item-configurator-<?=$componentType?>-file-<?=$index?>-path"/>
                    
                    <a href="<?=$blueprint['value']?>" target="_blank" class = "pointer hover-grey">

                        <p class="combobox-input-file-path w-100 small-text p-2 fs-6 text-center pointer black text-break hover-grey"
                            id="order-item-configurator-<?=$componentType?>-file-<?=$index?>-path"><?=basename($blueprint['value']);?></p>
                            
                    </a>

                <?}?>
                
            <?}?>
        </li>
        
        <input type="hidden" value="<?=$componentCode?>" name="CUSTOM_<?=strtoupper($componentType)?>_COMPONENT_CODE"/>

        <li class="facade-configurator-corner-bottom combobox-conteiner d-flex flex-column w-100 m-0">

            <button type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal"
                data-bs-target="#order-<?=$componentType?>-blueprints-modal"
                data-bs-component-code = "<?=$componentCode?>"
                data-bs-blueprints = <?= ($blueprints || !empty($blueprints))? htmlspecialchars(json_encode($blueprints, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>>
            Управление файлами</button>

        </li>
    </ul>

</div>