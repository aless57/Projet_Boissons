<?php

namespace boissons\models;

/**
 * Classe Hierarchie de la table hierarchie
 */
class Hierarchie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'hierarchie';
    protected $primaryKey = 'nom';
    protected $keyType = 'string';
    public $timestamps = false;
}