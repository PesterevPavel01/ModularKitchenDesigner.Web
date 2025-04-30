<?php 

//Utility function for static images inside theme
function theme_image($image_name = 'placeholder.png', $src = true, $dir = '/assets/img/module/') {
	$image_path = get_template_directory() . $dir . $image_name;
	$image_url = get_template_directory_uri() . $dir . $image_name;
	
	//If  got wrong URL -- show error placeholder instead
	if ( !file_exists($image_path) ) $image_url = get_template_directory_uri() . $dir . 'error.png';
	
	if ($src) {
		echo $image_url;
	}
	else {
		return $image_path;
	}
}