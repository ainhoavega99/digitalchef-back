<?php declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

class Categoria
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }


    public function insertar(object $datosCategoria): int
    {
        $sql = "INSERT INTO CATEGORIA (nombre) VALUES (:nombre)";
        $this->pdo->prepare($sql)->execute([
            ":nombre" => (string)$datosCategoria->nombre,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function obtener(int $idCategoria): ?array
    {
        $result = null;
        $sql = "SELECT id , nombre FROM CATEGORIA WHERE id=:idCategoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":idCategoria" => $idCategoria]);
        if ($rs = $stmt->fetch()) {
            $result = $rs;
        }
        return $result;
    }

}

