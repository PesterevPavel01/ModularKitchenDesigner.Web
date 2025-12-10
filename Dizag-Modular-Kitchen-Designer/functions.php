<?php 
require_once get_template_directory() . '/inc/extensions/ConteinerDI.php';
require_once get_template_directory() . '/inc/custom-shortcodes.php';

function my_custom_global_variable() {
	
	global $Discount;
	$Discount = 0.2;
	global $ApiUrl;
	$ApiUrl = 'http://localhost:8080/api/';

	global $GotenbergUrl;
	$GotenbergUrl = 'http://localhost:3000/';
	global $PdfOrderUploads;
	$PdfOrderUploads['path'] = get_template_directory() . '/pdf-order-uploads';
	$PdfOrderUploads['url'] = get_template_directory_uri() . '/pdf-order-uploads';
	/*Необходимо настроить очистку папки через Cron!!
	Команда для Cron: `rm -f /var/www/www-root/data/www/kitchen-dizag.fvds.ru/wp-content/themes/Dizag-Modular-Kitchen-Designer/pdf-order-uploads/*.pdf` 
	*/

	global $exchangeServiceUrl;
	$exchangeServiceUrl = 'http://localhost:8091/api/';
	global $clientServiceUrl;
	$clientServiceUrl = 'http://localhost:8091/api/';
	global $componentServiceUrl;
	$componentServiceUrl = 'http://localhost:8095/api/';
	global $moduleServiceUrl;
	$moduleServiceUrl = 'http://localhost:8092/api/';
	global $orderServiceUrl;
	$orderServiceUrl = 'http://localhost:8090/api/';
	global $approvalServiceUrl;
	$approvalServiceUrl = 'http://localhost:8093/api/';	
}

add_action('init', 'my_custom_global_variable');

//CREATE DI CONTEINER
function DI_conteiner(){

	if(!is_page('kitchen'))
		return;

	// Инициализация контейнера
	global $СontainerDI;
	$СontainerDI = new ContainerDI();

}

add_action('init', 'DI_conteiner', 11);

//REGISTRATION AJAX
require_once get_template_directory() . '/inc/kitchen/ajax-scripts-setup.php';
require_once get_template_directory() . '/inc/catalog/ajax-scripts-setup.php';
require_once get_template_directory() . '/inc/ajax-pdf-creator.php';
require_once get_template_directory() . '/inc/ajax-content-updater.php';
require_once get_template_directory() . '/inc/ajax-default-content-updater.php';

//REGISTRATION BOOTSTRAP
require_once get_template_directory() . '/inc/bootstrap/bootstrap-init.php';

//THEME SUPPORTS
add_action( 'after_setup_theme', function(){

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	if (!current_user_can('administrator')) {

        show_admin_bar(false);

    }

});

require_once get_template_directory() . '/inc/theme-image.php';
require_once get_template_directory() . '/inc/user-data.php';

add_action( 'after_setup_theme', 'theme_register_nav_menu' );

function theme_register_nav_menu() {

	register_nav_menu( 'main', 'Top Menu' );

}

function theme_styles_and_scripts() {

	$css_url = get_template_directory_uri() . '/assets/css/';
	$main_parts_url = get_template_directory_uri() . '/parts/main/';
	$js_url = get_template_directory_uri() . '/assets/js/';

	$css_path = get_template_directory() . '/assets/css/';
	$main_parts_path = get_template_directory() . '/parts/main/';
	$js_path = get_template_directory() . '/assets/js/';
	
    if (is_page('kitchen') || is_front_page() ||  is_page('authorization') || is_page('registration')) {

        enqueue_versioning_style('custom-flex-css',  $css_url, $css_path, 'flex-style.css', ['css-variables']);

    }

	wp_enqueue_style( 'css-main', get_stylesheet_uri(), []);
	
	enqueue_versioning_style( 'css-reset', $css_url, $css_path, 'reset.css', []);
	enqueue_versioning_style( 'css-normalize', $css_url, $css_path, 'normalize.css', ['css-reset']);	
	enqueue_versioning_style( 'css-variables', $css_url, $css_path, 'variables.css', ['css-normalize']);
	
	
	enqueue_versioning_style( 'css-style',  $css_url, $css_path, 'style.css', ['css-variables']);
	enqueue_versioning_style( 'css-preloader',  $css_url, $css_path, 'preloader.css', ['css-variables']);

	if (is_page('account')){

		enqueue_versioning_style('css-swiper-style',  $css_url, $css_path, 'lib/swiper-bundle.min.css', ['css-normalize']);
	
	}

	if (is_page('kitchen')){

		enqueue_versioning_style( 'css-price-segment-style', $main_parts_url, $main_parts_path, 'price-segment/style.css', []);
		enqueue_versioning_style( 'css-kitchen-type-style', $main_parts_url, $main_parts_path, 'kitchen-type/style.css', []);
		enqueue_versioning_style( 'css-material-style', $main_parts_url, $main_parts_path, 'material/style.css', []);
		enqueue_versioning_style( 'css-module-style', $main_parts_url, $main_parts_path, 'module/style.css', []);
		enqueue_versioning_style( 'css-pdf-order-creator-style', $main_parts_url, $main_parts_path, 'pdf-order-creator/style.css', []);
		enqueue_versioning_style( 'css-specification-style', $main_parts_url, $main_parts_path, 'specification/style.css', []);
		
	}

	enqueue_versioning_style( 'css-section-title-style', $main_parts_url, $main_parts_path, 'titles/style.css', []);

	enqueue_versioning_style('google-fonts-oswald', $css_url, $css_path, 'oswald.css', []);

	enqueue_versioning_script( 'jquery-init', $js_url , $js_path, 'lib/jQuery-init.js', ['jquery']);

	if (is_page('order')){

		enqueue_versioning_script( 'blueprints-modal-js', $js_url , $js_path,  'blueprints/modal.js', ['jquery']);

	}
	
	enqueue_versioning_script( 'headroom-js', $js_url , $js_path, 'lib/Headroom.js', ['jquery-init']);

	enqueue_versioning_script( 'jq-headroom-js', $js_url , $js_path,  'lib/jQuery.headroom.js', ['headroom-js']);
	
	if (is_page('account')){

		enqueue_versioning_script( 'swiper-js', $js_url , $js_path,  'lib/swiper-bundle.min.js', ['jquery']);

	}

	enqueue_versioning_script( 'custom-js', $js_url , $js_path, 'animations/custom.js', ['jq-headroom-js']);

	if (is_page('kitchen')){

		enqueue_versioning_script( 'animation-js', $js_url , $js_path, 'animations/animations.js', ['jquery-init']);
		enqueue_versioning_script( 'jq-module-js', $main_parts_url, $main_parts_path, 'module/script.js', ['jquery-init']);

	}
}

add_action( 'wp_enqueue_scripts', 'theme_styles_and_scripts', 10 );

function enqueue_versioning_script( $handle, $url, $path, $file_src, $deps = [], $in_footer = false ){
	wp_enqueue_script($handle, $url . $file_src, $deps, file_exists($path . $file_src) ? filemtime($path . $file_src) : null, $in_footer);
}

function enqueue_versioning_style( $handle, $url, $path, $file_src, $deps = [], $media = 'all'){
	wp_enqueue_style($handle, $url . $file_src, $deps, file_exists($path . $file_src) ? filemtime($path . $file_src) : null, $media);
}	
?>