<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/material/MaterialLoaderProcessor.php';
require_once get_template_directory() . '/core/services/processors/module/ModuleTypeLoaderProcessor.php';

global $ApiUrl;

$kitchenTypeCode = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($kitchenTypeCode){
    
    $args['PARAMETERS']['ACTION'] = 'content_update';
    $args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE'] = 'parts/main/custom-kitchen-order/custom-kitchen-order';
    $args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS'] = 'custom-kitchen-order-section';



    $ModuleTypeResult = new BaseResult();
    $ModuleTypeLoaderProcessor = new ModuleTypeLoaderProcessor($ApiUrl);
    $ModuleTypeResult = $ModuleTypeLoaderProcessor->Process();

    $ModuleTypeTop = $ModuleTypeResult->data[0]['title'];
    $ModuleTypeBottom = $ModuleTypeResult->data[1]['title'];

    $Result = new BaseResult();
    $MaterialLoaderProcessor = new MaterialLoaderProcessor($ApiUrl);
    $Result = $MaterialLoaderProcessor->GetByKitchenTypeCode($kitchenTypeCode);
    
    if($Result->isSuccess())
    {?>
        <block class="block-material flex-column-start gap20">
            <?get_template_part("parts/main/titles/section-title",null,
                [
                    'PREFIX' => 'Материалы ',
                    'TEXT' => $Result->data[0]['kitchenType']
                ]);?>

            <ul class="block-material-list flex-column-start check-square-list">
                <li class="block-material-item flex-row-start">
                    <p class="block-material-item-content grey">компонент</p>
                    <p class="block-material-item-content grey">материал</p> 
                    <div class="block-material-item-content grey top-title"><?=$ModuleTypeTop?></div>
                    <div class="block-material-item-content grey bottom-title"><?=$ModuleTypeBottom?></div>
                </li>
            <?
            
            foreach ($Result->data as $item) {?>
                <li class="block-material-item flex-row-start">
                    <p class="block-material-item-content"><?=$item['componentType']?></p>
                    <p class="block-material-item-content title"><?=$item['material']?></p> 
                    <input type="hidden" class = 'code' value=<?=$item['code']?>>
                    <div class="block-material-item-content bi bi-square top"></div>
                    <div class="block-material-item-content bi bi-square bottom"></div>
                </li>
                <?}?>
            </ul>
        </block>
        <block class="create-custom-order-btn flex-column-start gap20">
            <input type="hidden" id="action" value=<?=$args['PARAMETERS']['ACTION']?>>
            <input type="hidden" id="template_part_to_update" value=<?=$args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE']?>>
            <input type="hidden" id="html_block_to_update" value=<?=$args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS']?>>
            <input type="hidden" id="custom-order-kitchen-code" value=<?=$args['PARAMETER']?>>
            <div class="custom-btn black" id="create-custom-order-button">Расчитать</div>
        </block>
        
        <??>
        <section class="custom-kitchen-order-section flex-column-start">
            <?get_template_part("parts/main/custom-kitchen-order/custom-kitchen-order",null,
            [
                /*
                'PARAMETER' => [
                    'KITCHEN_TYPE_CODE' => '00080200313',
                    'SECTIONS' => [
                        [
                            'moduleCode' => '00080202266',
                            'quantity' => 2
                        ] ,
                        [
                            'moduleCode' => '00080202229',
                            'quantity' => 1
                        ] 
                    ],
                    'MATERIALS' =>
                    [
                        'TOP' => 
                        [
                            'TITLE' => 'МДФ Мокко металлик',
                            'CODE' => 'c5a0874e-d722-4e90-bdc4-938fcdace3bc'
                        ],
                        'BOTTOM' =>
                        [
                            'TITLE' => 'ЛДСП Дуб кендал натуральный',
                            'CODE' => '50061b68-1bcf-45ac-b0b4-0ffe77c5ef2f'
                        ]
                    ]
                ]
                */
            ]);?>
        </section>
        <??>
    <?
    }else{
    ?>
        <p class="error-message">Не удалось получить данные</p>
    <?
    }
}
?>