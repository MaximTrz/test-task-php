<?php


namespace App\Models\Interfaces;


interface CRUD
{
    public static function getTableName();
    static public function findAll();
    static public function findById($id);
    public function isNew();
    public function insert();
    public function update();
    public function delete();
}