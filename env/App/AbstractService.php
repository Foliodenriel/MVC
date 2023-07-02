<?PHP

namespace App;

use App\AbstractController;

class AbstractService {

	private $controller;

	public function __construct($controller = null) {

		if ($controller instanceof AbstractController)
			$this->controller = $controller;
	}

	protected function dbmanager() { return $this->controller->dbmanager(); }
}