<?php


namespace App\Models;


interface isLinked
{
    public function findAllByLinkId($id, $linkedField);
}