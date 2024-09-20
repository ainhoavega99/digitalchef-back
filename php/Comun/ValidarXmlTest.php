<?php declare(strict_types=1);

namespace Comun;

use Constantes\Entorno;

class ValidarXmlTest extends TestCase
{

    public function testXmlValido()
    {
        $cadenaXml = CargarFijo::cargar(__DIR__."/../Mocks/categorias.xml");
        $xsd = CargarFijo::cargar(__DIR__."/../Mocks/categoria.xsd");
        $this->assertTrue(ValidarXml::validar($cadenaXml, $xsd));
    }

    public function testXmlQueFalla()
    {
        $cadenaXml = CargarFijo::cargar(__DIR__."/../Mocks/productsFake.xml");
        $xsd = CargarFijo::cargar(__DIR__."/../Mocks/product.xsd");
        $this->assertFalse(ValidarXml::validar($cadenaXml, $xsd));
    }
}
