<?php 
require_once get_template_directory() . '/inc/extensions/ConteinerDI.php';
require_once get_template_directory() . '/inc/custom-shortcodes.php';

function my_custom_global_variable() {
	global $Discount;
	$Discount = 0.2;
	global $ApiUrl;
	$ApiUrl = 'http://localhost:8080/api/';
	global $exchangeServiceUrl;
	$exchangeServiceUrl = 'http://localhost:8091/api/';
	global $clientServiceUrl;
	$clientServiceUrl = 'http://localhost:8091/api/';
	global $moduleServiceUrl;
	$moduleServiceUrl = 'http://localhost:8092/api/';
	global $orderServiceUrl;
	$orderServiceUrl = 'http://localhost:8090/api/';
	global $approvalServiceUrl;
	$approvalServiceUrl = 'http://localhost:8093/api/';
	global $GotenbergUrl;
	$GotenbergUrl = 'http://localhost:3000/';
	global $PdfOrderUploads;
	$PdfOrderUploads['path'] = get_template_directory() . '/pdf-order-uploads';
	$PdfOrderUploads['url'] = get_template_directory_uri() . '/pdf-order-uploads';
	/*Необходимо настроить очистку папки через Cron!!
	Команда для Cron: `rm -f /var/www/www-root/data/www/kitchen-dizag.fvds.ru/wp-content/themes/Dizag-Modular-Kitchen-Designer/pdf-order-uploads/*.pdf` 
	*/
}

add_action('init', 'my_custom_global_variable');

//CREATE DI CONTEINER
function DI_conteiner(){
	// Инициализация контейнера
	global $СontainerDI;
	$СontainerDI = new ContainerDI();
}

add_action('init', 'DI_conteiner', 11);

//REGISTRATION AJAX
require_once get_template_directory() . '/inc/ajax-scripts-setup.php';
require_once get_template_directory() . '/inc/ajax-pdf-creator.php';
require_once get_template_directory() . '/inc/ajax-content-updater.php';
require_once get_template_directory() . '/inc/ajax-default-content-updater.php';

//THEME SUPPORTS
add_action( 'after_setup_theme', function(){
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
});

//THEME EXTRAS
require_once get_template_directory() . '/inc/theme-image.php';


//THEME MENUS
add_action( 'after_setup_theme', 'theme_register_nav_menu' );

function theme_register_nav_menu() {
	register_nav_menu( 'main', 'Top Menu' );
}

//THEME STYLES & SCRIPTS

//bootstrap

function enqueue_bootstrap_conditional() {
    if (!is_page('kitchen')) {
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_conditional', 5);

function theme_styles_and_scripts() {

	$css_url = get_template_directory_uri() . '/assets/css/';
	$main_parts_url = get_template_directory_uri() . '/parts/main/';
	$js_url = get_template_directory_uri() . '/assets/js/';

	$css_path = get_template_directory() . '/assets/css/';
	$main_parts_path = get_template_directory() . '/parts/main/';
	$js_path = get_template_directory() . '/assets/js/';
	
    if (is_page('kitchen')) {
        enqueue_versioning_style('custom-flex-css',  $css_url, $css_path, 'flex-style.css', ['css-variables']);
    }

	//Enqueue main theme style
	wp_enqueue_style( 'css-main', get_stylesheet_uri(), []);
	
	//Enqueue additional .css files
	enqueue_versioning_style( 'css-reset', $css_url, $css_path, 'reset.css', []);

	enqueue_versioning_style( 'css-normalize', $css_url, $css_path, 'normalize.css', ['css-reset']);	
	enqueue_versioning_style( 'css-variables', $css_url, $css_path, 'variables.css', ['css-normalize']);
	wp_enqueue_style('css-swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', false);
	enqueue_versioning_style( 'css-style',  $css_url, $css_path, 'style.css', ['css-swiper-style']);
	enqueue_versioning_style( 'css-preloader',  $css_url, $css_path, 'preloader.css', ['css-variables']);
	enqueue_versioning_style( 'css-bootstrap-icons',  $css_url, $css_path, 'lib/bootstrap-icons.min.css', ['css-normalize']);
	//enqueue_versioning_style( 'css-swiper-style', $main_parts_url, $main_parts_path, 'lib/swiper-bundle.min.css', ['css-style']);

	enqueue_versioning_style( 'css-price-segment-style', $main_parts_url, $main_parts_path, 'price-segment/style.css', []);
	enqueue_versioning_style( 'css-kitchen-type-style', $main_parts_url, $main_parts_path, 'kitchen-type/style.css', []);
	enqueue_versioning_style( 'css-material-style', $main_parts_url, $main_parts_path, 'material/style.css', []);
	enqueue_versioning_style( 'css-module-style', $main_parts_url, $main_parts_path, 'module/style.css', []);
	enqueue_versioning_style( 'css-pdf-order-creator-style', $main_parts_url, $main_parts_path, 'pdf-order-creator/style.css', []);
	enqueue_versioning_style( 'css-section-title-style', $main_parts_url, $main_parts_path, 'titles/style.css', []);
	enqueue_versioning_style( 'css-specification-style', $main_parts_url, $main_parts_path, 'specification/style.css', []);

	wp_enqueue_style('google-fonts-oswald', 'https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap', false);
	wp_enqueue_style('google-fonts-allison', 'https://fonts.googleapis.com/css2?family=Allison&display=swap', false);

	//Enqueue .js files	
	enqueue_versioning_script( 'jquery-init', $js_url , $js_path, 'lib/jQuery-init.js', ['jquery']);
	wp_enqueue_script('jquery-blockui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js', ['jquery'], '2.70', true);
	enqueue_versioning_script( 'headroom-js', $js_url , $js_path, 'lib/Headroom.js', ['jquery-init']);
	enqueue_versioning_script( 'jq-headroom-js', $js_url , $js_path,  'lib/jQuery.headroom.js', ['headroom-js']);
	enqueue_versioning_script( 'swiper-js', $js_url , $js_path,  'lib/swiper-bundle.min.js', ['jquery']);
	enqueue_versioning_script( 'custom-js', $js_url , $js_path, 'animations/custom.js', ['jq-headroom-js']);
	enqueue_versioning_script( 'animation-js', $js_url , $js_path, 'animations/animations.js', ['jquery-init']);
	enqueue_versioning_script( 'jq-module-js', $main_parts_url, $main_parts_path, 'module/script.js', ['jquery-init']);
}

add_action( 'wp_enqueue_scripts', 'theme_styles_and_scripts', 10 );

function enqueue_versioning_script( $handle,$url, $path, $file_src, $deps = [], $in_footer = false ){
	wp_enqueue_script($handle, $url . $file_src, $deps, file_exists($path . $file_src) ? filemtime($path . $file_src) : null, $in_footer);
}

function enqueue_versioning_style( $handle, $url, $path, $file_src, $deps = [], $media = 'all'){
	wp_enqueue_style($handle, $url . $file_src, $deps, file_exists($path . $file_src) ? filemtime($path . $file_src) : null, $media);
}	
?>