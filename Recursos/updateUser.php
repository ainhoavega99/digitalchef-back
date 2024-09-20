<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class updateUser
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function actualizar(object $params)
    {
        $stmt = $this->pdo->prepare("UPDATE USUARIO set nombre=:nombre, email=:email
 where id=:id");
        $stmt->execute([
            ":nombre" => $params->name,
            ":email" => $params->email,
            ":id"=>$params->id
        ]);
    }

    public function obtener(int $id):array{
        $stmt = $this->pdo->prepare("SELECT nombre, email FROM USUARIO
 where id=:id");
        $stmt->execute([
            ":id"=>$id
        ]);
        $usuario = $stmt->fetch();
        return $usuario;
    }
}


$json = file_get_contents('php://input');

$params = json_decode($json);

if (!is_null($params)) {
    $user = new updateUser();
    $user->actualizar($params);

    class Result
    {
        public $resultado;
        public $mensaje;
    }

    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'datos modificados';

    header('Content-Type: application/json');
    echo json_encode($response);
}