<?php declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';

use Conexion\ConexionPdo;

class getOrderDetail
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function obtener(string $id): array
    {
        $stmt = $this->pdo->prepare("SELECT id, id_producto , cantidad FROM DETALLE_PEDIDO where id_pedido=:id");
        $stmt->execute([":id"=>$id]);

        $result = $stmt->fetchAll();
        return $result;
    }
}

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');
date_default_timezone_set('Europe/Madrid');

$id= $_GET["id_pedido"];
if(isset($id)){

    $detail = new getOrderDetail();
    $result = $detail->obtener($id);

    echo json_encode($result);
}