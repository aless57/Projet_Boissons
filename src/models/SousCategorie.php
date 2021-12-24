<?php

namespace boissons\models;
use Illuminate\Database\Eloquent\Builder;

class SousCategorie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sous-categorie';
    protected $primaryKey = 'idSous';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}