<?php declare(strict_types=1);

namespace Recursos;
require __DIR__.'/../vendor/autoload.php';
use Conexion\ConexionPdo;

const XML = __DIR__.'/../Mocks/categorias.xml';
class insertCategoria
{
    public $conexion, $pdo, $categoriaClass;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
        $this->categoriaClass = new Categoria();
    }

    public function cargarXml($xmlFile): void
    {
        $xml = simplexml_load_file($xmlFile);
        if ($xml === false) {
            exit('Error al cargar el archivo XML.');
        }

        $categorias = $xml->categoria;
        foreach ($categorias as $categoria) {
            $this->categoriaClass->insertar($categoria);
        }
    }


}

$categoria= new insertCategoria();
$categoria->cargarXml(XML);