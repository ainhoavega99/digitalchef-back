<?php declare(strict_types=1);

namespace Comun;

use SimpleXMLElement;

class CargarFijo extends Cargar
{
    public static function cargarXml(string $path): ?SimpleXMLElement
    {
        if (self::ErrorSiNoExisteFichero($path)) {
            return new SimpleXMLElement(file_get_contents($path));
        }
        return null;
    }
    public static function cargar(string $path): ?string
    {
        if (self::ErrorSiNoExisteFichero($path)) {
            return file_get_contents($path);
        }
        return null;
    }

}