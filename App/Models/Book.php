<?php


namespace App\Models;


class Book extends Model
{
    const TABLE = 'books';
    public $title;
    public $year;
    public $author;

}