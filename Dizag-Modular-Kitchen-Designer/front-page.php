<?php 
 get_header();
?>
<header>
    <?get_template_part("parts/navigation/preloader")?>
    <?get_template_part("parts/navigation/navbar")?>
</header>

<?php the_content(); ?>

<main>
    //get_template_part("parts/navigation/popup")
    <section class="section-content flex-column gap40">
    
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
        ?>
        <section class="flex-column gap10">
            <p class="black">Для работы с колькулятором необходимо</p>
            <a class="flex-column dark-red large-font" href="<?= wp_logout_url( get_site_url() . "/autorization/") ?>">АВТОРИЗОВАТЬСЯ</a>
        </section>
        <?
    }
    ?>
    </section>
</main>

<?php get_footer();?>