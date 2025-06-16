<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/price-segment/PriceSegmentLoaderProcessor.php';

global $ApiUrl;

$PriceSegmentLoaderProcessor = new PriceSegmentLoaderProcessor($ApiUrl);
$Result = new BaseResult();
$Result = $PriceSegmentLoaderProcessor->Process();

if($Result->isSuccess())
{
?>

<section class="price-segment-section">

    <block class="price-segment-list  flex-row">
        <nav class="price-segment-navbar  flex-row">
        
            <?get_template_part("parts/main/titles/section-title",null,
            [
                'PREFIX' => 'Ценовой',
                'TEXT' => 'Сегмент'
            ]);?>

            <ul class="price-segment-navbar-nav flex-row ajax-update-trigger">
                <input type="hidden" id="action" value=<?=$args["ACTION"]?>>
                <input type="hidden" id="sub-action" value=<?=$args['PARAMETERS']['ACTION']?>>
                <input type="hidden" id="template_part_to_update" value=<?=$args["TEMPLATE_PART_TO_UPDATE"]?>>
                <input type="hidden" id="html_block_to_update" value=<?=$args['HTML_BLOCK_TO_UPDATE_CLASS']?>>
                <input type="hidden" id="sub_template_part_to_update" value=<?=$args['PARAMETERS']['TEMPLATE_PART_TO_UPDATE']?>>
                <input type="hidden" id="sub_html_block_to_update" value=<?=$args['PARAMETERS']['HTML_BLOCK_TO_UPDATE_CLASS']?>>
                
                <?foreach ($Result->data as $item) {?>
                    <li class="price-segment-nav-item ajax-update-button" id="price-segment-<?=$item['code']?>">
                        <input type="hidden" id="value" value=<?=$item['title']?>>
                        <input type="hidden" id="sub-value" value=<?null?>>
                        <p class="price-segment-nav-content flex-column medium-font normal-font"><?=$item['title']?></p>
                    </li>
                <?}?>
            
            </ul>
        </nav>
    </block>

</section>

<?}else{?>
    <p class="error-message">Не удалось получить данные</p>
<?}?>