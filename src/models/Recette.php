<?php

namespace boissons\models;

/**
 * Classe recette de la table recette
 */
class Recette extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'recettes';
    protected $primaryKey = 'id';
    public $timestamps = false;
}