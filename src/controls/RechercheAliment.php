<?php

namespace boissons\controls;
use boissons\models\Hierarchie;
use boissons\models\SousCategorie;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Classe controleur rechercheAliment
 */
class RechercheAliment
{
    public function __construct(){
        $db = new DB();
        $config = parse_ini_file("../../config/config.ini");
        if ($config) $db->addConnection($config);

        $db->setAsGlobal();
        $db->bootEloquent();
    }

    public static function getListAliment($aliment){
        return Hierarchie::where('nom','LIKE',$aliment.'%')->get()->toArray();
    }

    public static function getListSC($aliment){
        return SousCategorie::where('nomH','LIKE',$aliment.'%')->get()->toArray();
    }
}