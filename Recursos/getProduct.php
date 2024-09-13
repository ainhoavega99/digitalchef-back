<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class getProduct
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function obtenerProduct(int $id): array
    {
        $stmt = $this->pdo->prepare("select id, nombre, descripcion, foto,id_catego, precio from PRODUCTO where id=:id");
        $stmt->execute([":id" => $id]);

        $producto = $stmt->fetch();
        return $producto;
    }
}


if (isset($_GET['id'])) {
    $producto = new getProduct();
    $productoObtenido = $producto->obtenerProduct($_GET['id']);
    $cad = json_encode($productoObtenido);
    header('Content-Type: application/json');
    echo $cad;

}
