<?php 
 get_header();
?>
<header>
    <?get_template_part("parts/navigation/preloader")?>
</header>

<?php the_content(); ?>

<main class = "pt-80 mx-width-1380 m-auto">

    <?get_template_part("parts/navigation/navbar")?>

    <?if(is_user_logged_in()){

        get_template_part("parts/catalog/account/role-content-manager");
        
    }else
    {
        get_template_part("parts/navigation/authorization",null,
        [
            'ERROR_MESSAGE' => "Для получения доступа необходимо",
        ]);
    }?>
        
</main>

<?php get_footer();?>