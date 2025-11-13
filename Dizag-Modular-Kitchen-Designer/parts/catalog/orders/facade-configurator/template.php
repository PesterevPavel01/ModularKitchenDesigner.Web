<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-facade-configurator");

require_once get_template_directory() . '/core/services/processors/catalog/modules/ModuleProvider.php';
require_once get_template_directory() . '/core/services/processors/catalog/components/ComponentProvider.php';
require_once get_template_directory() . '/core/Result.php';

global $moduleServiceUrl;
global $componentServiceUrl;
?>

<?
    $moduleCode = "";

    $components = [];

    $module = [];

    $ModuleResult = new BaseResult();

    if(isset($args['MODULE']) && $args['MODULE']){

        if(!is_array($args['MODULE'])){

            $module = json_decode($moduleJson = stripslashes($args['MODULE']), true);

            if (json_last_error() !== JSON_ERROR_NONE) {

                $module = [];

                echo 'Ошибка декодирования JSON: ' . json_last_error_msg();
                
                return;
            }

        }else{

            $module = $args['MODULE'];
        
        }

        $moduleCode = $module['moduleCode'];
        
        $components = $module['components'];
    }

    $order_page = get_page_by_path('order');

    $order_page_id = $order_page->ID;

    $facadeTypeCode = get_field('facade', $order_page_id);

    if(!$facadeTypeCode || trim($facadeTypeCode) === "")
    {?>
        <p>Не указан код типа модуля "Фасад"!</p>
        <?return;
    }
?>
<?
$Result = new BaseResult();

$componentProvider = new ComponentProvider($componentServiceUrl);
?>

