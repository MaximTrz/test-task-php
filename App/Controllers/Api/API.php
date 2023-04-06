<?php


namespace App\Controllers\Api;


interface API
{
    public function actionGet();
    public function actionPut($params);
    public function actionPost();
    public function actionDelete($params);
}