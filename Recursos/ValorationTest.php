<?php declare(strict_types=1);

namespace Recursos;

use Comun\TestCase as ModelTestCase;

class ValorationTest extends ModelTestCase
{
    protected $resource, $media, $todos;
    protected static $idValoracion;
    public function setUp(): void
    {
        $this->resource = new insertValoration();
        $this->media = new getValoration();
        $this->todos = new getAllValoration();
    }

    public function testInsertarValoracion()
    {
        $valoracion = (object) [
            "valor" => 4,
            "id_producto" => 3,
            "user" => (object)["id" => 2]
        ];
        self::$idValoracion = $this->resource->insertar($valoracion);
        $datosValoracion = $this->resource->obtenerPorId(self::$idValoracion);
        $this->assertEquals($datosValoracion['valor'], 4);
        $this->assertEquals($datosValoracion['id_usuario'], 2);
        $this->assertEquals($datosValoracion['id_producto'], 3);
        $this->assertGreaterThan(0, self::$idValoracion);
    }

    public function testLeerValoracion()
    {
        if (empty(self::$idValoracion)) {
            $this->testInsertarValoracion();
        }
        $datosValoracion = $this->resource->obtenerPorId(self::$idValoracion);
        $this->assertEquals($datosValoracion['id'], self::$idValoracion);
        $this->assertEquals($datosValoracion['id_producto'], 3);
        $this->assertEquals($datosValoracion['id_usuario'], 2);
        $this->assertEquals($datosValoracion['valor'], 4.0);
    }


    public function testObtenerTodos()
    {
        $datosValoracion = $this->todos->obtenerTodos(2);
        $this->assertEquals($datosValoracion[0]["id_usuario"], 2);
        $this->assertEquals($datosValoracion[0]["id_producto"], 3);
        $this->assertEquals($datosValoracion[0]["valor"], 4);
    }
    
    public function testActualizarValoracion()
    {
        if (empty(self::$idValoracion)) {
            $this->testInsertarValoracion();
        }
        $nuevosDatos = (object)[
            'valor' => 1.0,
            'id_producto' => 3,
            "user" => (object)["id" => 2]
        ];
        $this->resource->actualizar($nuevosDatos);
        $datosValoracion = $this->resource->obtenerPorId(self::$idValoracion);
        $this->assertEquals($datosValoracion['valor'], 1.0);
    }

    public function testObtenerMedia()
    {
        $datosValoracion = $this->media->obtenerMedia(2);
        $this->assertEquals($datosValoracion,3.0); 
    }

  
}
