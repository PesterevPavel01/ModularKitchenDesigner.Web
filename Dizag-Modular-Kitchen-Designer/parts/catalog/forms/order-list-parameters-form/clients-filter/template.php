<?
$cache_key = 'clients_filter_constructor';

$start = microtime(true);

$cached_result = get_transient($cache_key);


if (!$cached_result) {

    $customers = get_users(array(
        'role'    => 'customer',
        'orderby' => 'display_name',
        'order'   => 'ASC',
    ));

    $result = array();

    foreach ($customers as $customer) {
        
        $first_name = get_user_meta($customer->ID, 'first_name', true);
        $last_name = get_user_meta($customer->ID, 'last_name', true);
        
        $full_name = trim($first_name . ' ' . $last_name);
        
        // Если имя и фамилия пустые, используем display_name как запасной вариант
        if (empty($full_name)) {
            $full_name = $customer->display_name;
        }
        
        $result[] = array(
            'NAME' => $full_name,
            'VALUE' => $customer->user_login
        );
    }

    $cached_result = $result;

    set_transient($cache_key, $cached_result, 15 * MINUTE_IN_SECONDS);
}

$result = $cached_result;

if (!empty($result)) {

    get_template_part("/parts/controls/fieldset/template", null,
    [
        'TITLE' =>  'КЛИЕНТЫ',
        'LIST_NAME' => 'users',
        'ITEMS' => $result,
        'MAIN_CONTEINER_CLASS' => 'clients-filter-conteiner',
        'CONTENT_CONTEINER_CLASS' => 'clients-filter-content'
    ]);

}
?>