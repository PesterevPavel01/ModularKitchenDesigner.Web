<?php 
//THEME SUPPORTS
add_action( 'after_setup_theme', function(){
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
});

//THEME EXTRAS
//require_once get_template_directory() . '/inc/post-types.php';
//require_once get_template_directory() . '/inc/spa.php';
require_once get_template_directory() . '/inc/theme-image.php';
//require_once get_template_directory() . '/parts/main/kitchen-type/ajax.php';
//require_once get_template_directory() . '/parts/main/price-segment/ajax.php';
require_once get_template_directory() . '/parts/main/ajax.php';

function my_custom_global_variable() {
	global $ApiUrl;
	$ApiUrl = 'http://localhost:8080/api/';
}

add_action('init', 'my_custom_global_variable');

//THEME MENUS
add_action( 'after_setup_theme', 'theme_register_nav_menu' );

function theme_register_nav_menu() {
	register_nav_menu( 'main', 'Top Menu' );
}

//THEME STYLES & SCRIPTS
add_action( 'wp_enqueue_scripts', 'theme_styles_and_scripts' );	

function theme_styles_and_scripts() {

	$css_url = get_template_directory_uri() . '/assets/css/';
	$main_parts_url = get_template_directory_uri() . '/parts/main/';
	$js_url = get_template_directory_uri() . '/assets/js/';

	$css_path = get_template_directory() . '/assets/css/';
	$main_parts_path = get_template_directory() . '/parts/main/';
	$js_path = get_template_directory() . '/assets/js/';
	
	//Enqueue main theme style
	wp_enqueue_style( 'css-main', get_stylesheet_uri(), []);
	
	//Enqueue additional .css files
	enqueue_versioning_style( 'css-reset', $css_url, $css_path, 'reset.css', []);

	enqueue_versioning_style( 'css-normalize', $css_url, $css_path, 'normalize.css', []);	
	enqueue_versioning_style( 'css-variables', $css_url, $css_path, 'variables.css', []);
	enqueue_versioning_style( 'css-style',  $css_url, $css_path, 'style.css', []);
	enqueue_versioning_style( 'css-preloader',  $css_url, $css_path, 'preloader.css', []);
	enqueue_versioning_style( 'css-bootstrap-icons',  $css_url, $css_path, 'lib/bootstrap-icons.min.css', []);

	enqueue_versioning_style( 'css-price-segment-style', $main_parts_url, $main_parts_path, 'price-segment/style.css', []);
	enqueue_versioning_style( 'css-kitchen-type-style', $main_parts_url, $main_parts_path, 'kitchen-type/style.css', []);
	enqueue_versioning_style( 'css-material-style', $main_parts_url, $main_parts_path, 'material/style.css', []);
	enqueue_versioning_style( 'css-module-style', $main_parts_url, $main_parts_path, 'module/style.css', []);
	enqueue_versioning_style( 'css-section-title-style', $main_parts_url, $main_parts_path, 'titles/style.css', []);

	wp_enqueue_style('google-fonts-oswald', 'https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap', false);
	wp_enqueue_style('google-fonts-allison', 'https://fonts.googleapis.com/css2?family=Allison&display=swap', false);


	//Enqueue .js files	
	enqueue_versioning_script( 'jquery-init', $js_url , $js_path, 'lib/jQuery-init.js', ['jquery']);
	enqueue_versioning_script( 'jq-headroom-js', $js_url , $js_path,  'lib/jQuery.headroom.js', ['jquery-init']);
	enqueue_versioning_script( 'headroom-js', $js_url , $js_path, 'lib/Headroom.js', ['jquery-init']);
	enqueue_versioning_script( 'animation-js', $js_url , $js_path, 'animations/animations.js', ['jquery-init']);
	enqueue_versioning_script( 'custom-js', $js_url , $js_path, 'animations/custom.js', ['jquery-init']);
	enqueue_versioning_script( 'jq-module-js', $main_parts_url, $main_parts_path, 'module/script.js', ['jquery-init']);
}

function enqueue_versioning_script( $handle,$url, $path, $file_src, $deps = [], $in_footer = false ){
	wp_enqueue_script($handle, $url . $file_src, $deps, file_exists($path . $file_src) ? filemtime($path . $file_src) : null, $in_footer);
}

function enqueue_versioning_style( $handle, $url, $path, $file_src, $deps = [], $media = 'all'){
	wp_enqueue_style($handle, $url . $file_src, $deps, file_exists($path . $file_src) ? filemtime($path . $file_src) : null, $media);
}	
?>