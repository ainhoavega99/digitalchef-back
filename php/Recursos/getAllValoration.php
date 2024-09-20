<?php
namespace Recursos;

use Conexion\ConexionPdo;
require __DIR__.'/../vendor/autoload.php';
class getAllValoration
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function obtenerTodos(int $idUsuario): array
    {
        $stmt = $this->pdo->prepare("SELECT id_usuario, id_producto, valor FROM VALORACION WHERE id_usuario = :id_usuario");
        $stmt->execute([
            ":id_usuario" => $idUsuario
        ]);
        $result = $stmt->fetchAll();
        return $result;
    }
}


$valoration = new getAllValoration();
if (isset($_GET['id_usuario'])) {
    $result = $valoration->obtenerTodos($_GET['id_usuario']);

    header('Content-Type: application/json');
    echo json_encode($result);

}
