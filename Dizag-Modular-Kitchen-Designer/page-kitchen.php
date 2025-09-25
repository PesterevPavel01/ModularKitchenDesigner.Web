<?php 
 get_header();
?>
<header>
    <?get_template_part("parts/navigation/preloader")?>
</header>

<?php the_content(); ?>

<main>
    
    <?get_template_part("parts/navigation/navbar")?>

    <section class="section-content white-background flex-column gap40">
    
    <? if(is_user_logged_in()){?>

        <?get_template_part("parts/main/module/module",null,
            [
                'PARAMETER' => "ВЕРХНИЕ",
            ]);?>

        <?get_template_part("parts/main/module/module",null,
            [
                'PARAMETER' => "НИЖНИЕ",
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
            
        <section class="kitchen-type-section flex-column-start gap40"  id = 'kitchen-type-section'>
            <?get_template_part("parts/main/kitchen-type/kitchen-type",null,
                [
                    'ACTION' => 'content_update',
                    'PARAMETER' =>  null,
                    'TEMPLATE_PART_TO_UPDATE' => "parts/main/material/material",
                    'HTML_BLOCK_TO_UPDATE_CLASS' => 'material-items-section',
                ]);?>
        </section>

    <?}
    else{
        get_template_part("parts/navigation/authorization",null,
        [
            'ERROR_MESSAGE' => "Для работы с колькулятором необходимо",
        ]);
    }
    ?>
    </section>
</main>

<?php get_footer();?>