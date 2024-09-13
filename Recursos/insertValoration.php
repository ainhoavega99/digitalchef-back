<?php declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class insertValoration
{

    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function insertar(object $params): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO VALORACION (id_producto, id_usuario, valor) VALUES (:id_producto, :id_usuario, :valor)");
        $stmt->execute([
            ":id_producto" => $params->id_producto,
            ":id_usuario" => $params->user->id,
            ":valor" => $params->valor
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function obtener(object $params): array | false
    {
        $stmt = $this->pdo->prepare("SELECT id, valor, id_producto, valor, id_usuario FROM VALORACION where id_producto=:id_producto and id_usuario=:id_usuario");
        $stmt->execute([
            ":id_producto" => $params->id_producto,
            ":id_usuario" => $params->user->id
        ]);
        $valoracion = $stmt->fetch();
        return $valoracion;
    }

    public function obtenerPorId(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT id, valor, id_producto, valor, id_usuario FROM VALORACION where id=:id");
        $stmt->execute([
            ":id" => $id,

        ]);
        $valoracion = $stmt->fetch();
        return $valoracion;
    }

    public function actualizar(object $params): void
    {
        $stmt = $this->pdo->prepare("UPDATE VALORACION set valor=:valor where id_producto=:id_producto and id_usuario=:id_usuario");
        $stmt->execute([
            ":valor" => $params->valor,
            ":id_producto" => $params->id_producto,
            ":id_usuario" => $params->user->id
        ]);

    }

}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$json = file_get_contents('php://input');
$params = json_decode($json);

if (!is_null($params)) {
    $valoration = new insertValoration();

    $valoracionObtenida = $valoration->obtener($params);
    if (!$valoracionObtenida) {
        $valoration->insertar($params);
    } else {
        $valoration->actualizar($params);
    }

    
}