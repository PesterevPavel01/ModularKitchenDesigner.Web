<nav class="navbar-section headroom p-2">

    <div class="navbar-container flex-container d-flex align-items-center height-100">
        <a class="navbar-brand height-100" href="/">
            <div class="container-logo d-flex align-items-center flex-column height-100">
                <div class="custom-logo flex-row-start d-flex  align-items-center justify-content-start height-100">
                    <img class="logo-icon cover height-100" src="<?=theme_image('logo',true,'/assets/img/')?>">
                    </img>
                    <div class="logo black d-flex flex-column align-items-start justify-content-center">
                        <p class="logo-main m-0">Дизаж</p>
                        <p class="logo-footer m-0">ПРОИЗВОДСТВО МЕБЕЛИ</p>
                    </div>
                </div>
            </div>
        </a>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <?if (is_user_logged_in()){
                    $current_user = wp_get_current_user();

                    $login = sanitize_text_field($current_user->user_login);

                    $user = get_user_fullname_by_username($login);
                    ?>
                    <li class="flex-column">
                        <p class="login white mobile-none m-0"><?= empty($user) ? $login : $user['full_name'] ?></p>
                        <a class="d-flex align-items-center flex-column white" href="<?= wp_logout_url( get_site_url() . "/authorization/") ?>">
                            <div class="bi bi-box-arrow-right"></div>
                        </a>
                    </li>
                <?}else{?>
                    <li class>
                        <a class="bi bi-person-circle white" href="/authorization/"></a>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>

</nav>