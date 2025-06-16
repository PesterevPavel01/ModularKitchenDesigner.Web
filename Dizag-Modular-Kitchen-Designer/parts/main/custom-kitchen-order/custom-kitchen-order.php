<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/kitchen-type/KitchenTypeLoaderProcessor.php';
require_once get_template_directory() . '/core/services/processors/customKitchen/CustomKitchenLoaderProcessor.php';
require_once get_template_directory() . '/core/services/processors/section/SectionCreatorProcessor.php';
require_once get_template_directory() . '/core/services/processors/materialSpecification/MaterialSpecificationCreatorProcessor.php';
require_once get_template_directory() . '/core/services/processors/kitchen/KitchenCreatorProcessor.php';
require_once get_template_directory() . '/core/validators/CustomKitchenParameterValidator.php';

global $ApiUrl;

/*Array 
( 
    [PARAMETER] => 
        Array 
        ( 
            [KITCHEN_TYPE_CODE] => 00080200313 
            [SECTIONS] => Array 
            ( 
                [0] => Array 
                ( 
                    [moduleCode] => 00080202266 
                    [quantity] => 2 
                ) 
                [1] => Array 
                ( 
                    [moduleCode] => 00080202229 
                    [quantity] => 2 
                ) 
            ) 
            [MATERIALS] => Array 
            ( 
                [TOP] => Array
                (
                    [TITLE] => 'ВЕРХНИЕ'
                    [VALUE] =>Array 
                    ( 
                        [TITLE] => МДФ Мокко металлик 
                        [CODE] => c5a0874e-d722-4e90-bdc4-938fcdace3bc 
                    ) 
                )
                [BOTTOM] => 
                    [TITLE] => 'НИЖНИЕ'
                    [VALUE] =>Array 
                    ( 
                        [TITLE] => ЛДСП Дуб кендал натуральный 
                        [CODE] => 50061b68-1bcf-45ac-b0b4-0ffe77c5ef2f 
                    )
            ) 
        )   
) 
*/

$CustomKitchenParameterValidator = new CustomKitchenParameterValidator();
$ValidationResult = new BaseResult();

if(isset($args['PARAMETER']) || !empty($args['PARAMETER']))
{
    $ValidationResult = $CustomKitchenParameterValidator->Validate($args['PARAMETER']);

    if(!$ValidationResult->isSuccess())
    {?>
        <p class="error-message"><?=$ValidationResult->ErrorMessage?></p>
        <?return;
    }
}
else 
{
    return;
}

$materialsTop = $args['PARAMETER']['MATERIALS']['TOP'];
$materialsBottom = $args['PARAMETER']['MATERIALS']['BOTTOM'];

$Result = new BaseResult();
$KitchenTypeProcessor = new KitchenTypeLoaderProcessor($ApiUrl);
$Result = $KitchenTypeProcessor->GetByCode($args['PARAMETER']['KITCHEN_TYPE_CODE']);

if(!$Result->isSuccess())
{
    ?>
    <p class="error-message"><?=$Result->ErrorMessage?></p>
    <?
}

$current_user = wp_get_current_user();
$user_login = $current_user->user_login;
$user_id = $current_user->ID;
$body = 
[
    [
        'userLogin' => $user_login,
        'userId' => (string)$user_id,
        'kitchenType' => $Result->data[0]['title']
    ]
];
    
$KitchenProcessor = new KitchenCreatorProcessor($ApiUrl);
$Result = $KitchenProcessor->Process($body); 

if(!$Result->isSuccess())
{
    ?>
    <p class="error-message"><?=$Result->ErrorMessage?></p>
    <?
}

$kitchenCode = $Result->data[0]['code'];

$MaterialSpecificationCreatorProcessor = new MaterialSpecificationCreatorProcessor($ApiUrl);

$MaterialSpecificationBody = 
[
    [
        'moduleType' => $materialsTop['TITLE'],
        'materialSelectionItemCode' => $materialsTop['VALUE']['CODE'],
        'kitchenCode' => $kitchenCode,
    ],
    [
        'moduleType' => $materialsBottom['TITLE'],
        'materialSelectionItemCode' => $materialsBottom['VALUE']['CODE'],
        'kitchenCode' => $kitchenCode,
    ]
];

$MaterialSpecificationResult = $MaterialSpecificationCreatorProcessor->Process($MaterialSpecificationBody);   

if(!$MaterialSpecificationResult->isSuccess())
{
    ?>
    <p class="error-message"><?=$MaterialSpecificationResult->ErrorMessage?></p>
    <?
}

$SectionCreatorProcessor = new SectionCreatorProcessor($ApiUrl);

foreach ($args['PARAMETER']['SECTIONS'] as $section) {
    $sectionsBody[] = [
        'quantity' => $section['quantity'],
        'moduleCode' => $section['moduleCode'],
        'kitchenCode' => $kitchenCode
    ];
}

$SectionResult = $SectionCreatorProcessor->Process($sectionsBody);

$CustomKitchenProcessor = new CustomKitchenLoaderProcessor($ApiUrl);
$CustomKitchenResult = new BaseResult();
$CustomKitchenResult = $CustomKitchenProcessor->GetByCode($kitchenCode);

if($CustomKitchenResult->isSuccess())
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
    <p class="error-message"><?=$CustomKitchenResult->ErrorMessage?></p>
<?
}
?>


