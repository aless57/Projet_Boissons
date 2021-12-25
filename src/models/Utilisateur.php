<?php

namespace boissons\models;

/**
 * Classe Utilisateur de la table utilisateur
 */
class Utilisateur extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'utilisateur';
    protected $primaryKey = 'login';
    protected $keyType = 'string';
    public $timestamps = false;


}
