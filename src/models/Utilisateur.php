<?php

namespace boissons\models;

class Utilisateur extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'utilisateur';
    protected $primaryKey = 'login';
    protected $keyType = 'string';
    public $timestamps = false;


}
