<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-facade-configurator");

require_once get_template_directory() . '/core/services/processors/catalog/modules/ModuleProvider.php';
require_once get_template_directory() . '/core/services/processors/catalog/components/ComponentProvider.php';
require_once get_template_directory() . '/core/Result.php';

global $moduleServiceUrl;
global $componentServiceUrl;
?>

<?

    $ModuleResult = new BaseResult();

    if($args['MODULE']){

        $module = json_decode($moduleJson = stripslashes($args['MODULE']), true);

        //print_r($module);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $module = [];
            echo 'Ошибка декодирования JSON: ' . json_last_error_msg();
            return;
        }

        $moduleCode = $module['moduleCode'];
        
        $components = $module['components'];
    }

    $order_page = get_page_by_path('order');

    $order_page_id = $order_page->ID;
?>

<form class="order-item-facade-configurator-form d-flex flex-column align-items-start justify-content-start gap-2 m-0 w-100" id = "order-item-facade-configurator-form"
    data-ajax-default-content-updater="refresh">

    <input type="hidden" id="BLOCKED_ELEMENT" name="BLOCKED_ELEMENT" value="#catalog-oder-content-conteiner">
    <input type="hidden" id="TEMPLATE_PART" name="TEMPLATE_PART" value="parts/catalog/orders/facade-configurator-action/template">
    <input type="hidden" id="action" name="action" value="default_content_updater">
    <input type="hidden" id="TARGET_CONTEINER" name="TARGET_CONTEINER" value="#catalog-order-item-list">
    <?/*<input type="hidden" id="DEPENDENT_FORM" name="DEPENDENT_FORM" value="#">*/?>
    <input type="hidden" value="<?=$moduleCode?>" name="MODULE_CODE" id = "order-item-configurator-module-code"/>

    <p class="specification-title black p-1">Конфигуратор</p>

    <ul class="facade-configurator-component-list d-flex flex-column gap-1 w-100 white-background rounded p-4">

        <li class="button-conteiner d-flex w-100">

            <div class="save-button col-8 pe-2">

                <button type="submit" class="btn btn-primary w-100">Сохранить</button>

            </div>

            <button type="button" class="btn btn-primary col-4" id = "order-item-facade-configurator-clear"
                data-bs-deactivate-element=".<?=esc_attr($args['ACTIVATE_ELEMENT_GROUP'])?>" 
                >Отмена</button>

        </li>

        <li class="parameter-item-active d-flex align-items-center w-100 gap6justify-content-start gap6">

            <input class="custom-checkbox border-primary pointer" name = "HINGE" type="checkbox" id="order-item-configurator-hinge">
            <span class="checkbox_label">отверстие под петли</span>
                
        </li>
    
        <li class="facade-configurator-membrane combobox-conteiner d-flex flex-column w-100 m-0">

            <?
            $membraneCode = get_field('membrane', $order_page_id);

            if($components)
            {
                $currentComponents = array_filter($components, function($item) use ($membraneCode)
                    {
                        return $item['componentTypeCode'] === $membraneCode;
                    }
                );

                $currentComponent = reset($currentComponents);
            }

            $Result = new BaseResult();

            $componentProvider = new ComponentProvider($componentServiceUrl);

            $Result = $componentProvider->GetComponentsByType($membraneCode);

            if(!$Result->isSuccess())
            {?>
                <p><?=$Result->ErrorMessage?></p>
                <?return;
            }

            $membranes = $Result->data;
            ?>

            <input type="text" value="<?= empty($currentComponents) ? "" : $currentComponent['componentCode']?>" class="membrane w-100 d-none" name="MEMBRANE" id = "order-item-configurator-membrane"/>

            <label for="membrane-combobox" class="membrane-combobox-label dark fw-bold p-1  m-0">пленка</label>

            <select class="configurator-combobox" id="membrane-combobox">

                <option value="0"></option>

                <?foreach ($membranes as $membrane) {?>

                    <option value="<?= esc_attr($membrane['componentCode']) ?>" 

                        <?= (!empty($currentComponent) && $membrane['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                        <?= $membrane['componentTitle'] ?>

                    </option>

                <?}?>

            </select>

        </li>

        <li class="facade-configurator-height d-flex flex-column w-100 m-0">
            
            <?if($module)
            {
                $height = array_filter($module['moduleNumericParameters'], function($item)
                    {
                        return $item['type'] === "Высота";
                    }
                );
            }?>

            <label for="order-item-configurator-height" class = "dark fw-bold p-1">высота</label>
            <input type="number" step="0.5" min="0" max="2000" value="<?= !empty($height)? $height[0]['value']: ''?>" class="height w-100" name="HEIGHT" id = "order-item-configurator-height"/>

        </li>

        <li class="facade-configurator-width d-flex flex-column w-100 m-0">
            
            <?if($module)
            {
                $width = array_filter($module['moduleNumericParameters'], function($item)
                    {
                        return $item['type'] === "Ширина";
                    }
                );

            }?>

            <label for="order-item-configurator-width" class = "dark fw-bold p-1">ширина</label>
            <input type="number" step="0.5" min="0" max="2000" value="<?= !empty($width)? $width[0]['value']: ''?>" class="width w-100" name="WIDTH" id = "order-item-configurator-width"/>

        </li>

        <li class="facade-configurator-quantity d-flex flex-column w-100 m-0">
            
            <label for="order-item-configurator-quantity" class = "dark fw-bold p-1">количество</label>
            <input type="number" step="1" min="0" max="2000" value="<?= $args['QUANTITY'] ? esc_html($args['QUANTITY']) : '' ?>" class="w-100" name="QUANTITY" id = "order-item-configurator-quantity"/>

        </li>

        <li class="facade-configurator-board combobox-conteiner d-flex flex-column w-100 m-0">

            <?
                $boardCode = get_field('board', $order_page_id);

                if($components)
                {
                    $currentComponents = array_filter($components, function($item) use ($boardCode)
                        {
                            return $item['componentTypeCode'] === $boardCode;
                        }
                    );

                    $currentComponent = reset($currentComponents);
                }

                $Result =  $componentProvider->GetComponentsByType($boardCode);

                if(!$Result->isSuccess())
                {?>
                    <p><?=$Result->ErrorMessage?></p>
                    <?return;
                }
    
                $boards = $Result->data;
            ?>

            <input type="text" value="<?= !empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input board w-100 d-none" name="BOARD" id = "order-item-configurator-board"/>

            <label for="board-combobox m-0" class="combobox-label dark fw-bold p-1">плита</label>

            <select class="combobox configurator-combobox" id="board-combobox">

                <option value="0"></option>

                <?foreach ($boards as $board) {?>
                    
                    <option value="<?= esc_attr($board['componentCode']) ?>" 

                        <?= (!empty($currentComponent) && $board['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                        <?= $board['componentTitle'] ?>

                    </option>

                <?}?>
            
            </select>

        </li>
        
        <li class="facade-configurator-corner combobox-conteiner d-flex flex-column w-100 m-0">

            <?
                $cornerCode = get_field('corner', $order_page_id);

                if($components)
                {
                    $currentComponents = array_filter($components, function($item) use ($cornerCode)
                        {
                            return $item['componentTypeCode'] === $cornerCode;
                        }
                    );

                    $currentComponent = reset($currentComponents);
                }

                $Result =  $componentProvider->GetComponentsByType($cornerCode);

                if(!$Result->isSuccess())
                {?>
                    <p><?=$Result->ErrorMessage?></p>
                    <?return;
                }
    
                $corners = $Result->data;
            ?>

            <input type="text" value="<?= !empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner w-100 d-none" name="CORNER" id = "order-item-configurator-corner"/>
            <label for="corner-combobox m-0" class="combobox-label dark fw-bold p-1">кромка фасада</label>

            <select class="combobox configurator-combobox" id="corner-combobox">

                <option value="0"></option>

                <?foreach ($corners as $corner) {?>
                    
                    <option value="<?= esc_attr($corner['componentCode']) ?>" 

                        <?= (!empty($currentComponent) && $corner['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                        <?= $corner['componentTitle'] ?>

                    </option>

                <?}?>
            
            </select>

        </li>

        <li class="facade-configurator-corner-collapse p-2 ps-4 pe-4 rounded border">
            
            <div class="d-flex align-items-center collapse-btn  collapsed w-100 d-flex align-items-center justify-content-center p-0" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#corner-collapse-content"
                data-bs-custom-toggle="tooltip" 
                title="Свернуть">
                <i class="bi bi-chevron-down collapse-icon transition-all"></i>
            </div>
            
            <ul class="collapse transition-all order-item-message-list flex-column gap-1 w-100 white-background" id="corner-collapse-content">

                <div class="order-item-new-message-panel d-flex w-100 m-0">
                    
                    <ul class="d-flex flex-column w-100 gap-1" id = "123">

                        <li class="facade-configurator-corner-top combobox-conteiner d-flex flex-column w-100 m-0">

                        <?
                        $cornerTopCode = get_field('corner-top', $order_page_id);

                        //print_r($cornerTopCode);

                        if($components)
                        {
                            $currentTopComponents = array_filter($components, function($item) use ($cornerTopCode)
                                {
                                    return $item['componentTypeCode'] === $cornerTopCode;
                                }
                            );

                            $currentComponent = reset($currentTopComponents);
                        }

                        $Result =  $componentProvider->GetComponentsByType($cornerTopCode);

                        if(!$Result->isSuccess())
                        {?>
                            <p><?=$Result->ErrorMessage?></p>
                            <?return;
                        }
            
                        $corners = $Result->data;
                        ?>

                            <input type="text" value="<?= !empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-top w-100 d-none" name="CORNER-TOP" id = "order-item-configurator-corner-top"/>
                            <label for="corner-combobox m-0" class="combobox-label dark fw-bold p-1">верх</label>

                            <select class="combobox configurator-combobox" id="corner-top-combobox">

                                <option value="0"></option>

                                <?foreach ($corners as $corner) {?>
                                    
                                    <option value="<?= esc_attr($corner['componentCode']) ?>" 

                                        <?= (!empty($currentComponent) && $corner['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                                        <?= $corner['componentTitle'] ?>

                                    </option>

                                <?}?>
                            
                            </select>

                        </li>
                        
                        <li class="facade-configurator-corner-bottom combobox-conteiner d-flex flex-column w-100 m-0">
                            
                        <?
                        $cornerBottomCode = get_field('corner-bottom', $order_page_id);

                        //print_r($components);

                        if($components)
                        {
                            $currentBottomComponents = array_filter($components, function($item) use ($cornerBottomCode)
                                {
                                    return $item['componentTypeCode'] === $cornerBottomCode;
                                }
                            );

                            $currentComponent = reset($currentBottomComponents);
                        }

                        $Result =  $componentProvider->GetComponentsByType($cornerBottomCode);

                        if(!$Result->isSuccess())
                        {?>
                            <p><?=$Result->ErrorMessage?></p>
                            <?return;
                        }
            
                        $corners = $Result->data;
                        ?>

                            <input type="text" value="<?= !empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-bottom w-100 d-none" name="CORNER-BOTTOM" id = "order-item-configurator-corner-bottom"/>
                            <label for="corner-combobox m-0" class="combobox-label dark fw-bold p-1">низ</label>

                            <select class="combobox configurator-combobox" id="corner-bottom-combobox">

                                <option value="0"></option>

                                <?foreach ($corners as $corner) {?>
                                    
                                    <option value="<?= esc_attr($corner['componentCode']) ?>" 

                                        <?= (!empty($currentComponent) && $corner['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                                        <?= $corner['componentTitle'] ?>

                                    </option>

                                <?}?>

                            </select>

                        </li>

                        <li class="facade-configurator-corner-left combobox-conteiner d-flex flex-column w-100 m-0">
                            
                            <?
                            $cornerLeftCode = get_field('corner-left', $order_page_id);

                            //print_r($cornerTopCode);

                            if($components)
                            {
                                $currentLeftComponents = array_filter($components, function($item) use ($cornerLeftCode)
                                    {
                                        return $item['componentTypeCode'] === $cornerLeftCode;
                                    }
                                );

                                $currentComponent = reset($currentLeftComponents);
                            }

                            $Result =  $componentProvider->GetComponentsByType($cornerLeftCode);

                            if(!$Result->isSuccess())
                            {?>
                                <p><?=$Result->ErrorMessage?></p>
                                <?return;
                            }
                
                            $corners = $Result->data;
                            ?>
                        
                            <input type="text" value="<?= !empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-left w-100 d-none" name="CORNER-LEFT" id = "order-item-configurator-corner-left"/>
                            <label for="corner-combobox m-0" class="combobox-label dark fw-bold p-1">лево</label>

                            <select class="combobox configurator-combobox" id="corner-left-combobox">

                                <option value="0"></option>

                                <?foreach ($corners as $corner) {?>
                                    
                                    <option value="<?= esc_attr($corner['componentCode']) ?>" 

                                        <?= (!empty($currentComponent) && $corner['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                                        <?= $corner['componentTitle'] ?>

                                    </option>

                                <?}?>

                            </select>

                        </li>

                        <li class="facade-configurator-corner-right combobox-conteiner d-flex flex-column w-100 m-0">
                            
                            <?
                            $cornerRightCode = get_field('corner-right', $order_page_id);

                            //print_r($cornerTopCode);

                            if($components)
                            {
                                $currentRightComponents = array_filter($components, function($item) use ($cornerRightCode)
                                    {
                                        return $item['componentTypeCode'] === $cornerRightCode;
                                    }
                                );

                                $currentComponent = reset($currentRightComponents);
                            }

                            $Result =  $componentProvider->GetComponentsByType($cornerRightCode);

                            if(!$Result->isSuccess())
                            {?>
                                <p><?=$Result->ErrorMessage?></p>
                                <?return;
                            }
                
                            $corners = $Result->data;
                            ?>
                        
                            <input type="text" value="<?= !empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-right w-100 d-none" name="CORNER-LEFT" id = "order-item-configurator-corner-right"/>
                            <label for="corner-combobox m-0" class="combobox-label dark fw-bold p-1">право</label>

                            <select class="combobox configurator-combobox" id="corner-right-combobox">

                                <option value="0"></option>

                                <?foreach ($corners as $corner) {?>
                                    
                                    <option value="<?= esc_attr($corner['componentCode']) ?>" 

                                        <?= (!empty($currentComponent) && $corner['componentCode'] === $currentComponent['componentCode']) ? 'selected' : ''?>>

                                        <?= $corner['componentTitle'] ?>

                                    </option>

                                <?}?>

                            </select>

                        </li>

                    </ul>

                </div>

            </ul>
        </li>
        
        <li class="facade-configurator-milling combobox-conteiner d-flex flex-column w-100 m-0">

            <?
                $millingCode = get_field('milling', $order_page_id);

                if($components)
                {
                    $currentComponents = array_filter($components, function($item) use ($millingCode)
                        {
                            return $item['componentTypeCode'] === $millingCode;
                        }
                    );

                    $currentMillingComponent = reset($currentComponents);
                }

                $Result =  $componentProvider->GetComponentsByType($millingCode);

                if(!$Result->isSuccess())
                {?>
                    <p><?=$Result->ErrorMessage?></p>
                    <?return;
                }
    
                $millings = $Result->data;
            ?>

            <input type="text" value="<?= !empty($currentMillingComponent) ? "" : $currentMillingComponent['componentCode']?>" class="combobox-input milling w-100 d-none" name="MILLING" id = "order-item-configurator-milling"/>
            
            <label for="milling-combobox" class="combobox-label dark fw-bold p-1 m-0">фрезеровка</label>
            
            <select class="combobox configurator-combobox" id="milling-combobox">

                <option value="0"></option>

                <?foreach ($millings as $milling) {?>
                    
                    <?if(!$milling['isCustom'] && $milling['componentTitle'] !== "Нестандартная"){?>

                        <option value="<?= esc_attr($milling['componentCode']) ?>" 

                            <?= (!empty($currentComponents) && $milling['componentCode'] === $currentMillingComponent['componentCode']) ? 'selected' : ''?>>

                            <?= $milling['componentTitle'] ?>

                        </option>

                    <?}?>

                <?}?>

                <option value="CUSTOM_MILLING"  <?= (!empty($currentComponents) && $currentMillingComponent['isCustom']) ? 'selected' : ''?>>Нестандартная</option>
            
            </select>

        </li>

        <li class="facade-configurator-milling-collapse p-2 ps-4 pe-4 rounded border <?= (empty($currentComponents) || !$currentMillingComponent['isCustom']) ? 'd-none' : ''?>" id = "custom-milling-content">

            <div class="d-flex align-items-center collapse-btn  collapsed w-100 d-flex align-items-center justify-content-center p-0" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#milling-collapse-content"
                data-bs-custom-toggle="tooltip" 
                title="Скрыть/Показать прикрепленные чертежи">
                <i class="bi bi-chevron-down collapse-icon transition-all"></i>
            </div>

            <ul class="collapse transition-all order-item-message-list flex-column gap-1 w-100 white-background" id="milling-collapse-content">
                
                <?get_template_part("parts/catalog/orders/facade-configurator-blueprints/template",null,
                    [
                        'COMPONENT' =>  $currentMillingComponent
                    ]);?>

            </ul>
        </li>
        
    </ul>
</form>