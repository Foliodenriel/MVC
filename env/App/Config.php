<?PHP

namespace App;

class Config {

    private $basedir;
    private $configFolder;
    private $configFile;
    private $routeFile;
    private $controllerFolder;
    private $viewFolder;
    private $assetFolder;
    private $baseUrl;
    private ?DBManager $dbmanager;

    private $configData;

    public function __construct(String $configFolder = "./config/") {

        $this->configFile = null;
        $this->routeFile = null;
        $this->configFolder = $configFolder;
        if (file_exists($this->configFolder . 'config.json'))
            $this->configFile = $this->configFolder . 'config.json';
        if (file_exists($this->configFolder . 'routes.json'))
            $this->routeFile = $this->configFolder . 'routes.json';
        $this->loadConfig();
    }

    public function loadConfig() {

        if (file_exists($this->configFile))
        {
            $json_data = file_get_contents($this->configFile);
            $this->configData = json_decode($json_data, true);
            $env = $this->getConfig('env');
            if ($env)
            {
                $this->setBasedir($env['dir']);
            }
            $httpStr = "http";
            if (isset($_SERVER['HTTPS']))
                $httpStr = "https";
            $this->baseUrl = $httpStr . '://' . $_SERVER['SERVER_NAME'] . $this->getBasedir();
        }
    }

    public function setBasedir($basedir) { $this->basedir = $basedir; }
    public function getBasedir() { return $this->basedir; }

    public function getBaseURL() { return $this->baseUrl; }

    public function setConfigFolder($configFolder) { $this->configFolder = $configFolder; }
    public function getConfigFolder() { return $this->configFolder; }

    public function setRouteFile($routeFile) { $this->routeFile = $routeFile; }
    public function getRouteFile() { return $this->routeFile; }

    public function getConfig($configName) {
        if (isset($this->configData[$configName]))
            return $this->configData[$configName];
        return null;
    }

    public function getConfigFile() { return $this->configFile; }

    public function setControllerFolder($controllerFolder) { $this->controllerFolder = $controllerFolder; }
    public function getControllerFolder() { return $this->controllerFolder; }

    public function setViewFolder($viewFolder) { $this->viewFolder = $viewFolder; }
    public function getViewFolder() { return $this->viewFolder; }

    public function setAssetFolder($assetFolder) { $this->assetFolder = $assetFolder; }
    public function getAssetFolder() { return $this->assetFolder; }

    public function setDBManager(DBManager $dbmanager) { $this->dbmanager = $dbmanager; }
    public function getDBManager() { return $this->dbmanager; }
}
