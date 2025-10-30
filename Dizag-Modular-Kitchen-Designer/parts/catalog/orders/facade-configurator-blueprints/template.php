<?php
$currentMillingComponent = $args['COMPONENT'];
?>

<div class="order-item-new-message-panel d-flex w-100 m-0">

    <ul class="d-flex flex-column w-100 gap-1" id = "123">

        <li class="facade-configurator-file-list d-flex flex-column w-100 m-0" id = "catalog-facade-configurator-file-list">

            <?
            if($currentMillingComponent){

                $blueprints = array_filter($currentMillingComponent['textParameters'], function($item)
                    {
                        return $item['typeCode'] === '000000BPRNT';
                    }
                );
            }

            if($blueprints && !empty($blueprints)){

                foreach($blueprints as $index => $blueprint){?>

                    <input type="text" value="" readonly class="combobox-input-file-path w-100 d-none" name="BLUEPRINT-<?=$index?>" id = "order-item-configurator-file-<?=$index?>-path"/>
                    
                    <a href="<?=$blueprint['value']?>" target="_blank" class = "pointer hover-grey">

                        <p class="combobox-input-file-path w-100 small-text p-2 fs-6 text-center pointer black text-break hover-grey"
                            id="order-item-configurator-file-<?=$index?>-path"><?=basename($blueprint['value']);?></p>
                            
                    </a>

                <?}?>
                
            <?}?>
        </li>

        <input type="hidden" value="<?=esc_html($currentMillingComponent['componentCode'])?>" name="CUSTOM_MILLING_COMPONENT_CODE"/>

        <li class="facade-configurator-corner-bottom combobox-conteiner d-flex flex-column w-100 m-0">

            <button type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal"
                data-bs-target="#order-blueprints-modal"
                data-bs-module-code = "<?=esc_html($args['MODULE_CODE'])?>"
                data-bs-component-code = "<?=esc_html($currentMillingComponent['componentCode'])?>"
                data-bs-blueprints = <?= ($blueprints || !empty($blueprints))? htmlspecialchars(json_encode($blueprints, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>>
            Управление файлами</button>

        </li>
    </ul>

</div>