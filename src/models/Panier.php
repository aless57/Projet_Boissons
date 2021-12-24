<?php

namespace boissons\models;

class Panier extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'panier';
    protected $primaryKey = 'id';
    public $timestamps = false;
}