<?php declare(strict_types=1);


namespace Recursos;

use Comun\TestCase as ModelTestCase;

class CategoriaTest extends ModelTestCase
{
    protected $resource, $idCategoria;

    public function setUp(): void
    {
        $this->resource = new Categoria();
    }

    public function testInsertarCategoria()
    {
        $categoria = (object) ["nombre"=>"pruebaTest"];
        $this->idCategoria = $this->resource->insertar($categoria);
        $datosCategoria = $this->resource->obtener($this->idCategoria);
        $this->assertEquals($datosCategoria['nombre'],"pruebaTest");
        $this->assertGreaterThan(0, $this->idCategoria);
    }

    public function testLeerCategoria()
    {
        if (empty($this->idCategoria)) {
            $this->testInsertarCategoria();
        }
        $datosCategoria = $this->resource->obtener($this->idCategoria);
        $this->assertEquals($datosCategoria['nombre'], "pruebaTest");
    }

}