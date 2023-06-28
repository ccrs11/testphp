<?php
    require "../vendor/autoload.php"; //se trae el autoload desde el vendor creado por composer
    $router = new \Bramus\Router\Router();
    $dotenv = Dotenv\Dotenv::createImmutable("../")->load();
    
    $router->get("/hi", function(){
        $cox = new \App\connect();
        $res = $cox->con->prepare("SELECT * FROM campers");
        $res -> execute();
        $res = $res->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode($res);
    });

    $router->put("/hi", function(){
        $_DATA = json_decode(file_get_contents("php://input"), true);
        $cox = new \App\connect();
        $res = $cox->con->prepare("UPDATE journey SET name_journey = :NAME_JOURNEY, check_in=:CHECK_IN, check_out=:CHECK_OUT WHERE id =:ID");
        $res-> bindValue("NAME_JOURNEY", $_DATA['name_journey']); //para editar se debe escribir la sentencia dentro del $_DATA["nom"] es decir { nom: Wilfer, id: 1}
        $res-> bindValue("CHECK_IN", $_DATA['check_in']);
        $res-> bindValue("CHECK_OUT", $_DATA['check_out']);
        $res-> bindValue("ID", $_DATA['id']);
        $res -> execute();
        $res = $res->rowCount();
        echo json_encode($res);
    });

    $router -> delete("/hi", function(){
        $_DATA = json_decode(file_get_contents("php://input"), true);
        $cox = new \App\connect();
        $res = $cox->con->prepare("DELETE FROM journey WHERE id =:ID");
        $res->bindValue("ID", $_DATA["id"]);
        $res->execute();
        $res = $res->rowCount();
        echo json_encode($res);
    });

    $router->post("/hi", function(){
        $_DATA = json_decode(file_get_contents("php://input"), true);
        $cox = new \App\connect();
        $res = $cox->con->prepare("INSERT INTO journey (name_journey, check_in, check_out) VALUES (:NAME_JOURNEY,:CHECK_IN,:CHECK_OUT)");
        $res-> bindValue("NAME_JOURNEY", $_DATA['name_journey']); //para editar se debe escribir la sentencia dentro del $_DATA["nom"] es decir { nom: Wilfer, id: 1}
        $res-> bindValue("CHECK_IN", $_DATA['check_in']);
        $res-> bindValue("CHECK_OUT", $_DATA['check_out']);
        $res -> execute();
        $res = $res->rowCount();
        echo json_encode($res);
    });

    $router->run();
    /*
        Preparar -> 
            - Se llama a la conexion    
        Enviar  ->
        Ejecutar ->
        Esperar ->
    */
?>
