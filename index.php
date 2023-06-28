<?php

/* error_reporting(E_ALL);
ini_set('display_errors', '1'); */

header("Access-Control-Allow-Origin: *"); // Permite el acceso desde cualquier origen. Puedes especificar un origen específico en lugar de '*' si es necesario.
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT"); // Especifica los métodos HTTP permitidos.
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

require 'vendor/autoload.php';


use Bramus\Router\Router as RouterRouter;

use App\campers\campers AS campers;
use App\region\region AS region;
use App\departamento\departamento AS departamento;

$router = new RouterRouter();
// Define routes
// ...

//RUTAS PARA campers

$router->mount('/campers', function() use ($router) {

    $router->get('/', function() {
        campers::getall();
    });


    $router->delete('/(\d+)', function($id){
        campers::delete($id);
    });

    /* 
        para post y put el objeto a recibir es
        {
            "area": 1,
            "staff": 2,
            "position": 2,
            "journeys" : 2
        }
    
    */

    $router->post('/', function(){
        campers::post(json_decode(file_get_contents('php://input'), true));
    });

    $router->match('PUT|PATCH','/(\d+)', function($id){
        campers::update($id , json_decode(file_get_contents('php://input'), true));
    });

});


//region
$router->mount('/region', function() use ($router) {

    $router->get('/', function() {
        region::getall($id);
    });

    $router->get('/(\d+)', function($id){
        region::getall($id);
    });
   
});


//departemento
$router->mount('/departamento', function() use ($router) {

    $router->get('/', function() {
        departamento::getall();
    });

   
});

$router->get('/', function() {  
    echo 'inicio';
});
// Run it!
$router->run();