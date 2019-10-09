<?PHP

namespace App;

class Config {

    private $basedir;
    private $basedirName;
    private $configFolder;
    private $routesFile;
    private $controllerFolder;
    private $viewFolder;
    private $assetFolder;

    public function setBasedir($basedir) { $this->basedir = $basedir; }
    public function getBasedir() { return $this->basedir; }

    public function setBasedirName($basedirName) { $this->basedirName = $basedirName; }
    public function getBasedirName() { return $this->basedirName; }

    public function setConfigFolder($configFolder) { $this->configFolder = $configFolder; }
    public function getConfigFolder() { return $this->configFolder; }

    public function setRouteFile($routeFile) { $this->routeFile = $routeFile; }
    public function getRouteFile() { return $this->routeFile; }

    public function setControllerFolder($controllerFolder) { $this->controllerFolder = $controllerFolder; }
    public function getControllerFolder() { return $this->controllerFolder; }

    public function setViewFolder($viewFolder) { $this->viewFolder = $viewFolder; }
    public function getViewFolder() { return $this->viewFolder; }

    public function setAssetFolder($assetFolder) { $this->assetFolder = $assetFolder; }
    public function getAssetFolder() { return $this->assetFolder; }
}
