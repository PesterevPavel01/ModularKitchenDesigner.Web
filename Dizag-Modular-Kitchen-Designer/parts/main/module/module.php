<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/module/ModuleLoaderProcessor.php';

global $ApiUrl;

$moduleTypeTitle = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

if($moduleTypeTitle){
    
    $Result = new BaseResult();
    $MaterialLoaderProcessor = new ModuleLoaderProcessor($ApiUrl);
    $Result = $MaterialLoaderProcessor->Process($moduleTypeTitle);
    if($Result->isSuccess())
    {
    ?>
    <section class="section-modules">
        <?get_template_part("parts/main/titles/section-title",null,
                [
                    'PREFIX' => $args['PARAMETER'],
                    'TEXT' => 'Модуль'
                ]);?>
                
        <div class="modules-list-container">
            <?foreach($Result->data as $item)
            {?>   
            <div class="block-module-list">
            <ul class="modules-container flex-column">
                    <li>
                        <h5 class="module-code middle-font"><?=$item['code']?></h5>
                    </li>
                    <li>
                        <p class="module-title black mini-font"><?=$item['title']?></p>
                    </li>
                    <li class = "flex-row-center">
                        <p class="mini-font">Ширина: </p>
                        <p class="black mini-font"><?=$item['width']?></p>
                    </li>
                    <li class="scale_image_parent">
                        <img src="<?= theme_image($item['previewImageSrc'],true)?>" alt="" class="module-image scale">
                    </li>
                    <li class = "quantity flex-row">
                        <p>Количество: </p>
                        <input type="number" step="1" min="0" max="100" value="0" id="quantity" name="quantity"/>
                    </li>
                </ul>
            </div>
            <? 
            };
            ?>
        </div>
    </section>
    <?
    }else{
    ?>
        <p class="error-message">Не удалось получить данные</p>
    <?
    }
}?>