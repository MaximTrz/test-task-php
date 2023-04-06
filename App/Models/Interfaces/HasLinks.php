<?php


namespace App\Models;


interface HasLinks
{
    public function getLinkTables();
    public function findByIdWithLinks($id);
}