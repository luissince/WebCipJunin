<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $request = (object)$body;
    if ($request->type == "valid") {
        echo json_encode(Registrar::valid($request));
        exit;
    } else if ($request->type == "save") {
        echo json_encode(Registrar::save($request));
        exit;
    }
}

class Registrar
{

    public static function valid($request)
    {
        $user = Database::getInstance()->getDb()->prepare('SELECT * FROM Persona WHERE NumDoc = ? AND CIP = ?');
        $user->execute(array(
            $request->dni,
            $request->cip,
        ));
        $resultUser = $user->fetchObject();

        if ($resultUser) {
            if ($resultUser->Clave !== null) {
                return array(
                    'state' => 2,
                    'message' => "Usted ya tiene una cuenta registrar, restablezca su cuenta para obtener una nueva."
                );
            } else {
                return array(
                    'state' => 1,
                    'user' => $resultUser,
                );
            }
        } else {
            return array(
                'state' => 0,
                'message' => "Datos no encontrados.",
            );
        }
    }

    public static function save($request)
    {
        try {
            $user = Database::getInstance()->getDb()->prepare('SELECT * FROM Persona WHERE idDNI = ?');
            $user->execute(array(
                $request->idDNI
            ));

            if ($user->fetchObject()) {
                Database::getInstance()->getDb()->beginTransaction();

                $persona = Database::getInstance()->getDb()->prepare('UPDATE Persona SET Clave = ? WHERE idDNI = ?');
                $persona->execute(array(
                    password_hash($request->password, PASSWORD_DEFAULT),
                    $request->idDNI
                ));

                $web = Database::getInstance()->getDb()->prepare('DELETE FROM Web where idDNI = ?');
                $web->execute(array($request->idDNI));

                $insert = Database::getInstance()->getDb()->prepare('INSERT INTO Web(idDNI,Tipo,Direccion) VALUES(?,16,?)');
                $insert->execute(array(
                    $request->idDNI,
                    $request->email
                ));

                Database::getInstance()->getDb()->commit();
                return array(
                    'state' => 1,
                    'message' => "Se guardo correctamente su contraseña, ahora puede ingresar al sistema usando su n° cip y su clave.",
                );
            } else {
                return array(
                    'state' => 2,
                    'message' => "Se pudo validar los datos, intente nuevamente en un parte de minutos.",
                );
            }
        } catch (PDOException $e) {
            Database::getInstance()->getDb()->rollBack();
            return array(
                'state' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
            );
        }
    }
}
