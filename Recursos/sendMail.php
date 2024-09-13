<?php

namespace Recursos;

use Conexion\ConexionPdo;

require_once __DIR__ . '/Mail.php';

class SendMail
{
    public $conexion, $pdo, $cifrar;

    public function __construct()
    {
        $this->conexion = new ConexionPdo();
        $this->pdo = $this->conexion::conectar(".env");
        $this->cifrar = new insertUser();
    }

    public function actualizar(string $emailUser, string $pass)
    {
        if ($this->cifrar->generatePasswordHash($pass)) {

            $stmt = $this->pdo->prepare("UPDATE USUARIO set pass=:pass
             where email=:email");
            $stmt->execute([
                ":pass" => $this->cifrar->generatePasswordHash($pass),
                ":email" => $emailUser

            ]);
        }
    }


    function generaPass(): string
    {
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $longitudCadena = strlen($cadena);
        $pass = "";
        $longitudPass = 6;
        for ($i = 1; $i <= $longitudPass; $i++) {
            $pos = rand(0, $longitudCadena - 1);
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }


}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$json = file_get_contents('php://input');

$params = json_decode($json);


if (!is_null($params)) {
    $email = $params->email;

    $actualizarPass = new sendMail();

    $mail = new Mail("al.ainhoa.vega.sanchez@iesportada.org", "ifup mgjc yztj vrtw", "DigitalChef");

    $pass = $actualizarPass->generaPass();

    $actualizarPass->actualizar($email, $pass);
    $correo = [
        "title" => "Prueba de correo",
        "body" => "Esta es su nueva contraseña: $pass",
        "para" => $email
    ];

    $mail->enviarCorreo($correo);
    
     class Result
    {
        public $resultado;
        public $mensaje;
    }
    
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'datos modificados';

    header('Content-Type: application/json');
    echo json_encode($response);

}

