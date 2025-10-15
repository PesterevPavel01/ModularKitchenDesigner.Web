<?php 

//Utility function for static images inside theme
function theme_image($image_name = 'placeholder', $src = true, $dir = '/assets/img/module/') {
	$image_path = get_template_directory() . $dir . $image_name;
	$image_url = get_template_directory_uri() . $dir . $image_name;
	
	//If  got wrong URL -- show error placeholder instead
	if ( file_exists($image_path . ".png") ) 
	{
		$image_url = $image_url  . ".png";
		$image_path = $image_path  . ".png";
	}
	else if ( file_exists($image_path . ".jpg") )
	{
		$image_url = $image_url  . ".jpg";
		$image_path = $image_path  . ".jpg";
	}
	else if ( file_exists($image_path . ".jpeg") )
	{
		$image_url = $image_url  . ".jpeg";
		$image_path = $image_path  . ".jpeg";
	}
	else if ( file_exists($image_path .  ".svg") )
	{
		$image_url = $image_url  . ".svg";
		$image_path = $image_path  . ".svg";
	}
	else
		$image_url = get_template_directory_uri() . '/assets/img/module/error.png';
	
	if ($src) {
		echo $image_url;
	}
	else {
		return $image_path;
	}
}