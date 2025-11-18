<?function get_user_fullname_by_username($login) {
    // Получаем объект пользователя по логину
    $user = get_user_by('login', $login);
    
    if ($user) {
        // Получаем мета-данные
        $first_name = get_user_meta($user->ID, 'first_name', true);
        $last_name = get_user_meta($user->ID, 'last_name', true);
        
        if( !isset($first_name) || trim($first_name) === "")
            return [];

        return array(
            'ID' => $user->ID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'full_name' => trim($first_name . ' ' . $last_name)
        );
    }
    
    return [];
}