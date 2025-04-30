<?php get_header(); ?>
<header>
    <?get_template_part("parts/navigation/preloader")?>
    <?get_template_part("parts/navigation/navbar")?>
</header>
<main>
    <?//get_template_part("parts/navigation/popup")?>
    <section class="section-content flex-column gap40">
        <?get_template_part("parts/main/module/module",null,
            [
                'PARAMETER' => "Верхний",
            ]);?>

        <?get_template_part("parts/main/module/module",null,
            [
                'PARAMETER' => "Нижний",
            ]);?>

        <?get_template_part("parts/main/price-segment/price-segment",null,
            [
                'ACTION' => 'content_update',
                'PARAMETER' =>  null, //в этом блоке он не нужен
                'TEMPLATE_PART_TO_UPDATE' => "parts/main/kitchen-type/kitchen-type",
                'HTML_BLOCK_TO_UPDATE_CLASS' => 'kitchen-type-section',
                'PARAMETERS' =>
                [
                    'ACTION' => 'content_update',
                    'PARAMETER' =>  null,
                    'TEMPLATE_PART_TO_UPDATE' => "parts/main/material/material",
                    'HTML_BLOCK_TO_UPDATE_CLASS' => 'material-items-section',
                ]
            ]);?>
        <section class="kitchen-type-section flex-column-start"  id = 'kitchen-type-section'>
            <?get_template_part("parts/main/kitchen-type/kitchen-type",null,
                [
                    'ACTION' => 'content_update',
                    'PARAMETER' =>  null,
                    'TEMPLATE_PART_TO_UPDATE' => "parts/main/material/material",
                    'HTML_BLOCK_TO_UPDATE_CLASS' => 'material-items-section',
                ]);?>
        </section>
    </section>
    <??>
</main>

<?php get_footer();?>