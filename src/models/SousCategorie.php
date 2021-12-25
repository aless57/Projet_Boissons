<?php

namespace boissons\models;
use Illuminate\Database\Eloquent\Builder;


/**
 * Classe SousCategorie de la table sous-categorie
 */
class SousCategorie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sous-categorie';
    protected $primaryKey = 'idSous';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}