<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/material/MaterialLoaderProcessor.php';

global $ApiUrl;



$kitchenTypeCode = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($kitchenTypeCode){
    
    $args['PARAMETERS']['ACTION'] = 'content_update';
    $args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE'] = 'parts/main/custom-kitchen-order/custom-kitchen-order';
    $args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS'] = 'custom-kitchen-order-section';

    $Result = new BaseResult();
    $MaterialLoaderProcessor = new MaterialLoaderProcessor($ApiUrl);
    $Result = $MaterialLoaderProcessor->GetByKitchenTypeCode($kitchenTypeCode);

    if($Result->isSuccess())
    {
    ?>
        <block class="block-material">
            <h6 class="block-material-title">Материалы:</h6>
            <ul class="block-material-list flex-column-start">
            <?foreach ($Result->data as $item) {?>
                <li class="block-material-item flex-row-start">
                    <p class="block-material-item-content code"><?=$item['componentType'] . " (" . $item['moduleType'] . " ряд) "?></p>
                    <p>: </p>
                    <p class="block-material-item-content"><?=$item['material']?></p> 
                </li>
            <?}?>
            </ul>
        </block>

        <block class="create-custom-order-btn">
            <input type="hidden" id="action" value=<?=$args['PARAMETERS']['ACTION']?>>
            <input type="hidden" id="template_part_to_update" value=<?=$args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE']?>>
            <input type="hidden" id="html_block_to_update" value=<?=$args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS']?>>
            <input type="hidden" id="custom-order-kitchen-code" value=<?=$args['PARAMETER']?>>
            <div class="custom-btn black" id="create-custom-order-button">Расчитать</div>
        </block>
        
        <section class="custom-kitchen-order-section flex-column-start">
            <?get_template_part("parts/main/custom-kitchen-order/custom-kitchen-order",null,
            [
                'PARAMETER' => [
                    'KITCHEN_TYPE_CODE' => null ,
                    'SECTIONS' => [
                        [
                            'moduleCode' => '00080202238',
                            'quantity' => 1
                        ] ,
                        [
                            'moduleCode' => '00080202238',
                            'quantity' => 1
                        ] 
                    ]
                ]
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