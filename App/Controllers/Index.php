<?php


namespace App\Controllers;


use App\Config;

/**
 * Class Index
 * @package App\Controllers
 * Контроллер главной страницы
 */
class Index extends Controller
{
    /**
     * Главная страница
     */
    public function actionMain(){
        $this->view->display('index.html');
    }
}