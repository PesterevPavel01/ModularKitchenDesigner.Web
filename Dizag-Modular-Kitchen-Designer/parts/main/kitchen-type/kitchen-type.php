<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/kitchen-type/KitchenTypeLoaderProcessor.php';

global $ApiUrl;


$priceSegment = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($priceSegment){
    
    $args['PARAMETERS']['ACTION'] = 'content_update';
    $args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE'] = 'parts/main/custom-kitchen-order/custom-kitchen-order';
    $args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS'] = 'custom-kitchen-order-section';

    $Result = new BaseResult();
    $KitchenTypeLoaderProcessor = new KitchenTypeLoaderProcessor($ApiUrl);
    $Result = $KitchenTypeLoaderProcessor->GetByPriceSegmentTitle($priceSegment);

    if($Result->isSuccess())
    {
    ?>
        <block class="kitchen-type flex-column-start">
        <?get_template_part("parts/main/titles/section-title",null,
            [
                'PREFIX' => 'Модульные',
                'TEXT' => 'Кухни'
            ]);?>
            <ul class="kitchen-type-list flex-column-start ajax-update-trigger">
                <input type="hidden" id="action" value=<?=$args["ACTION"]?>>
                <input type="hidden" id="template_part_to_update" value=<?=$args["TEMPLATE_PART_TO_UPDATE"]?>>
                <input type="hidden" id="html_block_to_update" value=<?=$args['HTML_BLOCK_TO_UPDATE_CLASS']?>>
                <input type="hidden" id="sub-action" value=<?=$args['PARAMETERS']['ACTION']?>>
                <input type="hidden" id="sub_template_part_to_update" value=<?=$args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE']?>>
                <input type="hidden" id="sub_html_block_to_update" value=<?=$args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS']?>>
                
                <?foreach ($Result->data as $item) {?>
                    <li class="kitchen-type-item flex-column-start ajax-update-button" Id = "kitchen-type-<?=$item['code']?>">
                        <input type="hidden" id="value" value=<?=$item['code']?>>
                        <block class="flex-row gap10">
                            <?$item['previewImageSrc'] = 'kitchen_preview_image.png'?>
                            <img class="height-100px" src="<?= theme_image($item['previewImageSrc'],true)?>">
                            <block class="flex-column">
                                <h5 class="kitchen-type-item-content middle-font code"><?=$item['code']?></h5>
                                <p class="kitchen-type-item-content black"><?=$item['title']?></p> 
                            </block>
                        </block>
                    </li>
                <?}?>
            </ul>
        </block>


    <section class="material-items-section flex-column-start gap20" id = 'material-items-section'>
    <?get_template_part("parts/main/material/material",null,
            [
                'ACTION' => $args['PARAMETERS']['ACTION'],
                'PARAMETER' =>  $args['PARAMETERS']['PARAMETER'],
                'TEMPLATE_PART_TO_UPDATE' => $args['PARAMETERS']["TEMPLATE_PART_TO_UPDATE"],
                'HTML_BLOCK_TO_UPDATE_CLASS' => $args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS'],
            ]);?>
    </section>
    <?
    }else{
    ?>
        <p class="error-message">Не удалось получить данные</p>
<?
    }
}
?>


