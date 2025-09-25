<section class="flex-column gap10">
    <p class="black"><?=$args['ERROR_MESSAGE']?></p>
    <a class="flex-column dark-red large-font" href="<?= wp_logout_url( get_site_url() . "/authorization/") ?>">АВТОРИЗОВАТЬСЯ</a>
</section>