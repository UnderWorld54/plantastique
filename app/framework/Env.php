<?php

namespace Framework;

class Env
{
    public static function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new \Exception("Fichier env pas trouvé à $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // plusieurs raison possible pour cette erreur du style permissions fihicer corrompu etc
        if ($lines === false) {
            throw new \Exception("fichier env pas lisible à $ath");
        }

        foreach ($lines as $line) {
            $line = trim($line);

            // certaines lignes vides semblent passé malgré le FILE_SKIP_EMPTY_LINES (à revoir ?)
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            if (strpos($line, '=') === false) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
            putenv("$name=$value");
        }
    }
}