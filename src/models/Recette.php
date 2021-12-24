<?php

namespace boissons\models;

class Recette extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'recettes';
    protected $primaryKey = 'id';
    public $timestamps = false;
}