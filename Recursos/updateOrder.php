<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class updateOrder
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function obtenerDetalle(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT id_producto, cantidad FROM DETALLE_PEDIDO where id_pedido=:id");
        $stmt->execute([
            ":id" => $id
        ]);
        $details = $stmt->fetchAll();
        return $details;
    }

    public function obtenerPrecio(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT precio FROM PRODUCTO WHERE id=:id_producto");
        $stmt->execute([
            ":id_producto" => $id
        ]);
        $precio = $stmt->fetch();
        return $precio;
    }

    public function actualizar(float $total, int $id)
    {
        $stmt = $this->pdo->prepare("UPDATE PEDIDO set total = :total where id=:id");
        $stmt->execute([
            ":total" => $total,
            ":id" => $id
        ]);
    }

    public function obtener(int $id):array{
        $stmt = $this->pdo->prepare("SELECT id, id_usuario, total FROM PEDIDO where id=:id");
        $stmt->execute([
            ":id" => $id
        ]);
        $order = $stmt->fetch();
        return $order;
    }

}


$json = file_get_contents('php://input');
$params = json_decode($json);
$id = $params->id;

$order = new updateOrder();

$details = $order->obtenerDetalle($id);
$total = 0;

foreach ($details as $detail) {
    $precio = $order->obtenerPrecio($detail['id_producto']);
    $total += $precio['precio'] * $detail['cantidad'];
}
$order->actualizar($total, $id);

$pedidoActualizado = $order->obtener($id);

header('Content-Type: application/json');
echo json_encode($pedidoActualizado);