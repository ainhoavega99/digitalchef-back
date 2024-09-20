<?php
namespace Constantes;

class Constantes
{
    private static $const = [
        'CLAVE' => 'PasswordUsuario',
        'ALGORITMO' => 'aes-128-ctr',
        'IV' => 'zzzzzzzzzzzzzzzz',
        'JWT_SECRET' => '651500170'
    ];
    public static function get($key)
    {
        if (array_key_exists($key, self::$const)) {
            return self::$const[$key];
        }

        throw new \Exception("Config key '$key' not found.");
    }
}