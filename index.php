<?php
declare(strict_types=1);

include('Donnees.inc.php');

session_start();

require 'vendor/autoload.php';
use boissons\controls\ControleurAccueil;

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('config/config.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$container = new \Slim\Container($config);
$app = new \Slim\App($container);

//Chemin Accueil
$app->get('/', ControleurAccueil::class.':accueil')->setName('racine');
$app->get('/{element}',ControleurAccueil::class.':afficherInformation')->setName('afficherInformation');

$app->run();
