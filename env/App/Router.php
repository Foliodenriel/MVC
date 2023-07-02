<?PHP

namespace App;

class Router {

    private $routes = [];
    private $routesFile;

    // Current loaded class for controller
    private $loadedClass;

    // Current Loaded function in class
    private $loadedFunc;

    private $currentRoute;

    private $urlVarTable;

    public function __construct($file) {

        $this->routesFile = $file;
        if (file_exists($file))
        {
            $json_data = file_get_contents($file);
            $json_obj = json_decode($json_data, true);
            $this->setRoutes($json_obj);
        }
    }

    public function setRoutes($routes) { $this->routes = $routes; }
    public function getRoutes() { return $this->routes; }

    public function setRoutesFile($routesFile) { $this->routesFile = $routesFile; }
    public function getRoutesFile() { return $this->routesFile; }

    public function setLoadedClass($loadedClass) { $this->loadedClass = $loadedClass; }
    public function getLoadedClass() { return $this->loadedClass; }

    public function setLoadedFunc($loadedFunc) { $this->loadedFunc = $loadedFunc; }
    public function getLoadedFunc() { return $this->loadedFunc; }

    public function setCurrentRoute($currentRoute) { $this->currentRoute = $currentRoute; }
    public function getCurrentRoute() { return $this->currentRoute; }

    public function getUrlVarTable() { return $this->urlVarTable; }

    public function routeExist($routeName)
    {
        if ($this->routes)
            return array_key_exists($routeName, $this->routes);
        return null;
    }

    public function findRouteFromPath($urlPath) {

        $retRoute = "";
        foreach ($this->routes as $key => $value) {

            if (array_key_exists('path', $value)) {

                if (is_array($value['path'])) {
                    // Do as array
                    for ($i = 0; $i < count($value['path']); $i++) {
                        if ($this->resolve_path($value['path'][$i], $urlPath)) {

                            $retRoute = $key;
                            break;
                        }
                    }
                }
                else if ($this->resolve_path($value['path'], $urlPath)) {

                    $retRoute = $key;
                    break;
                }
            }
        }
        return $retRoute;
    }

    public function loadControllerFromRoute($routeName) {

        $strController = "";
        if ($this->routeExist($routeName) && array_key_exists('controller', $this->routes[$routeName])) {
            $strController = str_replace('/', '\\', $this->routes[$routeName]['controller']);
            $loadedController = explode('::', $strController);
            if (count($loadedController) === 2) {

                $this->loadedClass = $loadedController[0];
                $this->loadedFunc = $loadedController[1];
            }
        }
    }

    public function findPathFromRoute($route) {

        $retPath = "";
        if ($this->routeExist($route) && array_key_exists('path', $this->routes[$route])) {

            $retPath = $this->routes[$route]['path'];
        }
        return $retPath;
    }

    protected function resolve_path($routePath, $urlPath) {

        $index = 0;
        $routePath = trim($routePath, '/');
        $urlPath = trim($urlPath, '/');
        $arrRoutePath = explode('/', $routePath);
        $arrUrlPath = explode('/', $urlPath);
        $varTable = [];

        if (count($arrRoutePath) != count($arrUrlPath))
            return false;

        foreach ($arrRoutePath as $key => $value) {

            if (preg_match('/^{.+}/', $value, $varTable)) {

                $newValue = trim($value, '{}');
                $this->urlVarTable[$newValue] = $arrUrlPath[$key];
            }
            else if ($value !== $arrUrlPath[$key])
                return false;
        }
        return true;
    }
}
