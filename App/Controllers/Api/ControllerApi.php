<?php

namespace App\Controllers\Api;

use App\Views\View;

class ControllerApi extends \App\Controllers\Controller
implements API
{

    const MODELNAME = '';

    protected $model;

    public function __construct()
    {
        $this->view = new View();
        $model = static::MODELNAME;
        $this->model = new $model;
    }

    public function actionGet($params=NUL){
        $id = $params["id"];

        if (NULL == $id){
            $res = $this->model->findAll();
        } else {
            if (true == method_exists($this->model, "findByIdWithLinks")){
                $res = $this->model->findByIdWithLinks($id);
            } else {
                $res = $this->model->findById($id);
            }
        }

        http_response_code(200);
        $this->view->JSON($res);

    }

    public function actionPut($params){

        $id = $params["id"];
        $obj = $this->model->findById($id);

        $data = file_get_contents("php://input");
        $data = json_decode($data, true);

        $obj = $this->fillObj($obj, $data);

        $res = $obj->save();

        if  (true == $res['result']){
            http_response_code(200);
            $this->view->JSON($res);
        } else {
            http_response_code(500);
        }

    }

    public function actionDelete($params){
        $id = $params["id"];
        $obj = $this->model->findById($id);
        $res = $obj->delete();
        if  (true == $res['result']){
            http_response_code(200);
            $this->view->JSON($res);
        } else {
            http_response_code(500);
        }
    }

    public function actionPost(){

        $this->model = $this->fillObj($this->model, $_POST);

        var_dump($this->model);

        $res = $this->model->save();

        if  (true == $res['result']){
            http_response_code(200);
            $this->view->JSON($res);
        } else {
            http_response_code(500);
        }

    }

    public function fillObj($obj, array $arr){

        foreach ($arr as $key => $value){
            $obj->$key = $arr[$key];
        }

        return $obj;

    }

}