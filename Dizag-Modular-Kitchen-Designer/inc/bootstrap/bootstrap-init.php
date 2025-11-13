<?function enqueue_bootstrap_conditional() {

    if(!is_page('account') && !is_page('order') && !is_page('kitchen'))
        return;

    $css_url = get_template_directory_uri() . '/assets/css/';
    $css_path = get_template_directory() . '/assets/css/';
    $js_url = get_template_directory_uri() . '/assets/js/';
    $js_path = get_template_directory() . '/assets/js/';

    enqueue_versioning_style( 'css-bootstrap-icons',  $css_url, $css_path, 'lib/bootstrap-icons.min.css', ['css-normalize']);

    if (is_page('account') || is_page('order')){

        enqueue_versioning_style('css-bootstrap',  $css_url, $css_path, 'lib/bootstrap.min.css', []);
        enqueue_versioning_script( 'bootstrap-bundle-js', $js_url, $js_path, 'lib/bootstrap/bootstrap.bundle.min.js', []);

    }

    if(is_page('order')){

        wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
        wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array(), '5.3.0', true);

    }
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_conditional', 5);