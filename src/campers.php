<?php

namespace App\campers;

use connect;

class campers extends connect
{
    private static $message;

    public static function post($data)
    {
        try {
            $query = 'INSERT INTO campers(nombreCamper, apellidoCamper, fechaNac, idReg) VALUES(:nombreCamper, :apellidoCamper, :fechaNac, :idReg)';
            $res = self::getConnection()->prepare($query);
            $res->bindParam(":nombreCamper", $data['nombreCamper']);
            $res->bindParam(":apellidoCamper", $data['apellidoCamper']);
            $res->bindParam(":fechaNac", $data['fechaNac']);
            $res->bindParam(":idReg", $data['idReg']);


            $res->execute();
            self::$message = ["Code" => 200 + $res->rowCount(), "Message" => "inserted data"];
        } catch (\PDOException $e) {
            self::$message = ["Code" => $e->getCode(), "Message" => $res->errorInfo()[2]];
        } finally {
            echo json_encode(self::$message);
        }
    }

    public static function getall()
    {
        try {
            $queryGetAll = 'SELECT t1.idCamper, t1.nombreCamper AS "nombre", t1.apellidoCamper AS "apellido", t1.fechaNac AS "fecha_de_nacimiento", t2.idReg AS "idReg", t2.nombreReg AS "region" FROM campers AS t1';
            $queryGetAll .= ' INNER JOIN region AS t2 ON t1.idReg = t2.idReg';


            $res = self::getConnection()->prepare($queryGetAll);
            $res->execute();
            self::$message = ["Code" => 200 + $res->rowCount(), "Message" => $res->fetchAll(\PDO::FETCH_ASSOC)];
        } catch (\PDOException $e) {
            self::$message = ["Code" => $e->getCode(), "Message" => $res->errorInfo()[2]];
        } finally {
            echo json_encode(self::$message);
        }
    }


    public static function delete($id)
    {
        try {
            $query = 'DELETE FROM campers WHERE idCamper = :id';
            $res = self::getConnection()->prepare($query);
            $res->bindParam(':id', $id);
            $res->execute();
            self::$message = ["Code" => 200 + $res->rowCount(), "Message" => $res->fetchAll(\PDO::FETCH_ASSOC) == [] ? 'Done' : $res->fetchAll(\PDO::FETCH_ASSOC)];
        } catch (\PDOException $e) {
            self::$message = ["Code" => $e->getCode(), "Message" => $res->errorInfo()[2]];
        } finally {
            echo json_encode(self::$message);
        }
    }

    public static function update($id, $data)
    {
        try {
            $query = 'UPDATE campers SET';
            $params = [];

            if ($data['nombreCamper'] !== null) {
                $query .= ' nombreCamper = :nombreCamper,';
                $params[':nombreCamper'] = $data['nombreCamper'];
            }
            if (isset($data['apellidoCamper'])) {
                $query .= ' apellidoCamper = :apellidoCamper,';
                $params[':apellidoCamper'] = $data['apellidoCamper'];
            }
            if (isset($data['fechaNac'])) {
                $query .= ' fechaNac = :fechaNac,';
                $params[':fechaNac'] = $data['fechaNac'];
            }
            if (isset($data['idReg'])) {
                $query .= ' idReg = :idReg,';
                $params[':idReg'] = $data['idReg'];
            }


            // Eliminar la coma final del query
            $query = rtrim($query, ',');

            $query .= ' WHERE idCamper = :id';
            $params[':id'] = $id;

            $res = self::getConnection()->prepare($query);
            $res->execute($params);

            $res->rowCount();

            self::$message = ["Code" => 200, "Message" => $res->fetchAll(\PDO::FETCH_ASSOC)];
        } catch (\PDOException $e) {
            self::$message = ["Code" => $e->getCode(), "Message" => $res->errorInfo()[2]];
        } finally {
            echo json_encode(self::$message);
        }
    }
}