<?php declare(strict_types=1);

namespace Comun;

use Exception;

class Cargar
{
    public static function ErrorSiNoExisteFichero(string $path): bool
    {
        if (!file_exists($path)) {
            throw new Exception('El fichero "' . $path . '" no existe');
        }
        return true;
    }
}