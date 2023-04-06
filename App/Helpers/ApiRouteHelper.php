<?php


namespace App\Helpers;


use App\Exceptions\ApiNotFound;
use mysql_xdevapi\Exception;

/**
 * Class ApiRouteHelper
 * @package App\Helpers
 * Помошник маршутизатора для работы с API
 */
abstract class ApiRouteHelper
{
    /**
     * @return array
     * Разрезать URL на составляющие
     */
    public static function cutApiUrl(){

        $params = explode('/', $_SERVER['REQUEST_URI']);

        // $params[1] - controller
        $controller = $params[2];

        // $params[2] - action
        $action = $_SERVER['REQUEST_METHOD'];

        // $params[3] - id
        if (true == isset($params[3])){
            $id = $params[3];
        } else {
            $id = null;
        }

        // $params[4-...] other parameters

        return [
            "controller" => $controller,
            "action" => $action,
            "id" => $id
        ];

    }

    /**
     * @param $controllerName
     * @return bool
     * Проверяет наличие контроллера для API
     */
    public static function checkController($controllerName){

        if (class_exists($controllerName)==true) {
            return true;
        }

        return false;

    }

    /**
     * @throws ApiNotFound
     * Запуск API Action
     */
    public static function runAction(){

      $params = self::cutApiUrl();
      $controllerName = '\App\Controllers\Api\\' . $params["controller"];

      if (self::checkController($controllerName)==true){
          try {

                $controller = new $controllerName;
                $controller->Action($params["action"], $params);

          } catch (Exception $e){

            throw new ApiNotFound();

          }
      }

    }
}