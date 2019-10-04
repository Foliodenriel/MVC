<?PHP

spl_autoload_register(function($class) {

    $explodeClass = explode('\\', $class);
    if (count($explodeClass) > 0 && $explodeClass[0] === 'src')
        $base_directory = __DIR__ . '/';
    else
        $base_directory = __DIR__ . '/env/';

    $file = $base_directory . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file))
        require($file);
});

?>
