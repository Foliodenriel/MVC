<?PHP

use App\Router;
use App\Config;

/*  autoload.php file is a function called at first call
    of Class to setup the appropriate require.
    It works like a dynamic file finder and includer.
*/
if (!file_exists('./autoload.php'))
    return;
require './autoload.php';

$config = new Config();
$config->setBasedir(__DIR__);
$config->setBasedirName(basename(dirname(__FILE__)));
$config->setConfigFolder($config->getBasedir() . '/config/');
$config->setRouteFile($config->getConfigFolder() . 'routes.json');
$config->setViewFolder('src/View/');
$config->setAssetFolder('src/Asset/');

$router = new Router($config->getRouteFile()); // Loading router from json file

$urlPath = "";
if (isset($_GET['url'])) $urlPath = $_GET['url'];
$routeFromPath = $router->findRouteFromPath($urlPath); // Here we use path like '/home' to find it's route and controller

if (empty($routeFromPath)) { // 404 ERROR no such route found
    echo('ERROR 404: Page not found.');
    die();
}
$router->setCurrentRoute($routeFromPath);

$router->loadControllerFromRoute($routeFromPath);
$controllerName = $router->getLoadedClass();
$controllerFunc = $router->getLoadedFunc();

/*  Calling dynamic controller like 'src\Controller\HomeController' with appropriate function determined by json route file.
    This simulate following calls:

        $controller = new src\Controller\HomeController();
        $controller->index();
*/
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    $controller->setRouter($router);
    $controller->setConfig($config);
    if (is_callable(array($controller, $controllerFunc))){
        $controller->$controllerFunc();
    }
}
