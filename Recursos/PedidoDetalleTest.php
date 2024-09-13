<?php declare(strict_types=1);

namespace Recursos;

use Comun\TestCase as ModelTestCase;
use Constantes\Usuario as ConstanteUsuario;
use Constantes\Pedido as ConstantePedido;
use Constantes\PedidoDetalle as ConstantePedidoDetalle;

class PedidoDetalleTest extends ModelTestCase
{
    protected $resource, $resourcePedido, $borrar, $actualizar;
    protected static $idPedido, $idDetalle;
    public function setUp(): void
    {
        parent::setUp();
        $this->resource = new insertOrderDetail();
        $this->resourcePedido = new Pedido();
        $this->borrar = new deleteDetailOrder();
        $this->actualizar = new updateDetailOrder();
        if (is_null(self::$idPedido)) {
            $pedido = (object) [
                "id" => 2
            ];
            self::$idPedido = $this->resourcePedido->insertar($pedido);
        }
    }

    public function testInsertarDetalle()
    {
        self::$idDetalle = $this->resource->insertar(
            (object) [
                'order' => (object) [
                    'id' => self::$idPedido
                ],
                'product' => (object) [
                    'id' => 3
                ]
            ]
        );
        $detalles = $this->resource->obtener(self::$idPedido);
        $this->assertEquals(3, $detalles[sizeof($detalles)-1]['id_producto']);
        $this->assertEquals(1, $detalles[sizeof($detalles)-1]['cantidad']);
    }

    public function testBorrarDetalle()
    {
        if (empty(self::$idPedido)) {
            $this->testInsertarDetalle();
        }
       
        $this->borrar->delete(
            (object) [
                'id' => self::$idDetalle
            ]
        );
        $detalleEliminado = $this->resource->obtener(self::$idPedido);
        $this->assertNull($detalleEliminado);
    }

    public function testActualizarDetalle()
    {
        if (empty(self::$idPedido)) {
            $this->testInsertarDetalle();
        }
        self::$idDetalle = $this->resource->insertar(
            (object) [
                'order' => (object) [
                    'id' => self::$idPedido
                ],
                'product' => (object) [
                    'id' => 3
                ],
                'cantidad' => 4
            ]
        );

        $detalle = $this->resource->obtener(self::$idPedido);
        $this->assertEquals(1, $detalle[sizeof($detalle) - 1]['cantidad']);

        $this->actualizar->update(
            (object) [
                'id' => self::$idDetalle,
                'count' => 5
            ]
        );
        $detalleActualizado = $this->resource->obtener(self::$idPedido);
        $this->assertEquals(5, $detalleActualizado[sizeof($detalleActualizado) - 1]['cantidad']);
    }
}
