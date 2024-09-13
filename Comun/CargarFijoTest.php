<?php declare(strict_types=1);

namespace Comun;

use Constantes\Entorno;
use SimpleXMLElement;

class CargarFijoTest extends TestCase
{
    public function testExisteElFicheroXml()
    {
        $xml = CargarFijo::cargarXml(__DIR__."/../Mocks/categorias.xml");
        $this->assertTrue($xml instanceof SimpleXMLElement);
    }
}