<?php

namespace boissons\controls;
use boissons\models\Hierarchie;
use Illuminate\Database\Capsule\Manager as DB;

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
}