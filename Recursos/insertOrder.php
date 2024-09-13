<?php 

namespace Recursos;

require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;
use DateTime;
class Pedido
{
    public $linkPdo, $pdo;

    public function __construct()
    {
        $this->linkPdo = new ConexionPdo();
        $this->pdo = $this->linkPdo::conectar(".env");
    }


    public function insertar(object $params): int
    {
        $fecha = new DateTime("now");
        $fechaFormateada = $fecha->format('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare("INSERT INTO PEDIDO(fecha, id_usuario) VALUES(:fecha, :id_usuario)");
        $stmt->execute([
            ":fecha" => $fechaFormateada,
            ":id_usuario" => $params->id
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function obtener(int $idPedido): array
    {
        $stmt = $this->pdo->prepare("SELECT id, id_usuario, fecha, total, terminado FROM PEDIDO WHERE id=:id");
        $stmt->execute([
            ":id" => $idPedido
        ]);
        $order = $stmt->fetch();
        return $order;
    }

}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$json = file_get_contents('php://input');
$params = json_decode($json);

if (!is_null($params)) {
    $order = new Pedido();
    $id = $order->insertar($params);
    $nuevoOrder = $order->obtener($id);
    header('Content-Type: application/json');
    echo json_encode($nuevoOrder);
}