<?php 
namespace Recursos;

require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;


class  InsertProduct{
    public $conexion, $pdo, $productoClass;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
        
    }

    public function cargarXml($xmlFile): void
    {
        $xml = simplexml_load_file($xmlFile);
        if ($xml === false) {
            exit('Error al cargar el archivo XML.');
        }

        $productos = $xml->producto;
        foreach ($productos as $producto) {
            $this->insertar($producto);
        }
    }

    public function insertar(object $datosCategoria): int
    {
        $sql = "INSERT INTO PRODUCTO (nombre ,descripcion, foto,id_catego, precio) VALUES (:nombre, :descripcion, :foto,:id_catego, :precio)";
        $this->pdo->prepare($sql)->execute([
            ":nombre" =>(string)$datosCategoria->nombre,
            ":descripcion"=>(string)$datosCategoria->descripcion,
            ":foto"=>(string)$datosCategoria->foto,
            ":id_catego"=>(integer)$datosCategoria->id_catego,
            ":precio"=>(float)$datosCategoria->precio
        ]);
        return (int)$this->pdo->lastInsertId();
    }

}

const XML= __DIR__."/../Mocks/products.xml";
$producto= new InsertProduct();
$producto->cargarXml(XML);

