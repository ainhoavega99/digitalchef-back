<?php
namespace Recursos;

use Constantes\Constantes;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;


class insertUser
{
    public $conexion, $pdo;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
    }

    public function obtener(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT nombre, pass, email from USUARIO where email=:email");
        $stmt->execute([
            ":email" => $email
        ]);
        $usuario = $stmt->fetch();
        return $usuario;
    }

    public function insertar(string $nombre, string $pass, string $email): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO USUARIO(id, nombre, pass, email) VALUES(NULL,:nombre, :pass, :email)");
        $stmt->execute([
            ":nombre" => $nombre,
            ":pass" => $pass,
            ":email" => $email
        ]);
        return $this->pdo->lastInsertId();
    }

    public function generatePasswordHash($cadena)
    {
        return openssl_encrypt(
            $cadena,
            Constantes::get('ALGORITMO'),
            Constantes::get('CLAVE'),
            0,
            Constantes::get('IV')
        );
    }

  
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$json = file_get_contents('php://input');
$params = json_decode($json);

if (!is_null($params)) {
    $email = $params->email;
    $pass = $params->pass;
    $nombre = $params->name;

    $user = new insertUser();

    $pass = $user->generatePasswordHash($pass);

    $usuario = $user->obtener($email);
    if (!$usuario) {
        $user->insertar($nombre, $pass, $email);
        $usuario= $user->obtener($email);
    } 
    

    header('Content-Type: application/json');
    echo json_encode($usuario);
}
