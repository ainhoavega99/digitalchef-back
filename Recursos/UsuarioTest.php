<?php declare(strict_types=1);

namespace Recursos;

use Comun\TestCase as ModelTestCase;
use Comun\Cifrado;
use Constantes\Usuario as ConstanteUsuario;

class UsuarioTest extends ModelTestCase
{

    protected $resource, $obtenerUsuario, $actualizarUsuario;
    protected static $idUsuario;
    public function setUp(): void
    {
        parent::setUp();
        $this->resource = new insertUser();
        $this->obtenerUsuario = new getUser();
        $this->actualizarUsuario = new updateUser();
        if (is_null(self::$idUsuario)) {
            self::$idUsuario = $this->resource->insertar(
                "prueba",
                $this->resource->generatePasswordHash("abc"),
                "prueba@gmail.com"
            );
        }
    }

    public function testInsertarUsuario()
    {
        $this->assertNotNull(self::$idUsuario);
        $datosUsuario = $this->resource->obtener("prueba@gmail.com");
        $this->assertEquals($datosUsuario['pass'], $this->resource->generatePasswordHash("abc"));
        $this->assertGreaterThan(0, self::$idUsuario);

    }

    public function testLeerUsuario()
    {

        $datosUsuario = $this->obtenerUsuario->obtener("prueba@gmail.com");
       // var_dump($this->idUsuario);
        $this->assertEquals($datosUsuario['email'], "prueba@gmail.com");
        $passDes = $this->obtenerUsuario->desEncriptar($datosUsuario['pass']);
        $this->assertEquals($passDes, "abc");
    }

    public function testActualizarUsuario()
    {

       // var_dump($this->idUsuario);
        $nuevosDatos = (object) [
            'email' => 'prueba@gmail.com',
            'name' => 'pruebaActualizada',
            'id' => self::$idUsuario
        ];
        $this->actualizarUsuario->actualizar($nuevosDatos);
        $datosUsuario = $this->actualizarUsuario->obtener(self::$idUsuario);
        $this->assertEquals($nuevosDatos->name, $datosUsuario['nombre']);
    }


}