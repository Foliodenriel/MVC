<?PHP

namespace App;

class AbstractController {

    private $router;
    private $config;
    private $viewVar;

    public function setRouter($router) { $this->router = $router; }
    public function getRouter() { return $this->router; }

    public function setConfig($config) { $this->config = $config; }
    public function getConfig() { return $this->config; }

    public function setVar($var) { $this->viewVar = $var; }
    public function getVar() { return $this->viewVar; }
    public function getVarNamed($varName) {
        if (array_key_exists($varName, $this->viewVar))
            return $this->viewVar[$varName];
        return "";
    }

    public function redirectToRoute($route)
    {
        $routePath = $this->router->findPathFromRoute($route);
        header('Location: ' . $routePath);
    }

    public function render($file, $var = [])
    {
        if (file_exists($this->config->getViewFolder() . $file)) {

            $this->setVar($var);
            require($this->config->getViewFolder() . $file);
        }
    }

    public function asset($file)
    {
        if (file_exists($this->config->getAssetFolder() . $file))
            return '/' . $this->config->getBasedirName() . '/' . $this->config->getAssetFolder() . $file;
        return "";
    }
}
