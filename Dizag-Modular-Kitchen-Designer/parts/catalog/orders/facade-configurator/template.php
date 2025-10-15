<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-facade-configurator");
?>

<?
$arParams = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

//print_r($arParams);
?>
<section class="order-item-facade-configurator-section flex-column align-items-start justify-content-start gap-2 m-0 w-100">
    
    <p class="specification-title black p-1">Конфигуратор</p>

    <ul class="facade-configurator-component-list flex-column gap-1 w-100">

        <li class="facade-configurator-board d-flex w-100 m-0 p-3 white-background">
            
            <ul class="facade-configurator-component-content d-flex align-items-center justify-content-start gap-1 m-0 w-100" id = "123">

                <li class="component-information-block d-flex w-100 align-items-center gap-2">
                    <img src="<?= theme_image("board-icon",true,'/assets/img/icons/')?>" alt="" class="">
                    <span class="order-item-specification-label w-100 black">Плита</span>
                </li>

                <li class="component-panel-controls d-flex w-100 align-items-end">
                    <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
                        <button class="btn btn-primary">Добавить</button>
                    </div>
                </li>

            </ul>

        </li>

        <li class="facade-configurator-tape d-flex w-100 m-0 p-3 white-background">
            
            <ul class="facade-configurator-component-content d-flex align-items-center justify-content-start gap-1 m-0 w-100" id = "123">

                <li class="component-information-block d-flex w-100 align-items-center gap-2">
                    <img src="<?= theme_image("tape-icon",true,'/assets/img/icons/')?>" alt="" class="">
                    <span class="order-item-specification-label w-100 black">Пленка</span>
                </li>

                <li class="component-panel-controls d-flex w-100 align-items-end">
                    <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
                        <button class="btn btn-primary">Добавить</button>
                    </div>
                </li>

            </ul>

        </li>

        <li class="facade-configurator-component d-flex w-100 m-0 p-3 white-background">
            
            <ul class="facade-configurator-component-content d-flex align-items-center justify-content-start gap-1 m-0 w-100" id = "123">

                <li class="component-information-block d-flex w-100 align-items-center gap-2">
                    <img src="<?= theme_image("milling-icon",true,'/assets/img/icons/')?>" alt="" class="">
                    <span class="order-item-specification-label w-100 black">Фрезеровка</span>
                </li>

                <li class="component-panel-controls d-flex w-100 align-items-end">
                    <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
                        <button class="btn btn-primary">Добавить</button>
                    </div>
                </li>

            </ul>

        </li>

        <li class="facade-configurator-component d-flex w-100 m-0 p-3 white-background">
            
            <ul class="facade-configurator-component-content d-flex align-items-center justify-content-start gap-1 m-0 w-100" id = "123">

                <li class="component-information-block d-flex w-100 align-items-center gap-2">
                    <img src="<?= theme_image("corner-icon",true,'/assets/img/icons/')?>" alt="" class="">
                    <span class="order-item-specification-label w-100 black">Торец</span>
                </li>

                <li class="component-panel-controls d-flex w-100 align-items-end">
                    <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
                        <button class="btn btn-primary">Добавить</button>
                    </div>
                </li>

            </ul>

        </li>

        <li class="facade-configurator-component d-flex w-100 m-0 p-3 white-background">
            
            <ul class="facade-configurator-component-content d-flex align-items-center justify-content-start gap-1 m-0 w-100" id = "123">

                <li class="component-information-block d-flex w-100 align-items-center gap-2">
                    <img src="<?= theme_image("image-icon",true,'/assets/img/icons/')?>" alt="" class="">
                    <span class="order-item-specification-label w-100 black">Чертёж</span>
                </li>

                <li class="component-panel-controls d-flex w-100 align-items-end">
                    <div class="d-flex flex-column w-100 justify-content-end align-items-center gap-1 flex-xl-row">
                        <button class="btn btn-primary">Добавить</button>
                    </div>
                </li>

            </ul>

        </li>

    </ul>
</section>