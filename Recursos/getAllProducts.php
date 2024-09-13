<?php

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class getAllProducts{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function obtenerTodos(int $idCategoria):array{
        $stmt = $this->pdo->prepare("select id,nombre, descripcion, foto,id_catego, precio from PRODUCTO WHERE id_catego=:id_catego");
        $stmt->execute([":id_catego"=>$idCategoria]);
        $registros = $stmt->fetchAll();
        $prod = [];
        foreach ($registros as $reg) {
            $prod[] = $reg;
        }
        return $prod;
    }
}


if(isset($_GET['id_catego'])){
    $products = new getAllProducts();
    $allProducts = $products->obtenerTodos($_GET['id_catego']);
    $cad = json_encode($allProducts);
    echo $cad;

}




