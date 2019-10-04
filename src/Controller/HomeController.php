<?php

namespace src\Controller;

use App\AbstractController;

class HomeController extends AbstractController {

    public function index()
    {
        $this->render('index.php', [
            'test' => 'Ok',
        ]);
    }

    public function test()
    {
        echo('Working');
    }
}
