<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/orders/CustomKitchenProcessor.php';

global $ApiUrl;

if(isset($args['PARAMETER']['KITCHEN_TYPE_CODE']) && isset($args['PARAMETER']['SECTIONS'])){
    
    if($args['PARAMETER']['SECTIONS'] != null)
    {
        $body = [
            'kitchenTypeCode' => $args['PARAMETER']['KITCHEN_TYPE_CODE'],
            'sections' => $args['PARAMETER']['SECTIONS']
        ];

        $Result = new BaseResult();
        $CustomKitchenProcessor = new CustomKitchenProcessor($ApiUrl);
        $Result = $CustomKitchenProcessor->Process($body);

        if($Result->isSuccess())
        {
            $item = $Result->data;
            $price = number_format((float)$item['price'],2,',',' ');
            $width = number_format((float)$item['width'],1,',',' ');
        ?>
            <block class="custom-kitchen-order flex-column-start gap20">
            <?get_template_part("parts/main/titles/section-title",null,
                [
                    'PREFIX' => 'Параметры',
                    'TEXT' => 'Кухни'
                ]);?>
                <ul class="flex-column-start gap20">
                    <li class="flex-column-start order-value">
                        <p class="order-value-content black">
                            <span>
                                Стоимость, руб :
                            </span> 
                            <?=$price?>
                        </p> 
                    </li>
                    <li class="flex-column-start order-value">
                        <p class="order-value-content black">
                            <span>
                                Ширина, мм :
                            </span> 
                            <?=$width?>
                        </p> 
                    </li>
                </ul>
            </block>
        <?
        }else{
        ?>
            <p class="error-message"><?=$Result->data?></p>
        <?
        }
    }
}
?>


