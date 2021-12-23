<?php

namespace boissons\models;

class Hierarchie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'hierarchie';
    protected $primaryKey = 'nom';
    protected $keyType = 'string';
    public $timestamps = false;
}