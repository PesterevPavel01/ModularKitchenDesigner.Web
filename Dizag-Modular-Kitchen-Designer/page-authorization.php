<?
 get_header();
?>
<header>

    <?get_template_part("parts/navigation/preloader");?>

</header>

<main>

    <?get_template_part("parts/navigation/navbar");?>

    <section class="section-content flex-column gap40">

    <?if (is_user_logged_in()) {?>

        <p class="black">Вы авторизованы!</p>
        <a class="flex-column white" href="<?= wp_logout_url( get_site_url() . "/authorization/") ?>">
            <div class = "custom-btn black ajax-update-button" id = "permission-request-btn" type="submit">ВЫХОД</div>
        </a>

    <?}else
    {?>

        <? the_content();?>

    <?}?>

    </section>

</main>

<?php get_footer();?>