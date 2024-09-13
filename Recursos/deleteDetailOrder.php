<?php declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class deleteDetailOrder
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function delete(object $params)
    {
        $stmt = $this->pdo->prepare("DELETE FROM DETALLE_PEDIDO  where id=:id");
        $stmt->execute([
            ":id" => $params->id
        ]);

    }
}

$json = file_get_contents('php://input');

$params = json_decode($json);
if (!is_null($params)) {
    $detail = new deleteDetailOrder();
    $detail->delete($params);

    class Result
    {
    }

    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'datos eliminados';

    header('Content-Type: application/json');
    echo json_encode($response);
}