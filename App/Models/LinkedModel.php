<?php


namespace App\Models;


use App\Db;

abstract class LinkedModel extends Model
implements isLinked
{

    public function findAllByLinkId($id, $linkedField)
    {
        $db = Db::getInstace();
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE ACTIVE_TO>CURRENT_DATE' . ' AND '.$linkedField. '=' . $id;
        return $db->query($sql, static::class);
    }

}