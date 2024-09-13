<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;


class insertOrderDetail{
    public $linkPdo, $pdo;

    public function __construct()
    {
        $this->linkPdo = new ConexionPdo();
        $this->pdo = $this->linkPdo::conectar(".env");
    }

    public function insertar(object $params): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO DETALLE_PEDIDO (id_pedido, id_producto, cantidad) VALUES (:id_pedido, :id_producto, :cantidad)");
        $stmt->execute([
            ":id_pedido"=>$params->order->id,
            ":id_producto"=>$params->product->id,
            ":cantidad"=>1
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function obtener(int $idPedido): ?array
    {
        $result = null;
        $sql = "SELECT id, id_pedido, id_producto, cantidad FROM DETALLE_PEDIDO WHERE id_pedido=:id_pedido";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id_pedido" => $idPedido]);
        if ($rs = $stmt->fetchAll()) {
            $result = $rs;
        }
        return $result;
    }
}

$json = file_get_contents('php://input');

$params = json_decode($json);

if (!is_null($params)) {
    $orderDetail = new insertOrderDetail();
    $orderDetail->insertar($params);
}