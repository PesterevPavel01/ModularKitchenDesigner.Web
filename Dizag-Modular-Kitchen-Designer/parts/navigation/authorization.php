<section class="flex-column gap10 w-100 d-flex flex-column align-items-center justify-content-center m-0 p-o">
    <p class="black text-center m-0 p-o"><?=$args['ERROR_MESSAGE']?></p>
    <a class="flex-column dark-red large-font text-center m-0 p-o" href="<?= wp_logout_url( get_site_url() . "/authorization/") ?>">АВТОРИЗОВАТЬСЯ</a>
</section>