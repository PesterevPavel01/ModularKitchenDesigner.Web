<?php get_header(); ?>
<header>
    <?get_template_part("parts/navigation/preloader")?>
    <?get_template_part("parts/navigation/navbar")?>
</header>
<?
  the_content ();
?>
<?php get_footer();?>