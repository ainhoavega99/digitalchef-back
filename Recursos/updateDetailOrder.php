<?php
declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class updateDetailOrder
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function update(object $params)
    {
        $stmt = $this->pdo->prepare("UPDATE DETALLE_PEDIDO set cantidad = :cantidad
 where id=:id");
        $stmt->execute([
            "cantidad" => $params->count,
            ":id" => $params->id
        ]);
    }
}

$json = file_get_contents('php://input');

$params = json_decode($json);

if (!is_null($params)) {
    $detalle = new updateDetailOrder();
    $detalle->update($params);

    class Result
    {
    }

    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'datos modificados';

    header('Content-Type: application/json');
    echo json_encode($response);
}