<?php

namespace boissons\models;

class Utilisateur extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'utilisateur';
    protected $primaryKey = 'login';
    public $timestamps = false;


}
