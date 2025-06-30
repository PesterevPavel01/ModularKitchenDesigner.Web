<nav class="navbar">

    <div class="container height-100">
        
        <?/*?>
        <div class="hamb">
            <div class="hamb-field" id="hamb">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
        <?*/?>
        <a class="navbar-brand height-100" href="/">
            <div class="container-logo flex-column height-100">
                <div class="custom-logo flex-row-start height-100">
                    <img class="logo-icon cover height-100" src="<?=theme_image('logo',true,'/assets/img/')?>">
                    </img>
                    <div class="logo black flex-column">
                        <p class="logo-main">Дизаж</p>
                        <p class="logo-footer">МОДУЛЬНЫЕ КУХНИ</p>
                    </div>
                </div>
            </div>
        </a>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <?if (is_user_logged_in()){
                    $current_user = wp_get_current_user();
                    ?>
                    <li class="flex-column">
                        <p class="login white mobile-none"><?=$current_user->user_login?></p>
                        <a class="flex-column white" href="<?= wp_logout_url( get_site_url() . "/autorization/") ?>">
                            <div class="bi bi-box-arrow-right"></div>
                            <label class="small-font pointer navbar-label">выход</label>
                        </a>
                    </li>
                <?}else{?>
                    <li class>
                        <a class="bi bi-person-circle white" href="/autorization/"></a>
                    </li>
                <?}?>
                <?/*?>
                <li class="nav-item">
                    <a class="nav-link" href="gallery.html">МЕНЮ 2</a>
                </li>
            
                <li class="nav-item">
                    <a class="nav-link" href="about.html">МЕНЮ 3</a>
                </li>
                <?*/?>
            </ul>
        </div>
    </div>

</nav>