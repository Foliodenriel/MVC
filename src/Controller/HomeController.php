<?php

namespace src\Controller;

use App\AbstractController;

class HomeController extends AbstractController {

    public function index()
    {
        $varTest = 'Bonjour';

        $this->render('index.php', [
            'test' => 'Ok',
        ]);
    }

    public function test()
    {
        echo('Working');
    }
}
