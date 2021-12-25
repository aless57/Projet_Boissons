<?php

namespace boissons\models;

/**
 * Classe panier pour la table panier
 */
class Panier extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'panier';
    protected $primaryKey = 'id';
    public $timestamps = false;
}