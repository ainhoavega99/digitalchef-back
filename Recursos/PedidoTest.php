<?php

declare(strict_types=1);

namespace Recursos;

use Comun\TestCase as ModelTestCase;
use DateTime;

class PedidoTest extends ModelTestCase
{
    protected $resource, $obtener, $cerrar, $actualizar;
    protected static $idPedido;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = new Pedido();
        $this->obtener = new getOrder();
        $this->cerrar = new TerrminatedOrder();
        $this->pedidoDetalle = new insertOrderDetail();
        if (is_null(self::$idPedido)) {
            self::$idPedido = $this->resource->insertar((object) [
                "id" => 1
            ]);
        }
    }

    public function testInsertarPedido()
    {
        $this->assertNotNull(self::$idPedido);
        $fecha = new DateTime("now");
        $fechaFormateada = $fecha->format('Y-m-d H:i:s');
        $datosPedido = $this->resource->obtener(self::$idPedido);
        $this->assertEquals($datosPedido['id_usuario'], 1);
        $this->assertEquals($datosPedido['fecha'], $fechaFormateada);
        $this->assertEquals($datosPedido['total'], 0.0);

    }



    public function testCerrarPedido()
    {

        $datosPedido = $this->resource->obtener(self::$idPedido);
        $this->assertEquals($datosPedido['terminado'], 0);
        $cerrado = $this->cerrar->closedOrder(self::$idPedido);
        $this->assertTrue($cerrado);
        $datosPedidoActualizado = $this->resource->obtener(self::$idPedido);
        $this->assertEquals($datosPedidoActualizado['terminado'], 1);
    }


}