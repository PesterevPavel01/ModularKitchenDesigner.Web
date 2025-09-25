<?php 
 get_header();
?>
<header>
    <?get_template_part("parts/navigation/preloader")?>
</header>

<?php the_content(); ?>

<main>
    <?get_template_part("parts/navigation/navbar")?>
    
    <section class="section-content flex-column gap40 mx-width-1380">
    
    <? if(is_user_logged_in()){

        get_template_part("parts/catalog/account/role-content-manager");
        
    }else
    {
        get_template_part("parts/navigation/authorization",null,
        [
            'ERROR_MESSAGE' => "Для получения доступа необходимо",
        ]);
    }?>

    </section>
</main>

<?php get_footer();?>