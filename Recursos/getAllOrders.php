<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class getAllOrders{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function obtenerTodos():array{
        $stmt = $this->pdo->prepare("select id, fecha, id_usuario, total, terminado from PEDIDO");
        $stmt->execute();
        $registros = $stmt->fetchAll();
        $prod = [];
        foreach ($registros as $reg) {
            $prod[] = $reg;
        }
        return $prod;
    }
}


    $orders = new getAllOrders();
    $allOrders = $orders->obtenerTodos();
    $cad = json_encode($allOrders);
    echo $cad;

