<?php


namespace App\Helpers;


use App\Exceptions\PageNotFound;

/**
 * Class RouterHelper
 * @package App\Helpers
 * Абстрактный класс помошников для Router'а
 */
abstract class RouterHelper
{
    /**
     * @param string $controllerName имя контроллера
     * @param string $action имя Action
     * @param string $id идентификатор записи
     * @throws PageNotFound
     * Проверяет существуют ли переданный контроллер и Action, в случае успеха выполняет Action
     * если нет бросает ошибку "Страница не найдена"
     */
    public static function goToRoute($controllerName, $action="", $id=""){
        $controllerName = '\App\Controllers\\' . $controllerName;
        if (class_exists($controllerName)) {
            $controller = new $controllerName;
            if ($action!=""){
                $controller->action($action, $id);
            } else {
                $controller->action("index");
            }
        } else throw new PageNotFound();
    }
}