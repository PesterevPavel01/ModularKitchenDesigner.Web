<?
 get_header();
?>
<header>

    <?get_template_part("parts/navigation/preloader");?>

</header>

<main>

    <?get_template_part("parts/navigation/navbar");?>

    <section class="section-content flex-column gap40">

    <?if (is_user_logged_in()) {

        wp_redirect(home_url());
        
        exit;?>

    <?}else
    {?>

        <? the_content();?>

    <?}?>

    </section>

</main>

<?php get_footer();?>