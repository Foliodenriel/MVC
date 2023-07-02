<?PHP

session_start();

use App\Router;
use App\Config;
use App\DBManager;

/*  autoload.php file is a function called at first call
    of Class to setup the appropriate require.
    It works like a dynamic file finder and includer.
*/
if (!file_exists('./autoload.php'))
    return;
require './autoload.php';

$config = new Config('./config/'); // default parameter
// $config->setRouteFile("other_file");
// $config->loadConfig();
$config->setViewFolder('src/View/');
$config->setAssetFolder('src/Asset/');

$router = new Router($config->getRouteFile()); // Loading router from json file
$dbmanager = new DBManager($config->getConfig('database'));
$config->setDBManager($dbmanager);

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