<form class="order-item-facade-configurator-form d-flex flex-column align-items-start justify-content-start gap-2 m-0 w-100" id = "order-item-facade-configurator-form"
    data-ajax-default-content-updater="refresh">

    <input type="hidden" data-no-reset="true" name="BLOCKED_ELEMENT" value="#catalog-oder-content-conteiner">
    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/orders/facade-configurator-action/template">
    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#catalog-order-item-list">
    <?//<input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#catalog-order-specification-section">*/?>
    <?/*<input type="hidden" name="DEPENDENT_FORM" value="#">*/?>
    <input type="hidden" value="<?=$moduleCode?>" name="MODULE_CODE" id = "order-item-configurator-module-code"/>
    <input type="hidden" value="<?=$args['ORDER_CODE']?>" data-no-reset="true" name="ORDER_CODE"/>
    <input type="hidden" value="<?= $facadeTypeCode ?>" data-no-reset="true" name="MODULE_TYPE_CODE"/>
    <input type="hidden" value="Фасад" data-no-reset="true" name="MODULE_TYPE"/>

    <p class="specification-title black p-1 m-0">Конфигуратор</p>

    <ul class="facade-configurator-component-list d-flex flex-column gap-1 w-100 white-background rounded p-4 m-0">

        <li class="button-conteiner d-flex w-100">

            <div class="save-button col-8 pe-2">

                <button type="submit" class="btn btn-primary w-100">Сохранить</button>

            </div>

            <button type="button" class="btn btn-primary col-4" id = "order-item-facade-configurator-clear"
                <?//data-bs-deactivate-element - класс, который есть у всех кнопок "редактировать элемент"?>
                data-bs-deactivate-element="<?=isset($args['ACTIVATE_ELEMENT_GROUP']) ? esc_attr($args['ACTIVATE_ELEMENT_GROUP']) : ""?>" 
                >Отмена</button>

        </li>

        <?/*HINGE*/?>

        <li class="facade-configurator-hinge combobox-conteiner d-flex flex-column w-100 m-0">

            <?
                $hingeCode = get_field('hinge', $order_page_id);

                $currentHingeComponent = [];

                if(!empty($components))
                {
                    $currentComponents = array_filter($components, function($item) use ($hingeCode)
                        {
                            return $item['componentTypeCode'] === $hingeCode;
                        }
                    );

                    $currentHingeComponent = reset($currentComponents);
                }

                $Result =  $componentProvider->GetComponentsByType($hingeCode);

                if(!$Result->isSuccess())
                {?>
                    <p><?=$Result->ErrorMessage?></p>
                    <?return;
                }
    
                $hinges = $Result->data;
            ?>

            <input type="text" value="<?= empty($currentHingeComponent) ? "" : esc_html($currentHingeComponent['componentCode'])?>" class="combobox-input hinge w-100 d-none" name="HINGE" id = "order-item-configurator-hinge"/>

            <input type="hidden" data-no-reset="true" value="<?= $hingeCode ?>" name="HINGE_TYPE_CODE"/>

            <label for="hinge-combobox" class="combobox-label dark fw-bold p-1 m-0">петли</label>
            
            <select class="combobox configurator-combobox" id="hinge-combobox">

                <option value="0"></option>

                <?foreach ($hinges as $hinge) {?>
                    
                    <?if(!$hinge['isCustom'] && $hinge['componentTitle'] !== "Нестандартная"){?>

                        <option value="<?= esc_attr($hinge['componentCode']) ?>" 

                            <?= (!empty($currentComponents) && $hinge['componentCode'] === $currentHingeComponent['componentCode']) ? 'selected' : ''?>>

                            <?= $hinge['componentTitle'] ?>

                        </option>

                    <?}?>

                <?}?>

                <option value="CUSTOM_HINGE"  <?= (!empty($currentComponents) && $currentHingeComponent['isCustom']) ? 'selected' : ''?>>Нестандартная</option>
            
            </select>

        </li>
        
        <li class="facade-configurator-hinge-collapse p-2 ps-4 pe-4 rounded border <?= (empty($currentComponents) || !$currentHingeComponent['isCustom']) ? 'd-none' : ''?>" id = "custom-hinge-blueprints-form" data-ajax-default-content-updater="refresh">

            <div class="d-flex align-items-center collapse-btn  collapsed w-100 d-flex align-items-center justify-content-center p-0 m-0" 

                type="button"
                data-bs-toggle="collapse" 
                data-bs-target="#hinge-collapse-content"
                data-bs-custom-toggle="tooltip" 
                title="Скрыть/Показать прикрепленные чертежи">
                
                <i class="bi bi-chevron-down collapse-icon transition-all"></i>

            </div>

            <ul class="collapse transition-all order-item-message-list flex-column gap-1 w-100 white-background p-0" id="hinge-collapse-content">

                <?$isCustom = isset($currentHingeComponent['isCustom']) ? $currentHingeComponent['isCustom'] : false;?>
                
                <?get_template_part("parts/catalog/orders/configurator-blueprints/template",null,
                    [
                        'COMPONENT' =>  (!empty($currentHingeComponent) && $isCustom) ? $currentHingeComponent : null,
                        'COMPONENT_TYPE' => 'hinge'
                    ]);?>

            </ul>

        </li>
    
        <li class="facade-configurator-membrane combobox-conteiner d-flex flex-column w-100 m-0">

            <?
            $membraneCode = get_field('membrane', $order_page_id);

            if(!empty($components))
            {
                $currentComponents = array_filter($components, function($item) use ($membraneCode)
                    {
                        return $item['componentTypeCode'] === $membraneCode;
                    }
                );

                $currentComponent = reset($currentComponents);
            }

            $Result = $componentProvider->GetComponentsByType($membraneCode);

            if(!$Result->isSuccess())
            {?>
                <p><?=$Result->ErrorMessage?></p>
                <?return;
            }

            $membranes = $Result->data;
            ?>

            <input type="text" value="<?= empty($currentComponents) ? "" : $currentComponent['componentCode']?>" class="combobox-input membrane w-100 d-none" name="MEMBRANE" id = "order-item-configurator-membrane"/>
            <input type="hidden" data-no-reset="true" value="<?= $membraneCode ?>" name="MEMBRANE_TYPE_CODE"/>

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

        <li class="facade-configurator-lenght d-flex flex-column w-100 m-0">

            <?if(!empty($module))
            {
                $length = array_filter($module['moduleNumericParameters'], function($item)
                    {
                        return $item['type'] === "Высота";
                    }
                );

                $length = reset($length);
            }?>

            <label for="order-item-configurator-length" class = "dark fw-bold p-1">высота</label>
            <input type="number" step="0.5" min="0" max="2000" value="<?= !empty($length)? esc_html($length['value']): ''?>" class="length w-100" name="LENGTH" id = "order-item-configurator-length"/>

        </li>

        <li class="facade-configurator-width d-flex flex-column w-100 m-0">
            
            <?if(!empty($module))
            {
                $width = array_filter($module['moduleNumericParameters'], function($item)
                    {
                        return $item['type'] === "Ширина";
                    }
                );

                $width = reset($width);

            }?>

            <label for="order-item-configurator-width" class = "dark fw-bold p-1">ширина</label>
            <input type="number" step="0.5" min="0" max="2000" value="<?= !empty($width)? $width['value']: ''?>" class="width w-100" name="WIDTH" id = "order-item-configurator-width"/>

        </li>

        <li class="facade-configurator-quantity d-flex flex-column w-100 m-0">
            
            <label for="order-item-configurator-quantity" class = "dark fw-bold p-1">количество</label>
            <input type="number" step="1" min="0" max="2000" value="<?= $args['QUANTITY'] ? esc_html($args['QUANTITY']) : '' ?>" class="w-100" name="QUANTITY" id = "order-item-configurator-quantity"/>

        </li>

        <li class="facade-configurator-board combobox-conteiner d-flex flex-column w-100 m-0">

            <?
                $boardCode = get_field('board', $order_page_id);

                if(!empty($components))
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

            <input type="text" value="<?= empty($currentComponent) ? "" : esc_html($currentComponent['componentCode'])?>" class="combobox-input board w-100 d-none" name="BOARD" id = "order-item-configurator-board"/>
            <input type="hidden" data-no-reset="true" value="<?= $boardCode ?>" name="BOARD_TYPE_CODE"/>

            <label for="board-combobox" class="combobox-label m-0 dark fw-bold p-1">плита</label>

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

                if(!empty($components))
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

            <input type="text" value="<?= empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner w-100 d-none" name="CORNER" id = "order-item-configurator-corner"/>
            <input type="hidden" data-no-reset="true" value="<?= $cornerCode ?>" name="CORNER_TYPE_CODE"/>

            <label for="corner-combobox" class="combobox-label m-0 dark fw-bold p-1">кромка фасада</label>

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
            
            <ul class="collapse transition-all order-item-message-list flex-column gap-1 w-100 white-background p-0 m-0" id="corner-collapse-content">

                <div class="order-item-new-message-panel d-flex w-100 m-0">
                    
                    <ul class="d-flex flex-column w-100 gap-1 p-0 m-0" id = "123">

                        <li class="facade-configurator-corner-top combobox-conteiner d-flex flex-column w-100 m-0">

                        <?
                        $cornerTopCode = get_field('corner-top', $order_page_id);

                        if(!empty($components))
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

                            <input type="text" value="<?= empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-top w-100 d-none" name="CORNER_TOP" id = "order-item-configurator-corner-top"/>
                            <input type="hidden" data-no-reset="true" value="<?= $cornerTopCode ?>" name="CORNER_TOP_TYPE_CODE"/>

                            <label for="corner-combobox" class="combobox-label m-0 dark fw-bold p-1">верх</label>

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

                        if(!empty($components))
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

                            <input type="text" value="<?= empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-bottom w-100 d-none" name="CORNER_BOTTOM" id = "order-item-configurator-corner-bottom"/>
                            <input type="hidden" data-no-reset="true" value="<?= $cornerBottomCode ?>" name="CORNER_BOTTOM_TYPE_CODE"/>
                            
                            <label for="corner-combobox" class="combobox-label m-0 dark fw-bold p-1">низ</label>

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

                            if(!empty($components))
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
                        
                            <input type="text" value="<?= empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-left w-100 d-none" name="CORNER_LEFT" id = "order-item-configurator-corner-left"/>
                            <input type="hidden" data-no-reset="true" value="<?= $cornerLeftCode ?>" name="CORNER_LEFT_TYPE_CODE"/>
                            
                            <label for="corner-combobox" class="combobox-label m-0 dark fw-bold p-1">лево</label>

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

                            if(!empty($components))
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
                        
                            <input type="text" value="<?= empty($currentComponent) ? "" : $currentComponent['componentCode']?>" class="combobox-input corner-right w-100 d-none" name="CORNER_RIGHT" id = "order-item-configurator-corner-right"/>
                            <input type="hidden" data-no-reset="true" value="<?= $cornerRightCode ?>" name="CORNER_RIGHT_TYPE_CODE"/>
                            
                            <label for="corner-combobox" class="combobox-label m-0 dark fw-bold p-1">право</label>

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

                $currentMillingComponent = [];

                if(!empty($components))
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

            <input type="text" value="<?= empty($currentMillingComponent) ? "" : esc_html($currentMillingComponent['componentCode'])?>" class="combobox-input milling w-100 d-none" name="MILLING" id = "order-item-configurator-milling"/>

            <input type="hidden" data-no-reset="true" value="<?= $millingCode ?>" name="MILLING_TYPE_CODE"/>

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
        
        <li class="facade-configurator-milling-collapse p-2 ps-4 pe-4 rounded border <?= (empty($currentComponents) || !$currentMillingComponent['isCustom']) ? 'd-none' : ''?>" id = "custom-milling-blueprints-form" data-ajax-default-content-updater="refresh">

            <div class="d-flex align-items-center collapse-btn  collapsed w-100 d-flex align-items-center justify-content-center p-0 m-0" 

                type="button"
                data-bs-toggle="collapse" 
                data-bs-target="#milling-collapse-content"
                data-bs-custom-toggle="tooltip" 
                title="Скрыть/Показать прикрепленные чертежи">
                
                <i class="bi bi-chevron-down collapse-icon transition-all"></i>

            </div>

            <ul class="collapse transition-all order-item-message-list flex-column gap-1 w-100 white-background p-0" id="milling-collapse-content">

                <?$isCustom = isset($currentMillingComponent['isCustom']) ? $currentMillingComponent['isCustom'] : false;?>
                
                <?get_template_part("parts/catalog/orders/configurator-blueprints/template",null,
                    [
                        'COMPONENT' =>  (!empty($currentMillingComponent) && $isCustom) ? $currentMillingComponent : null,
                        'COMPONENT_TYPE' => 'milling'
                    ]);?>

            </ul>

        </li>

    </ul>

</form>