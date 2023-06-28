<?php

namespace App\departamento;

use connect;

class departamento extends connect
{
    private static $message;

    public static function getall()
    {
        try {
            $queryGetAll = 'SELECT t1.idDep, t1.nombreDep AS "departamento", t2.idPais AS "idPais", t2.nombrePais AS "Pais" FROM departamento AS t1';
            $queryGetAll .= ' INNER JOIN pais AS t2 ON t1.idPais = t2.idPais';


            $res = self::getConnection()->prepare($queryGetAll);
            $res->execute();
            self::$message = ["Code" => 200 + $res->rowCount(), "Message" => $res->fetchAll(\PDO::FETCH_ASSOC)];
        } catch (\PDOException $e) {
            self::$message = ["Code" => $e->getCode(), "Message" => $res->errorInfo()[2]];
        } finally {
            echo json_encode(self::$message);
        }
    }

}