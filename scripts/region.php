<?php

namespace App\region;

use connect;

class region extends connect
{
    private static $message;

    public static function getall($id)
    {
        try {
            $queryGetAll = 'SELECT t1.idReg, t1.nombreReg AS "region", t2.idDep AS "idDep", t2.nombreDep AS "Departamento" FROM region AS t1';
            $queryGetAll .= ' INNER JOIN departamento AS t2 ON t1.idDep = t2.idDep';
            $queryGetAll .= ' WHERE t1.idDep = :id';


            $res = self::getConnection()->prepare($queryGetAll);
            $res->bindParam(':id', $id);
            $res->execute();
            self::$message = ["Code" => 200 + $res->rowCount(), "Message" => $res->fetchAll(\PDO::FETCH_ASSOC)];
        } catch (\PDOException $e) {
            self::$message = ["Code" => $e->getCode(), "Message" => $res->errorInfo()[2]];
        } finally {
            echo json_encode(self::$message);
        }
    }

}