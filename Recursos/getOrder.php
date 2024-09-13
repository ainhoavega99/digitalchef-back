<?php declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class getOrder{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function obtener(int $id):array{
        $stmt = $this->pdo->prepare(
            "SELECT id, fecha, id_usuario, total, terminado FROM PEDIDO 
                             where id_usuario=:idUsuario");
        $stmt->execute([
            "idUsuario"=>$id
        ]);
        $result = $stmt->fetchAll();
       return $result;
    }
}



if(isset($_GET["id_usuario"])) {
    $pedido = new getOrder();
    $result = $pedido->obtener($_GET["id_usuario"]);
echo json_encode($result);
}