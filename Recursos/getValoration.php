<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class getValoration
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function obtenerMedia(int $param): float
    {
        $stmt = $this->pdo->prepare("SELECT AVG(valor) FROM VALORACION where id_producto=:id_producto");
        $stmt->execute([
            ":id_producto" => $param
        ]);
        $result = $stmt->fetchColumn();
        return (float)$result;
    }
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id_producto'])) {
    $valoration = new getValoration();
    $result = $valoration->obtenerMedia($_GET['id_producto']);
    if($result==0.0){
        $result=5.0;
    }
    echo json_encode(['media' => (float)$result]);
} 
